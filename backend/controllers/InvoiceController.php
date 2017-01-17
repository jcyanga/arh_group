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
use common\models\ProductLevel;
use common\models\Customer;

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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if( !empty(Yii::$app->request->get('date_start')) && !empty(Yii::$app->request->get('date_end')) ) {
            $date_start = Yii::$app->request->get('date_start');
            $date_end = Yii::$app->request->get('date_end');

            $getInvoice = $searchModel->getInvoiceByDateRange($date_start,$date_end);

        } else {
            $getInvoice = $searchModel->getInvoice();

        }

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

            if( isset($getGst) ) {
                $totalWithGst = ($grand_total * $getGst->gst);
            }else {
                $totalWithGst = ($grand_total + 0);
            }

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('_form', [
                        'model' => $model,
                        'invoiceId' => $invoiceId,
                        'getBranchList' => $getBranchList,
                        'getUserList' => $getUserList,
                        'getCustomerList' => $getCustomerList,
                        'getServicesList' => $getServicesList,
                        'getPartsList' => $getPartsList, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'Fill-up all the fields.'
                    ]);

            }

            $model->invoice_no = $invoiceNo;
            $model->quotation_code = 0;
            $model->user_id = $selectedUser;
            $model->customer_id = $selectedCustomer;
            $model->branch_id = $selectedBranch;
            $model->date_issue = $dateIssue;
            $model->grand_total = $totalWithGst;
            $model->remarks = $remarks;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_at = date("Y-m-d");
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = date("Y-m-d");
            $model->delete = 0;
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
                    
                    if( empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('InvoiceDetail')['task'];
                    }

                    foreach ($quantity as $key => $value) {
                        $invD = new InvoiceDetail();

                        $getServicePart = explode('-', $service_part_id[$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;

                            Yii::$app->db->createCommand()
                                ->update('inventory', ['quantity' => $totalQty ], "id = $getServicePartId" )
                                ->execute();
                        }

                        $invD->invoice_id = $invoiceId;
                        $invD->service_part_id = $getServicePartId;
                        $invD->quantity = $value;
                        $invD->selling_price = $selling_price[$key];
                        $invD->subTotal = $subTotal[$key];
                        $invD->created_by = Yii::$app->user->identity->id;
                        $invD->created_at = date("Y-m-d");
                        $invD->type = $getType;
                        $invD->task = 0;

                        $invD->save();

                    }
                    
                    if( !empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        foreach( $task as $key => $tValue ) {

                            Yii::$app->db->createCommand()
                                ->update('invoice_detail', ['task' => 1], "invoice_id = $invoiceId AND service_part_id = $tValue AND type = 0")
                                ->execute();

                        }
                    }

                 return $this->redirect(['view', 'id' => $model->id]);

                }
            }
            
        } else {

            return $this->render('_form', [
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

        return $this->render('processed-invoice',[
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
    

            $invoice_no = Yii::$app->request->post('Invoice')['invoice_no'];
            $dateIssue = Yii::$app->request->post('Invoice')['dateIssue'];
            $selectedBranch = Yii::$app->request->post('Invoice')['selectedBranch'];
            $selectedCustomer = Yii::$app->request->post('Invoice')['selectedCustomer'];
            $selectedUser = Yii::$app->request->post('Invoice')['selectedUser'];
            $remarks = Yii::$app->request->post('Invoice')['remarks'];
            $grand_total = Yii::$app->request->post('Invoice')['grand_total'];
            $getGst = Gst::find()->where(['branch_id' => $selectedBranch])->one();

            if( isset($getGst) ) {
                $totalWithGst = ($grand_total * $getGst->gst);
            }else {
                $totalWithGst = ($grand_total + 0);
            }

            if( empty(Yii::$app->request->post('Quotation')['quotationCode']) ) {
                $quotationCode = 0;
            } else {
                $quotationCode = Yii::$app->request->post('Quotation')['quotationCode'];
            }

            if( $dateIssue == "" || $selectedBranch == 0 || $selectedCustomer == 0 || $selectedUser == 0 || $remarks == "" ) {
                    
                    return $this->render('_update-form', [
                        'model' => $model,
                        'invoiceId' => $invoiceId,
                        'getBranchList' => $getBranchList,
                        'getUserList' => $getUserList,
                        'getCustomerList' => $getCustomerList,
                        'getServicesList' => $getServicesList,
                        'getPartsList' => $getPartsList, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'Fill-up all the fields.'
                    ]);

            }

            $findModel = Invoice::findOne($id);

            $findModel->invoice_no = $invoice_no;
            $findModel->quotation_code = $quotationCode;
            $findModel->user_id = $selectedUser;
            $findModel->customer_id = $selectedCustomer;
            $findModel->branch_id = $selectedBranch;
            $findModel->date_issue = $dateIssue;
            $findModel->grand_total = $totalWithGst;
            $findModel->remarks = $remarks;
            $findModel->updated_at = date("Y-m-d");
            $findModel->updated_by = Yii::$app->user->identity->id;
            $findModel->delete = 0;
            $findModel->task = 0;
            $findModel->paid = 0;

            if ( $findModel->save() ) {

                if( $details->load(Yii::$app->request->post()) ) {
                    
                    $getQty = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere('type = 1')->all();
                    
                    foreach( $getQty as $idInfo ) {
                        $getPartInventoryQty = Inventory::find()->where(['id' => $idInfo['service_part_id'] ])->all();
                        
                        foreach( $getPartInventoryQty as $pInfo ) {
                            $totalPartQty = $pInfo['quantity'] + $idInfo['quantity'];
                            
                            $findPartModel = Inventory::findOne($idInfo['service_part_id']);
                            $findPartModel->quantity = $totalPartQty;
                            $findPartModel->save();

                        }
                    }

                    Yii::$app->db->createCommand()
                    ->delete('invoice_detail', "invoice_id = $id" )
                    ->execute();

                    $service_part_id = Yii::$app->request->post('InvoiceDetail')['service_part_id'];
                    $quantity = Yii::$app->request->post('InvoiceDetail')['quantity'];
                    $selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'];
                    $subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'];
                    
                    if( empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('InvoiceDetail')['task'];
                    }

                    foreach ($quantity as $key => $value) {
                        $invD = new InvoiceDetail();

                        $getServicePart = explode('-', $service_part_id[$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;

                            Yii::$app->db->createCommand()
                                ->update('inventory', ['quantity' => $totalQty ], "id = $getServicePartId" )
                                ->execute();
                        }

                        $invD->invoice_id = $id;
                        $invD->service_part_id = $getServicePartId;
                        $invD->quantity = $value;
                        $invD->selling_price = $selling_price[$key];
                        $invD->subTotal = $subTotal[$key];
                        $invD->created_at = date("Y-m-d");
                        $invD->created_by = Yii::$app->user->identity->id;
                        $invD->type = $getType;
                        $invD->task = 0;

                        $invD->save();

                    }
                 
                 if( !empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                     foreach( $task as $key => $tValue ) {

                            Yii::$app->db->createCommand()
                                ->update('invoice_detail', ['task' => 1], "invoice_id = $invoiceId AND service_part_id = $tValue AND type = 0")
                                ->execute();

                     }
                 }

                 return $this->redirect(['view', 'id' => $id]);

                }
            }

        } else {

            return $this->render('_update-form', [
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

    public function actionDeleteSelectedQuotationDetail($id,$invoiceId)
    {
        Yii::$app->db->createCommand()
            ->delete('invoice_detail', "id = $id" )
            ->execute();

        return $this->actionUpdate($invoiceId);
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
        $detail = new InvoiceDetail();
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
                $model = new Invoice();
                $getPartInfo = $model->getPartInfo($ItemId);      
                $inventoryId = $getPartInfo['id'];
                $partName = $getPartInfo['product_name'];

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
                    'partId' => $inventoryId,
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

        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( $model->load(Yii::$app->request->post()) ) {
            
            $paymentMethod = Yii::$app->request->post('Payment')['payment_method'];     
            
            if( $paymentMethod == 1 ) {
                
                $invoiceId = Yii::$app->request->post('Payment')['invoice_id'];
                $invoiceNo = Yii::$app->request->post('Payment')['invoice_no'];
                $customerId = Yii::$app->request->post('Payment')['customer_id'];
                $paymentDate = Yii::$app->request->post('Payment')['payment_date'];
                $paymentTime = Yii::$app->request->post('Payment')['payment_time'];
                $paymentType = Yii::$app->request->post('Payment')['payment_type'];
                $amount = Yii::$app->request->post('Payment')['amount'];
                $discount = Yii::$app->request->post('Payment')['discount'];

                if( empty(Yii::$app->request->post('Payment')['points_redeem']) ) {
                    $pointsRedeem = 0;
                } else {
                    $pointsRedeem = Yii::$app->request->post('Payment')['points_redeem'];
                }

                $pointsEarned = Yii::$app->request->post('Payment')['points_earned'];
                $remarks = Yii::$app->request->post('Payment')['remarks'];

                $checkIfExist = $model->checkInvoice($invoiceId,$invoiceNo,$customerId);

                if( $checkIfExist == 0 ) {
                    
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
                    
                    $lastId = $model->id;

                    Yii::$app->db->createCommand()
                        ->update('invoice', ['status' => 1, 'paid' => 1, 'paid_type' => 1], "id = $invoiceId")
                        ->execute();

                    Yii::$app->db->createCommand()
                        ->update('invoice_detail', ['status' => 1], "id = $invoiceId")
                        ->execute();

                    $getPoints = Customer::find()->where(['id' => $customerId])->one();
                    $points = $getPoints->points;
                    $totalPoints = $points - $pointsRedeem;
                    $totalPoints += $pointsEarned;

                    $getPoints->points = $totalPoints;
                    $getPoints->save();

                    $getInvoice = $model->getInvoice($lastId,$invoiceId,$invoiceNo,$customerId);
                    $getServices = $model->getInvoiceServiceDetail($invoiceId);
                    $getParts = $model->getInvoicePartDetail($invoiceId);

                    $this->layout = 'print';

                    return $this->render('_print-invoice',[
                    'customerInfo' => $getInvoice,
                    'services' => $getServices,
                    'parts' => $getParts
                    ]);

                }else{
                    
                     $getInvoice = $searchModel->getInvoice();

                     return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'getInvoice' => $getInvoice
                     ]);

                }

            }else{

                    $mInvoiceId = Yii::$app->request->post('Payment')['mInvoice_id'];
                    $mInvoiceNo = Yii::$app->request->post('Payment')['mInvoice_no'];
                    $mCustomerId = Yii::$app->request->post('Payment')['mCustomer_id'];
                    $mPaymentDate = Yii::$app->request->post('Payment')['mPayment_date'];
                    $mPaymentTime = Yii::$app->request->post('Payment')['mPayment_time'];

                    $mlPaymentType = Yii::$app->request->post('Payment')['mlPayment_type'];
                    $mlAmount = Yii::$app->request->post('Payment')['mlAmount'];
                    $mlDiscount = Yii::$app->request->post('Payment')['mlDiscount'];

                    if( empty(Yii::$app->request->post('Payment')['mlPoints_redeem']) ) {
                        $mlPointsRedeem = 0;
                    } else {
                        $mlPointsRedeem = Yii::$app->request->post('Payment')['mlPoints_redeem'];
                    }

                    $mlPointsEarned = Yii::$app->request->post('Payment')['mlPoints_earned'];
                    $mlRemarks = Yii::$app->request->post('Payment')['mlRemarks'];
                    
                    $getId = array();

                    foreach( $mlPaymentType as $key => $value ) {
                         $mModel = new Payment();
                         
                         $mModel->invoice_id = $mInvoiceId;
                         $mModel->invoice_no = $mInvoiceNo . '-' . $key;
                         $mModel->customer_id = $mCustomerId;
                         $mModel->amount = $mlAmount[$key];
                         $mModel->discount = $mlDiscount[$key];
                         $mModel->payment_method = $paymentMethod;
                         $mModel->payment_type = $value;
                         $mModel->points_earned = $mlPointsEarned[$key];
                         $mModel->points_redeem = $mlPointsRedeem[$key];
                         $mModel->remarks = $mlRemarks[$key];
                         $mModel->payment_date = $mPaymentDate;
                         $mModel->payment_time = $mPaymentTime;
                         $mModel->status = 1;
                         
                         $invoiceNo = $mInvoiceNo . '-' . $key;

                         $getMultipleInvoiceResult = $model->checkMultipleInvoice($mInvoiceId,$invoiceNo,$mCustomerId);

                         if( empty($getMultipleInvoiceResult) ) {
                                $mModel->save();
                                $getId[] = $mModel->id;
                         }
                         
                         $getPoints = Customer::find()->where(['id' => $mCustomerId])->all();
                         
                         foreach( $getPoints as $mcPointsRow) {
                            $customerPoints = $mcPointsRow['points'];
                            $totalPoints = $customerPoints - $mlPointsRedeem[$key];

                            $findCustomer = Customer::findOne($mCustomerId);
                            $findCustomer->points = $totalPoints;
                            $findCustomer->save();
                         }

                    }
                    
                     Yii::$app->db->createCommand()
                        ->update('invoice', ['status' => 1, 'paid' => 1, 'paid_type' => 2], "id = $mInvoiceId")
                        ->execute();

                     Yii::$app->db->createCommand()
                        ->update('invoice_detail', ['status' => 1], "id = $mInvoiceId")
                        ->execute();

                     $getMultipleInvoice = $model->getMultipleInvoice($getId,$mInvoiceId,$mInvoiceNo,$mCustomerId);
                     $getServices = $model->getInvoiceServiceDetail($mInvoiceId);
                     $getParts = $model->getInvoicePartDetail($mInvoiceId);

                     $this->layout = 'print';

                     return $this->render('_print-multiple-invoice',[
                      'multipleInvoiceInfo' => $getMultipleInvoice,
                      'services' => $getServices,
                      'parts' => $getParts
                     ]);

            }


        }

    }

    public function actionInsertInPaymentList() {
        $detail = new Payment();
        $this->layout = false;

        $n = Yii::$app->request->post('n');
        $mPayment_type = Yii::$app->request->post('mPayment_type');
        $mAmount = Yii::$app->request->post('mAmount');
        $mDiscount = Yii::$app->request->post('mDiscount');
        $mPoints_redeem = Yii::$app->request->post('mPoints_redeem');
        $mPoints_earned = Yii::$app->request->post('mPoints_earned');
        $mRemarks = Yii::$app->request->post('mRemarks');

        return $this->render('add-payment-lists', [
            'n' => $n,
            'mPayment_type' => $mPayment_type,
            'mAmount' => $mAmount,
            'mDiscount' => $mDiscount,
            'mPoints_redeem' => $mPoints_redeem,
            'mPoints_earned' => $mPoints_earned,
            'mRemarks' => $mRemarks,
            'detail' => $detail,

        ]);

    }

    public function actionPrintInvoice($id,$invoice_no) {
        $model = new Payment();

        $getInvoice = $model->getInvoiceById($id,$invoice_no);
        $getServices = $model->getInvoiceServiceDetail($id);
        $getParts = $model->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-invoice',[
            'customerInfo' => $getInvoice,
            'services' => $getServices,
            'parts' => $getParts
        ]);

    }

    public function actionPrintMultipleInvoice($id,$invoice_no) {
        $model = new Payment();

        $getInvoice = $model->getMultipleInvoiceById($invoiceId,$invoiceNo);
        $getServices = $model->getInvoiceServiceDetail($id);
        $getParts = $model->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-multiple-invoice',[
            'customerInfo' => $getInvoice,
            'services' => $getServices,
            'parts' => $getParts
        ]);

    }

    public function actionExportExcel() {

        $model = new SearchInvoice();

        $result = $model->getInvoice();

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
             ->setCellValue('C1', 'Invoice Number')
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
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['salesPerson']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "InvoiceList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }


}
