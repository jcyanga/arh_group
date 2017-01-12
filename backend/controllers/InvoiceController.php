<?php

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use common\models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Service;
use common\models\Inventory;
use common\models\InvoiceDetail;
use common\models\Product;
use common\models\Gst;
use common\models\Payment;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Invoice'])->andWhere(['role_id' => $uRId ] )->all();
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $getInvoice = $searchModel->getInvoice();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'getInvoice' => $getInvoice
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $model = new Invoice();
         $getLastInsertInvoice = $model->getLastInsertInvoice($id); 
         $getLastInsertInvoiceServiceDetail = $model->getLastInsertInvoiceServiceDetail($id); 
         $getLastInsertInvoicePartDetail = $model->getLastInsertInvoicePartDetail($id);

        return $this->render('view',[
                'model' => $this->findModel($id),
                'customerInfo' => $getLastInsertInvoice,
                'services' => $getLastInsertInvoiceServiceDetail,
                'parts' => $getLastInsertInvoicePartDetail
            ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $details = new InvoiceDetail();

        $invoiceId = $this->_getInvoiceId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            
            $invoiceNo = Yii::$app->request->post('Invoice')['invoice_no'];
            $dateIssue = Yii::$app->request->post('Invoice')['dateIssue'];
            $selectedBranch = Yii::$app->request->post('Invoice')['selectedBranch'];
            $selectedCustomer = Yii::$app->request->post('Invoice')['selectedCustomer'];
            $selectedUser = Yii::$app->request->post('Invoice')['selectedUser'];
            $remarks = Yii::$app->request->post('Invoice')['remarks'];

            $grand_total = Yii::$app->request->post('Invoice')['grand_total'];
            $getGst = Gst::find()->where(['branch_id' => $selectedBranch])->one();

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('create', [
                        'model' => $model,
                        'invoiceId' => $invoiceId,
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

            $model->invoice_no = $invoiceNo;
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
                
                $invoiceId = $model->id;

                if( $details->load(Yii::$app->request->post()) ) {
                
                    $arrLen = count( Yii::$app->request->post('InvoiceDetail')['quantity'] );
                    $service_part_id = Yii::$app->request->post('InvoiceDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('InvoiceDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'];
                    
                    foreach ($quantity as $key => $value) {
                        $invD = new InvoiceDetail();

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

                        $invD->invoice_id = $invoiceId;
                        $invD->service_part_id = $getServicePartId;
                        $invD->quantity = $value;
                        $invD->selling_price = $selling_price[$key];
                        $invD->subTotal = $subTotal[$key];
                        $invD->created_at = $created_at;
                        $invD->created_by = $created_by;
                        $invD->type = $getType;
                        
                        if ( isset(Yii::$app->request->post('QuotationDetail')['task'][$key]) ) {
                            $invD->task = 1;

                        }else{
                            $invD->task = 0;
                            
                        }

                        $invD->save();

                    }
                 
                 return $this->redirect(['view', 'id' => $model->id]);

                }
            }
            
        } else {

            return $this->render('create', [
                'model' => $model,
                'invoiceId' => $invoiceId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            ]);

        }
    }

    public function actionPreview($id) {

         $model = new Invoice();
         $getInvoice = $model->getInvoice($id); 
         $getInvoiceServiceDetail = $model->getInvoiceServiceDetail($id); 
         $getInvoicePartDetail = $model->getInvoicePartDetail($id);

        return $this->render('preview-and-payment',[
                'model' => $this->findModel($id),
                'customerInfo' => $getInvoice,
                'services' => $getInvoiceServiceDetail,
                'parts' => $getInvoicePartDetail
            ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new Invoice();
        $details = new InvoiceDetail();

        $getInvoice = $model->getInvoice($id);
        $getService = $model->getInvoiceServiceDetail($id);
        $getPart = $model->getInvoicePartDetail($id);
        $getLastId = $model->getLastId($id);

        $invoiceId = $this->_getInvoiceId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            
            Yii::$app->db->createCommand()
            ->delete('invoice', "id = $id" )
            ->execute();

            $invoice_no = Yii::$app->request->post('Invoice')['invoice_no'];
            $quotationCode = Yii::$app->request->post('Invoice')['quotationCode'];
            $dateIssue = Yii::$app->request->post('Invoice')['dateIssue'];
            $selectedBranch = Yii::$app->request->post('Invoice')['selectedBranch'];
            $selectedCustomer = Yii::$app->request->post('Invoice')['selectedCustomer'];
            $selectedUser = Yii::$app->request->post('Invoice')['selectedUser'];
            $remarks = Yii::$app->request->post('Invoice')['remarks'];

            $grand_total = Yii::$app->request->post('Invoice')['grand_total'];
            $getGst = Gst::find()->where(['branch_id' => $selectedBranch])->one();

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('update', [
                        'model' => $model,
                        'invoiceId' => $invoiceId,
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

            $model->invoice_no = $invoice_no;
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
                
                $invoiceId = $model->id;

                if( $details->load(Yii::$app->request->post()) ) {
                    
                    Yii::$app->db->createCommand()
                    ->delete('invoice_detail', "invoice_id = $id" )
                    ->execute();

                    $arrLen = count( Yii::$app->request->post('InvoiceDetail')['quantity'] );
                    $service_part_id = Yii::$app->request->post('InvoiceDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('InvoiceDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'];
                    
                    foreach ($quantity as $key => $value) {
                        $invD = new InvoiceDetail();

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

                        $invD->invoice_id = $invoiceId;
                        $invD->service_part_id = $getServicePartId;
                        $invD->quantity = $value;
                        $invD->selling_price = $selling_price[$key];
                        $invD->subTotal = $subTotal[$key];
                        $invD->created_at = $created_at;
                        $invD->created_by = $created_by;
                        $invD->type = $getType;
                        
                        if ( isset(Yii::$app->request->post('InvoiceDetail')['task'][$key]) ) {
                            $invD->task = 1;

                        }else{
                            $invD->task = 0;
                            
                        }

                        $invD->save();

                    }
                 
                 return $this->redirect(['view', 'id' => $model->id]);

                }
            }

        } else {

            return $this->render('update', [
                'model' => $getInvoice, 
                'getService' => $getService,
                'getPart' => $getPart,
                'getLastId' => $getLastId,
                'invoiceId' => $invoiceId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            
            ]);

        }

    }

    public function _getInvoiceId() {
        $model = new Invoice();
        $result = $model->getInvoiceId();

        return $result;
    }

    /**
     * Deletes an existing Invoice model.
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
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        Yii::$app->db->createCommand()
            ->delete('invoice_detail', "invoice_id = $id" )
            ->execute();

        $getInvoice = $searchModel->getInvoice();

        return $this->render('index', ['searchModel' => $searchModel, 'getInvoice' => $getInvoice,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    public function actionDeleteSelectedQuotationDetail($id)
    {
        Yii::$app->db->createCommand()
            ->delete('invoice_detail', "invoice_id = $id" )
            ->execute();

        $model = new Invoice();

        $getInvoice = $model->getInvoice($id);
        $getService = $model->getQuotationDetailService($id);
        $getPart = $model->getQuotationDetailPart($id);
        $getLastId = $model->getLastId($id);

        $invoiceId = $this->_getInvoiceId();
        $getBranchList = $model->getBranch();
        $getUserList = $model->getUser();
        $getCustomerList = $model->getCustomer();
        $getServicesList = $model->getServicesList();
        $getPartsList = $model->getPartsList();

        return $this->render('update', [
                'model' => $getInvoice, 
                'getService' => $getService,
                'getPart' => $getPart,
                'getLastId' => $getLastId,
                'invoiceId' => $invoiceId,
                'getBranchList' => $getBranchList,
                'getUserList' => $getUserList,
                'getCustomerList' => $getCustomerList,
                'getServicesList' => $getServicesList,
                'getPartsList' => $getPartsList, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
            
            ]);
    }
    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
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
    
                switch($itemQty) {
                    case 10:
                        $itemSellingPrice = 'ten';
                     break;
                    
                    case 5:
                        $itemSellingPrice = 'five';
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
        $detail = new InvoiceDetail();
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
                $model = new Invoice();
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

    public function actionPaymentMethod($id) {
       
         $model = new Invoice();
         $getInvoice = $model->getInvoice($id); 
         $getInvoiceServiceDetail = $model->getInvoiceServiceDetail($id); 
         $getInvoicePartDetail = $model->getInvoicePartDetail($id);

        return $this->render('payment-method',[
                'model' => $this->findModel($id),
                'customerInfo' => $getInvoice,
                'services' => $getInvoiceServiceDetail,
                'parts' => $getInvoicePartDetail
            ]);

    }

    public function actionSavePayment() {

        $model = new Payment();
        // $getInvoice = $model->getInvoice($id); 
        // $getInvoiceServiceDetail = $model->getInvoiceServiceDetail($id); 
        // $getInvoicePartDetail = $model->getInvoicePartDetail($id);

        if( $model->load(Yii::$app->request->post()) ) {
            $invoiceId = Yii::$app->request->post('Payment')['invoice_id'];
            $invoiceNo = Yii::$app->request->post('Payment')['invoice_no'];
            $customerId = Yii::$app->request->post('Payment')['customer_id'];
            $paymentDate = Yii::$app->request->post('Payment')['payment_date'];
            $paymentTime = Yii::$app->request->post('Payment')['payment_time'];
            $paymentMethod = Yii::$app->request->post('Payment')['payment_method'];
            $paymentType = Yii::$app->request->post('Payment')['payment_type'];
            $amount = Yii::$app->request->post('Payment')['amount'];
            $discount = Yii::$app->request->post('Payment')['discount'];
            $pointsRedeem = Yii::$app->request->post('Payment')['points_redeem'];
            $pointsEarned = Yii::$app->request->post('Payment')['points_earned'];
            $remarks = Yii::$app->request->post('Payment')['remarks'];

            $model->invoice_id = $invoiceId;
            $model->invoice_no = $invoiceNo;
            $model->customer_id = $customerId;
            $model->amount = $amount;
            $model->discount = $discount;
            $model->payment_method = $paymentMethod;
            $model->payment_type = $paymentType;
            $model->points_earned = $pointsEarned;
            $model->points_redeem = $pointsRedeem;
            $model->remarks = $remarks;
            $model->payment_date = $paymentDate;
            $model->payment_time = $paymentTime;
            $model->status = 1;
            
            $model->save();

        }else{
            echo 'not ok';
        }

    }

    public function actionInsertInPaymentList() {

        return $this->render('add-payment-lists', [
                    'content' => 'ok',
                    // 'n' => $n,
                    // 'itemQty' => $itemQty,
                    // 'itemPriceValue' => $itemPriceValue,
                    // 'itemSubTotal' => $itemSubTotal,
                    // 'serviceId' => $serviceId,
                    // 'serviceName' => $serviceName,
                    // 'partId' => $partId,
                    // 'partName' => $partName,
                    // 'itemType' => $ItemType,
                    // 'detail' => $detail,
                ]);

    }

}
