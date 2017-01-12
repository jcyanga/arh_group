<?php

namespace backend\controllers;

use Yii;
use common\models\Quotation;
use common\models\SearchQuotation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Service;
use common\models\Inventory;
use common\models\QuotationDetail;
use common\models\Product;
use common\models\Gst;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\ProductLevel;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Quotation'])->andWhere(['role_id' => $uRId ] )->all();
            $actionArray = [];
            foreach ( $permission as $p )  {
                $actionArray[] = $p->action;
            }

            $allow[$uRName] = false;
            $action[$uRName] = $actionArray;
            if ( ! empty( $action[$uRName] ) ) {
                $allow[$uRName] = true;
            }

        }   
        // print_r($action['developer']); exit;
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    
                    [
                        'actions' => $action['developer'],
                        'allow' => $allow['developer'],
                        'roles' => ['developer'],
                    ],

                    [
                        'actions' => $action['admin'],
                        'allow' => $allow['admin'],
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => $action['staff'],
                        'allow' => $allow['staff'],
                        'roles' => ['staff'],
                    ]
       
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getQuotation = $searchModel->getQuotation();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'getQuotation' => $getQuotation, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Quotation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $model = new Quotation();
         $getLastInsertQuotation = $model->getLastInsertQuotation($id); 
         $getLastInsertQuotationServiceDetail = $model->getLastInsertQuotationServiceDetail($id); 
         $getLastInsertQuotationPartDetail = $model->getLastInsertQuotationPartDetail($id);

        return $this->render('view',[
                'model' => $this->findModel($id),
                'customerInfo' => $getLastInsertQuotation,
                'services' => $getLastInsertQuotationServiceDetail,
                'parts' => $getLastInsertQuotationPartDetail
            ]);
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quotation();
        $details = new QuotationDetail();

        $quotationId = $this->_getQuotationId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            
            $quotationCode = Yii::$app->request->post('Quotation')['quotationCode'];
            $dateIssue = Yii::$app->request->post('Quotation')['dateIssue'];
            $selectedBranch = Yii::$app->request->post('Quotation')['selectedBranch'];
            $selectedCustomer = Yii::$app->request->post('Quotation')['selectedCustomer'];
            $selectedUser = Yii::$app->request->post('Quotation')['selectedUser'];
            $remarks = Yii::$app->request->post('Quotation')['remarks'];

            $grand_total = Yii::$app->request->post('Quotation')['grand_total'];
            $getGst = Gst::find()->where(['branch_id' => $selectedBranch])->one();

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('create', [
                        'model' => $model,
                        'quotationId' => $quotationId,
                        'getBranchList' => $getBranchList,
                        'getUserList' => $getUserList,
                        'getCustomerList' => $getCustomerList,
                        'getServicesList' => $getServicesList,
                        'getPartsList' => $getPartsList, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'Fill-up all the fields.'
                    ]);

            }

            if( isset($getGst) ) {
                $totalWithGst = ($grand_total * $getGst->gst);
            }else {
                $totalWithGst = ($grand_total + 0);
            }

            $created_by = Yii::$app->user->identity->id;
            $created_at = date("Y-m-d");
            $delete = 0;

            $model->quotation_code = $quotationCode;
            $model->user_id = $selectedUser;
            $model->customer_id = $selectedCustomer;
            $model->branch_id = $selectedBranch;
            $model->date_issue = $dateIssue;
            $model->grand_total = $totalWithGst;
            $model->remarks = $remarks;
            $model->created_by = $created_by;
            $model->created_at = $created_at;
            $model->updated_at = $created_at;
            $model->updated_by = $created_by;
            $model->delete = $delete;
            $model->task = 0;
            $model->paid = 0;

            if ( $model->save() ) {
                
                $quotationId = $model->id;

                if( $details->load(Yii::$app->request->post()) ) {
                
                    $arrLen = count( Yii::$app->request->post('QuotationDetail')['quantity'] );
                    $service_part_id = Yii::$app->request->post('QuotationDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('QuotationDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('QuotationDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('QuotationDetail')['subTotal'];
                    
                    foreach ($quantity as $key => $value) {
                        $quoD = new QuotationDetail();

                        $getServicePart = explode('-', $service_part_id[$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['product_id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;
                            
                            Yii::$app->db->createCommand()
                                ->update('inventory', ['quantity' => $totalQty ], "product_id = $getServicePartId" )
                                ->execute();
                        }

                        $quoD->quotation_id = $quotationId;
                        $quoD->service_part_id = $getServicePartId;
                        $quoD->quantity = $value;
                        $quoD->selling_price = $selling_price[$key];
                        $quoD->subTotal = $subTotal[$key];
                        $quoD->created_at = $created_at;
                        $quoD->created_by = $created_by;
                        $quoD->type = $getType;
                        
                        if ( isset(Yii::$app->request->post('QuotationDetail')['task'][$key]) ) {
                            $quoD->task = 1;

                        }else{
                            $quoD->task = 0;
                            
                        }

                        $quoD->save();

                    }
                 
                 return $this->redirect(['view', 'id' => $model->id]);

                }
            }
            
        } else {

            return $this->render('create', [
                'model' => $model,
                'quotationId' => $quotationId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            ]);
        }
    }

    public function actionPreview($id) {
         $this->layout = 'print';
         
         $model = new Quotation();
         $getLastInsertQuotation = $model->getLastInsertQuotation($id); 
         $getLastInsertQuotationServiceDetail = $model->getLastInsertQuotationServiceDetail($id); 
         $getLastInsertQuotationPartDetail = $model->getLastInsertQuotationPartDetail($id);

        return $this->render('preview',[
                'model' => $this->findModel($id),
                'customerInfo' => $getLastInsertQuotation,
                'services' => $getLastInsertQuotationServiceDetail,
                'parts' => $getLastInsertQuotationPartDetail
            ]);
    }


    public function _getQuotationId() {
        $model = new Quotation();
        $result = $model->getQuotationId();

        return $result;
    }

    /**
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new Quotation();
        $details = new QuotationDetail();

        $getQuotation = $model->getQuotation($id);
        $getService = $model->getQuotationDetailService($id);
        $getPart = $model->getQuotationDetailPart($id);
        $getLastId = $model->getLastId($id);

        $quotationId = $this->_getQuotationId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            
            Yii::$app->db->createCommand()
            ->delete('quotation', "id = $id" )
            ->execute();

            $quotationCode = Yii::$app->request->post('Quotation')['quotationCode'];
            $dateIssue = Yii::$app->request->post('Quotation')['dateIssue'];
            $selectedBranch = Yii::$app->request->post('Quotation')['selectedBranch'];
            $selectedCustomer = Yii::$app->request->post('Quotation')['selectedCustomer'];
            $selectedUser = Yii::$app->request->post('Quotation')['selectedUser'];
            $remarks = Yii::$app->request->post('Quotation')['remarks'];

            $grand_total = Yii::$app->request->post('Quotation')['grand_total'];
            $getGst = Gst::find()->where(['branch_id' => $selectedBranch])->one();

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('update', [
                        'model' => $model,
                        'quotationId' => $quotationId,
                        'getBranchList' => $getBranchList,
                        'getUserList' => $getUserList,
                        'getCustomerList' => $getCustomerList,
                        'getServicesList' => $getServicesList,
                        'getPartsList' => $getPartsList, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'Fill-up all the fields.'
                    ]);

            }

            if( isset($getGst) ) {
                $totalWithGst = ($grand_total * $getGst->gst);
            }else {
                $totalWithGst = ($grand_total + 0);
            }

            $created_by = Yii::$app->user->identity->id;
            $created_at = date("Y-m-d");
            $delete = 0;

            $model->quotation_code = $quotationCode;
            $model->user_id = $selectedUser;
            $model->customer_id = $selectedCustomer;
            $model->branch_id = $selectedBranch;
            $model->date_issue = $dateIssue;
            $model->grand_total = $totalWithGst;
            $model->remarks = $remarks;
            $model->created_by = $created_by;
            $model->created_at = $created_at;
            $model->updated_at = $created_at;
            $model->updated_by = $created_by;
            $model->delete = $delete;
            $model->task = 0;
            $model->paid = 0;

            if ( $model->save() ) {
                
                $quotationId = $model->id;

                if( $details->load(Yii::$app->request->post()) ) {
                    
                    Yii::$app->db->createCommand()
                    ->delete('quotation_detail', "quotation_id = $id" )
                    ->execute();

                    $arrLen = count( Yii::$app->request->post('QuotationDetail')['quantity'] );
                    $service_part_id = Yii::$app->request->post('QuotationDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('QuotationDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('QuotationDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('QuotationDetail')['subTotal'];
                    
                    foreach ($quantity as $key => $value) {
                        $quoD = new QuotationDetail();

                        $getServicePart = explode('-', $service_part_id[$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['product_id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;
                            
                            Yii::$app->db->createCommand()
                                ->update('inventory', ['quantity' => $totalQty ], "product_id = $getServicePartId" )
                                ->execute();
                        }

                        $quoD->quotation_id = $quotationId;
                        $quoD->service_part_id = $getServicePartId;
                        $quoD->quantity = $value;
                        $quoD->selling_price = $selling_price[$key];
                        $quoD->subTotal = $subTotal[$key];
                        $quoD->created_at = $created_at;
                        $quoD->created_by = $created_by;
                        $quoD->type = $getType;
                        
                        if ( isset(Yii::$app->request->post('QuotationDetail')['task'][$key]) ) {
                            $quoD->task = 1;

                        }else{
                            $quoD->task = 0;
                            
                        }

                        $quoD->save();

                    }
                 
                 return $this->redirect(['view', 'id' => $model->id]);

                }
            }

        } else {
            
            return $this->render('update', [
                'model' => $getQuotation, 
                'getService' => $getService,
                'getPart' => $getPart,
                'getLastId' => $getLastId,
                'quotationId' => $quotationId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            
            ]);
        
        }

    }

    /**
     * Deletes an existing Quotation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteColumn($id)
    {
        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        Yii::$app->db->createCommand()
            ->delete('quotation_detail', "quotation_id = $id" )
            ->execute();

        $getQuotation = $searchModel->getQuotation();

        return $this->render('index', ['searchModel' => $searchModel, 'getQuotation' => $getQuotation,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    public function actionDeleteSelectedQuotationDetail($id)
    {
        Yii::$app->db->createCommand()
            ->delete('quotation_detail', "quotation_id = $id" )
            ->execute();

        $model = new Quotation();

        $getQuotation = $model->getQuotation($id);
        $getService = $model->getQuotationDetailService($id);
        $getPart = $model->getQuotationDetailPart($id);
        $getLastId = $model->getLastId($id);

        $quotationId = $this->_getQuotationId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        return $this->render('update', [
                'model' => $getQuotation, 
                'getService' => $getService,
                'getPart' => $getPart,
                'getLastId' => $getLastId,
                'quotationId' => $quotationId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            
            ]);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrice() {

        $this->layout = false;

        if( Yii::$app->request->post() ) {

            $getItemType = explode('-', Yii::$app->request->post()['services_parts']);
            $ItemType = $getItemType[0];
            $ItemId = $getItemType[1];

            $itemSellingPrice = false;

            if( $ItemType == '0' ) {
                $service = Service::find()->where(['id' => $ItemId])->one();
                $itemSellingPrice = $service->default_price;;
                
            }else{
                $part = Inventory::find()->where(['product_id' => $ItemId])->one();
                $itemQty = $part->quantity;
                
                $getPartLevel = ProductLevel::find()->one();
                $criticalLvl = $getPartLevel->critical_level;
                $minimumLvl = $getPartLevel->minimum_level;

                switch($itemQty) {
                    case $minimumLvl:
                        $itemSellingPrice = 'minimum_level';
                     break;
                    
                    case $criticalLvl:
                        $itemSellingPrice = 'critical_level';
                     break;
                    
                    case 0:
                        $itemSellingPrice = 'zero';
                     break;

                    default:
                        $itemSellingPrice = $part->selling_price;
                
                } 

            }
            return $itemSellingPrice;

        }
    }

    public function actionInsertInList() {
        $detail = new QuotationDetail();
        $this->layout = false;

        if( Yii::$app->request->post() ) {
            $getItemType = explode('-', Yii::$app->request->post()['services_parts'] );
            $ItemType = $getItemType[0];
            $ItemId = $getItemType[1];

            $serviceId = false;
            $serviceName = false;
            $partId = false;
            $partName = false;

            if( $ItemType == '0' ) {
                $service = Service::find()->where(['id' => $ItemId])->one();
                $serviceId = $service->id;
                $serviceName = $service->service_name;

            }else{
                $model = new Quotation();
                $part = Product::find()->where(['id' => $ItemId])->one();
                $partId = $part->id;
                $partName = $part->product_name;
            
                // $partQty = Inventory::find()->where(['product_id' => $getServicePartId])->one();
                // $totalQty = $partQty->quantity - $value;
                
                // Yii::$app->db->createCommand()
                //     ->update('inventory', ['quantity' => $totalQty ], "id = $getServicePartId" )
                //     ->execute();
            }

            $n = Yii::$app->request->post('n');
            $itemQty = Yii::$app->request->post('itemQty');
            $itemPriceValue = Yii::$app->request->post('itemPriceValue');
            $itemSubTotal = Yii::$app->request->post('itemSubTotal');

            return $this->render('item-list', [
                    'n' => $n,
                    'itemQty' => $itemQty,
                    'itemPriceValue' => $itemPriceValue,
                    'itemSubTotal' => $itemSubTotal,
                    'serviceId' => $serviceId,
                    'serviceName' => $serviceName,
                    'partId' => $partId,
                    'partName' => $partName,
                    'itemType' => $ItemType,
                    'detail' => $detail,
                ]);
        }  

    }

    public function actionInsertInvoice($id) {
        $model = new Quotation();
        $details = new QuotationDetail();
        $invoice = new Invoice();

        $getQuotation = $model->getQuotation($id);
        $getInvoiceId = $invoice->getInvoiceId();

        $invoiceNo = 'INVOICE' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5) . '-' . $getInvoiceId;

        $getService = $model->getQuotationDetailService($id);
        $getPart = $model->getQuotationDetailPart($id);
        $getLastId = $model->getLastId($id);

        $getInvoice = Invoice::find()->where(['quotation_code' => $getQuotation['quotation_code'] ])->one();

        if( empty($getInvoice) ) {

            $invoice = new Invoice();
        
            $invoice->quotation_code = $getQuotation['quotation_code'];
            $invoice->invoice_no = $invoiceNo;
            $invoice->user_id = $getQuotation['user_id'];
            $invoice->customer_id = $getQuotation['customer_id'];
            $invoice->branch_id = $getQuotation['branch_id'];
            $invoice->date_issue = $getQuotation['date_issue'];
            $invoice->grand_total = $getQuotation['grand_total'];
            $invoice->remarks = $getQuotation['remarks'];
            $invoice->created_at = $getQuotation['created_at'];
            $invoice->created_by = $getQuotation['created_by'];
            $invoice->updated_at = $getQuotation['updated_at'];
            $invoice->updated_by = $getQuotation['updated_by'];
            $invoice->delete = $getQuotation['delete'];
            $invoice->task = $getQuotation['task'];
            $invoice->paid = $getQuotation['paid'];
            
            $invoice->save();

            $invoiceId = $invoice->id;

            foreach( $getService as $sRow ) {

                $sDetails = new InvoiceDetail();

                $sDetails->invoice_id = $invoiceId;
                $sDetails->service_part_id = $sRow['serviceId'];
                $sDetails->quantity = $sRow['quantity'];
                $sDetails->selling_price = $sRow['selling_price'];
                $sDetails->subTotal = $sRow['subTotal'];
                $sDetails->created_at = $sRow['created_at'];
                $sDetails->created_by = $sRow['created_by'];
                $sDetails->type = $sRow['type'];
                $sDetails->task = $sRow['task'];
                
                $sDetails->save();
            }

            foreach( $getPart as $pRow ) {

                $pDetails = new InvoiceDetail();

                $pDetails->invoice_id = $invoiceId;
                $pDetails->service_part_id = $pRow['productId'];
                $pDetails->quantity = $pRow['quantity'];
                $pDetails->selling_price = $pRow['selling_price'];
                $pDetails->subTotal = $pRow['subTotal'];
                $pDetails->created_at = $pRow['created_at'];
                $pDetails->created_by = $pRow['created_by'];
                $pDetails->type = $pRow['type'];
                $pDetails->task = $pRow['task'];
                
                $pDetails->save();
            }

            $searchModel = new SearchQuotation();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $getQuotation = $searchModel->getQuotation();

            return $this->render('index', ['searchModel' => $searchModel, 'getQuotation' => $getQuotation,
                        'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Invoice for the Quotation was already generated.']);

        }else{

            $searchModel = new SearchQuotation();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $getQuotation = $searchModel->getQuotation();

            return $this->render('index', ['searchModel' => $searchModel, 'getQuotation' => $getQuotation,
                        'dataProvider' => $dataProvider, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'Invoice for the Quotation was already generated.']);

        }
        

    }


}
