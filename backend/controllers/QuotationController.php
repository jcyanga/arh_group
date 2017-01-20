<?php

namespace backend\controllers;

use Yii;
use common\models\Quotation;
use common\models\SearchQuotation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use common\models\Service;
use common\models\Inventory;
use common\models\QuotationDetail;
use common\models\Product;
use common\models\Gst;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\ProductLevel;
use common\models\SearchInvoice;

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
                    ],

                    [
                        'actions' => $action['customer'],
                        'allow' => $allow['customer'],
                        'roles' => ['customer'],
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

        if( Yii::$app->request->get('date_start') <> "" && Yii::$app->request->get('date_end') <> "" ) {
            $getQuotation = $searchModel->getQuotationByDateRange(Yii::$app->request->get('date_start'), Yii::$app->request->get('date_end'));

        } else {
            $getQuotation = $searchModel->getQuotation();

        }

        return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'getQuotation' => $getQuotation, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
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
         $searchModel = new SearchQuotation();

         $getQuotation = $searchModel->getProcessedQuotation($id); 
         $getProcessedServices = $searchModel->getProcessedServices($id); 
         $getProcessedParts = $searchModel->getProcessedParts($id);

        return $this->render('view',[
                        'model' => $this->findModel($id),
                        'customerInfo' => $getQuotation,
                        'services' => $getProcessedServices,
                        'parts' => $getProcessedParts
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
        $searchModel = new SearchQuotation();

        $quotationId = $this->_getQuotationId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            $getGst = Gst::find()->where(['branch_id' => Yii::$app->request->post('Quotation')['selectedBranch'] ])->one();

            if( isset($getGst) ) {
                $totalWithGst = ( Yii::$app->request->post('Quotation')['grand_total'] * $getGst->gst);
            } else {
                $totalWithGst = Yii::$app->request->post('Quotation')['grand_total'];
            }

                if( Yii::$app->request->post('Quotation')['dateIssue'] == "" || Yii::$app->request->post('Quotation')['selectedBranch'] == 0 || Yii::$app->request->post('Quotation')['selectedCustomer'] == 0 || Yii::$app->request->post('Quotation')['selectedUser'] == 0 || Yii::$app->request->post('Quotation')['remarks'] == "" ) {
                        
                        return $this->render('_form', [
                                            'model' => $model,
                                            'quotationId' => $quotationId,
                                            'getBranchList' => $getBranchList,
                                            'getUserList' => $getUserList,
                                            'getCustomerList' => $getCustomerList,
                                            'getServicesList' => $getServicesList,
                                            'getPartsList' => $getPartsList, 
                                            'errTypeHeader' => 'Error!', 
                                            'errType' => 'alert alert-error', 
                                            'msg' => 'Fill-up all the fields in the form.'
                                        ]);
                }

                $model->quotation_code = Yii::$app->request->post('Quotation')['quotationCode'];
                $model->user_id = Yii::$app->request->post('Quotation')['selectedUser'];
                $model->customer_id = Yii::$app->request->post('Quotation')['selectedCustomer'];
                $model->branch_id = Yii::$app->request->post('Quotation')['selectedBranch'];
                $model->date_issue = Yii::$app->request->post('Quotation')['dateIssue'];
                $model->grand_total = $totalWithGst;
                $model->remarks = Yii::$app->request->post('Quotation')['remarks'];
                $model->created_by = Yii::$app->user->identity->id;
                $model->created_at = date("Y-m-d");
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = date("Y-m-d");
                $model->delete = 0;
                $model->task = 0;
                $model->invoice = 0;

            if ( $model->save() ) {  
                $quotationId = $model->id;

                if( $details->load(Yii::$app->request->post()) ) {
                    
                    if( empty(Yii::$app->request->post('QuotationDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('QuotationDetail')['task'];
                    }

                    foreach ( Yii::$app->request->post('QuotationDetail')['quantity'] as $key => $value ) {
                        $quoD = new QuotationDetail();

                        $getServicePart = explode('-', Yii::$app->request->post('QuotationDetail')['service_part_id'][$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;
                            
                            $invQty = Inventory::findOne($getServicePartId);
                            $invQty->quantity = $totalQty;
                            $invQty->save();        
                        }

                        $quoD->quotation_id = $quotationId;
                        $quoD->service_part_id = $getServicePartId;
                        $quoD->quantity = $value;
                        $quoD->selling_price = Yii::$app->request->post('QuotationDetail')['selling_price'][$key];
                        $quoD->subTotal = Yii::$app->request->post('QuotationDetail')['subTotal'][$key];
                        $quoD->created_at = date("Y-m-d");
                        $quoD->created_by = Yii::$app->user->identity->id;
                        $quoD->type = $getType; 
                        $quoD->task = 0;
                        $quoD->invoice = 0;

                        $quoD->save();
                    }

                    if( !empty(Yii::$app->request->post('QuotationDetail')['task']) ) {
                        foreach( Yii::$app->request->post('QuotationDetail')['task'] as $key => $tValue ) {
                            $qdTask = QuotationDetail::find()->where(['quotation_id' => $quotationId])->andWhere(['service_part_id' => $tValue])->andWhere('type = 0')->one();
                            $qdTask->task = 1;
                            $qdTask->save();
                        }
                    }
                 
                 return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        } else {

            return $this->render('_form', [
                                'model' => $model,
                                'quotationId' => $quotationId,
                                'getBranchList' => $getBranchList,
                                'getUserList' => $getUserList,
                                'getCustomerList' => $getCustomerList,
                                'getServicesList' => $getServicesList,
                                'getPartsList' => $getPartsList, 
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => ''
                            ]);
        }
    }

    public function actionPreview($id) {

         $this->layout = 'print';
         $model = new Quotation();
         $searchModel = new SearchQuotation();

         $getProcessedQuotation = $searchModel->getProcessedQuotation($id); 
         $getProcessedServices = $searchModel->getProcessedServices($id); 
         $getProcessedParts = $searchModel->getProcessedParts($id);

        return $this->render('_print-quotation',[
                            'model' => $this->findModel($id),
                            'customerInfo' => $getProcessedQuotation,
                            'services' => $getProcessedServices,
                            'parts' => $getProcessedParts
                        ]);
    }


    public function _getQuotationId() 
    {
        $searchModel = new SearchQuotation();
        $result = $searchModel->getQuotationId();

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
        $searchModel = new SearchQuotation();

        $getProcessedQuotationbyId = $searchModel->getProcessedQuotationbyId($id);
        $getProcessedServicesById = $searchModel->getProcessedServicesById($id);
        $getProcessedPartsById = $searchModel->getProcessedPartsById($id);
        $getLastId = $searchModel->getLastId($id);

        $quotation_id = $this->_getQuotationId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            $getGst = Gst::find()->where(['branch_id' => Yii::$app->request->post('Quotation')['selectedBranch'] ])->one();

            if( isset($getGst) ) {
                $totalWithGst = ( Yii::$app->request->post('Quotation')['grand_total'] * $getGst->gst );
            }else {
                $totalWithGst = Yii::$app->request->post('Quotation')['grand_total'];
            }

            if( Yii::$app->request->post('Quotation')['dateIssue'] == "" || Yii::$app->request->post('Quotation')['selectedBranch'] == 0 || Yii::$app->request->post('Quotation')['selectedCustomer'] == 0 || Yii::$app->request->post('Quotation')['selectedUser'] == 0 || Yii::$app->request->post('Quotation')['remarks'] == "" ) {
                    
                    return $this->render('_update-form', [
                                                'model' => $model,
                                                'quotationId' => $id,
                                                'getBranchList' => $getBranchList,
                                                'getUserList' => $getUserList,
                                                'getCustomerList' => $getCustomerList,
                                                'getServicesList' => $getServicesList,
                                                'getPartsList' => $getPartsList, 
                                                'errTypeHeader' => 'Error!', 
                                                'errType' => 'alert alert-error', 
                                                'msg' => 'Fill-up all the fields in the form.'
                                            ]);

            }

            $findModel = Quotation::findOne($id);

            $findModel->quotation_code = Yii::$app->request->post('Quotation')['quotationCode'];
            $findModel->user_id = Yii::$app->request->post('Quotation')['selectedUser'];
            $findModel->customer_id = Yii::$app->request->post('Quotation')['selectedCustomer'];
            $findModel->branch_id = Yii::$app->request->post('Quotation')['selectedBranch'];
            $findModel->date_issue = Yii::$app->request->post('Quotation')['dateIssue'];
            $findModel->grand_total = $totalWithGst;
            $findModel->remarks = Yii::$app->request->post('Quotation')['remarks'];
            $findModel->updated_at = date("Y-m-d");
            $findModel->updated_by = Yii::$app->user->identity->id;
            $findModel->delete = 0;
            $findModel->task = 0;
            $findModel->invoice = 0;

            if ( $findModel->save() ) {
                
                if( $details->load(Yii::$app->request->post()) ) {            
                    $getQty = QuotationDetail::find()->where(['quotation_id' => $id])->andWhere('type = 1')->all();
         
                    foreach( $getQty as $qdInfo ) {
                        $getPartInventoryQty = Inventory::find()->where(['id' => $qdInfo['service_part_id'] ])->all();
                        
                        foreach( $getPartInventoryQty as $pInfo ) {
                            $totalPartQty = $pInfo['quantity'] + $qdInfo['quantity'];
                            
                            $findPartModel = Inventory::findOne($qdInfo['service_part_id']);
                            $findPartModel->quantity = $totalPartQty;
                            $findPartModel->save();
                        }
                    }
                    
                    Yii::$app->db->createCommand()
                    ->delete('quotation_detail', "quotation_id = $id" )
                    ->execute();

                    $service_part_id = Yii::$app->request->post('QuotationDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('QuotationDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('QuotationDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('QuotationDetail')['subTotal'];
                    
                    if( empty(Yii::$app->request->post('QuotationDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('QuotationDetail')['task'];
                    }

                    foreach ( Yii::$app->request->post('QuotationDetail')['quantity'] as $key => $value ) {
                        $quoD = new QuotationDetail();

                        $getServicePart = explode('-', Yii::$app->request->post('QuotationDetail')['service_part_id'][$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;

                            $invQty = Inventory::findOne($getServicePartId);
                            $invQty->quantity = $totalQty;
                            $invQty->save();
                        }

                        $quoD->quotation_id = $id;
                        $quoD->service_part_id = $getServicePartId;
                        $quoD->quantity = $value;
                        $quoD->selling_price = Yii::$app->request->post('QuotationDetail')['selling_price'][$key];
                        $quoD->subTotal = Yii::$app->request->post('QuotationDetail')['subTotal'][$key];
                        $quoD->created_at = date("Y-m-d");
                        $quoD->created_by = Yii::$app->user->identity->id;
                        $quoD->type = $getType;
                        $quoD->task = 0;   
                        $quoD->invoice = 0;

                        $quoD->save();
                    }

                    if( !empty(Yii::$app->request->post('QuotationDetail')['task']) ) {
                        foreach( Yii::$app->request->post('QuotationDetail')['task'] as $key => $tValue ) {
                            $qdTask = QuotationDetail::find()->where(['quotation_id' => $id])->andWhere(['service_part_id' => $tValue])->andWhere('type = 0')->one();
                            $qdTask->task = 1;
                            $qdTask->save();
                        }
                    }
                 
                 return $this->redirect(['view', 'id' => $id]);
                }
            }

        } else {
            
            return $this->render('_update-form', [
                                    'model' => $getProcessedQuotationbyId, 
                                    'getService' => $getProcessedServicesById,
                                    'getPart' => $getProcessedPartsById,
                                    'getLastId' => $getLastId,
                                    'quotationId' => $id,
                                    'getBranchList' => $getBranchList,
                                    'getUserList' => $getUserList,
                                    'getCustomerList' => $getCustomerList,
                                    'getServicesList' => $getServicesList,
                                    'getPartsList' => $getPartsList, 
                                    'errTypeHeader' => '', 
                                    'errType' => '', 
                                    'msg' => ''
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

        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'getQuotation' => $getQuotation,
                        'dataProvider' => $dataProvider, 
                        'errTypeHeader' => 'Success!', 
                        'errType' => 'alert alert-success', 
                        'msg' => 'Your record was successfully deleted in the database.'
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
                $itemSellingPrice = $service->default_price;
                $status = '';

            }else{
                $part = Inventory::find()->where(['id' => $ItemId])->one();
                $itemQty = $part->quantity;
                
                $getPartLevel = ProductLevel::find()->one();
                $criticalLvl = $getPartLevel->critical_level;
                $minimumLvl = $getPartLevel->minimum_level;

                switch($itemQty) {
                    case $minimumLvl:
                        $itemSellingPrice = $part->selling_price;
                        $status = 'minimum_level';
                     break;
                    
                    case $criticalLvl:
                        $itemSellingPrice = $part->selling_price;
                        $status = 'critical_level';
                     break;
                    
                    case 0:
                        $itemSellingPrice = '0';
                        $status = '0';
                     break;

                    default:
                        $itemSellingPrice = $part->selling_price;
                        $status = '';      
                } 

            }
            return json_encode(['price' => $itemSellingPrice, 'status' => $status]);

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
            $inventoryId = false;
            $partName = false;

            if( $ItemType == '0' ) {
                $service = Service::find()->where(['id' => $ItemId])->one();
                $serviceId = $service->id;
                $serviceName = $service->service_name;

            }else{
                $model = new Quotation();
                $getPartInfo = $model->getPartInfo($ItemId);      
                $inventoryId = $getPartInfo['id'];
                $partName = $getPartInfo['product_name'];
        
            }

            return $this->render('item-list', [
                    'n' => Yii::$app->request->post('n'),
                    'itemQty' => Yii::$app->request->post('itemQty'),
                    'itemPriceValue' => Yii::$app->request->post('itemPriceValue'),
                    'itemSubTotal' => Yii::$app->request->post('itemSubTotal'),
                    'serviceId' => $serviceId,
                    'serviceName' => $serviceName,
                    'partId' => $inventoryId,
                    'partName' => $partName,
                    'itemType' => $ItemType,
                    'detail' => $detail,
                ]);
        }  

    }

    public function actionInsertInvoice($id) 
    {
        $model = new Quotation();
        $details = new QuotationDetail();
        $searchInvoice = new SearchInvoice();
        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getQuotation = $searchModel->getProcessedQuotationbyId($id);
        $getInvoiceId = $searchInvoice->getInvoiceId();

        $invoiceNo = 'INVOICE' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5) . '-' . $getInvoiceId;

        $getService = $searchModel->getProcessedServicesById($id);
        $getPart = $searchModel->getProcessedPartsById($id);
        $getLastId = $searchModel->getLastId($id);

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
            $invoice->paid = 0;
            $invoice->paid_type = 0;
            $invoice->status = 0;

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
                $sDetails->status = 0;
                
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
                $pDetails->status = 0;

                $pDetails->save();
            }

            Yii::$app->db->createCommand()
                ->update('quotation', ['invoice' => 1], "id = $id")
                ->execute();

            Yii::$app->db->createCommand()
                ->update('quotation_detail', ['invoice' => 1], "quotation_id = $id")
                ->execute();

            $getQuotation = $searchModel->getQuotation();

            return $this->render('index', [
                                'searchModel' => $searchModel, 
                                'getQuotation' => $getQuotation,
                                'dataProvider' => $dataProvider, 
                                'errTypeHeader' => 'Success!', 
                                'errType' => 'alert alert-success', 
                                'msg' => 'Invoice for the Quotation was successfully generated.'
                            ]);

        }else{

            $getQuotation = $searchModel->getQuotation();

            return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getQuotation' => $getQuotation,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Error!', 
                            'errType' => 'alert alert-error', 
                            'msg' => 'Invoice for the Quotation was already generated.'
                        ]);
        }  

    }

    public function actionExportExcel() 
    {
        $model = new SearchQuotation();
        $result = $model->getQuotation();

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', '#')
             ->setCellValue('B1', 'Date Issue')
             ->setCellValue('C1', 'Quotation Code')
             ->setCellValue('D1', 'Branch Name')
             ->setCellValue('E1', 'Customer Name')
             ->setCellValue('F1', 'Car Plate')
             ->setCellValue('G1', 'Sales Person');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                    $dateIssue = date('m-d-Y', strtotime($result_row['date_issue']) );           
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dateIssue);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['quotation_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['salesPerson']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "QuotationList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf($id) 
    {
        $model = new SearchQuotation();

        $getProcessedQuotation = $model->getProcessedQuotation($id); 
        $getProcessedServices = $model->getProcessedServices($id); 
        $getProcessedParts = $model->getProcessedParts($id);

        $content = $this->renderPartial('_print-pdf', [
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedQuotation,
                'services' => $getProcessedServices,
                'parts' => $getProcessedParts
        ]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);  
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('Quotation-' . date('m-d-Y'));
    }

}
