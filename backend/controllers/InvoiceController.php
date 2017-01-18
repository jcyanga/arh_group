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
            $getInvoice = $searchModel->getInvoiceByDateRange(Yii::$app->request->get('date_start'), Yii::$app->request->get('date_end'));

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
         $searchModel = new SearchInvoice();

         $getProcessedInvoice = $searchModel->getProcessedInvoice($id); 
         $getProcessedServices = $searchModel->getProcessedServices($id); 
         $getProcessedParts = $searchModel->getProcessedParts($id);

        return $this->render('view',[
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedInvoice,
                'services' => $getProcessedServices,
                'parts' => $getProcessedParts
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
        $searchModel = new SearchInvoice();

        $invoiceId = $this->_getInvoiceId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            $getGst = Gst::find()->where(['branch_id' => Yii::$app->request->post('Invoice')['selectedBranch'] ])->one();

            if( isset($getGst) ) {
                $totalWithGst = ( Yii::$app->request->post('Invoice')['grand_total'] * $getGst->gst );
            }else {
                $totalWithGst = Yii::$app->request->post('Invoice')['grand_total'];
            }

            if( Yii::$app->request->post('Invoice')['dateIssue'] == "" || Yii::$app->request->post('Invoice')['selectedBranch'] == 0 || Yii::$app->request->post('Invoice')['selectedCustomer'] == 0 || Yii::$app->request->post('Invoice')['selectedUser'] == 0 || Yii::$app->request->post('Invoice')['remarks'] == "" ) {
                    
                    return $this->render('_form', [
                                        'model' => $model,
                                        'invoiceId' => $invoiceId,
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

            $model->invoice_no = Yii::$app->request->post('Invoice')['invoice_no'];
            $model->quotation_code = 0;
            $model->user_id = Yii::$app->request->post('Invoice')['selectedUser'];
            $model->customer_id = Yii::$app->request->post('Invoice')['selectedCustomer'];
            $model->branch_id = Yii::$app->request->post('Invoice')['selectedBranch'];
            $model->date_issue = Yii::$app->request->post('Invoice')['dateIssue'];
            $model->grand_total = $totalWithGst;
            $model->remarks = Yii::$app->request->post('Invoice')['remarks'];
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
                    
                    if( empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('InvoiceDetail')['task'];
                    }

                    foreach ( Yii::$app->request->post('InvoiceDetail')['quantity'] as $key => $value) {
                        $invD = new InvoiceDetail();

                        $getServicePart = explode('-', Yii::$app->request->post('InvoiceDetail')['service_part_id'][$key]);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        if( $getType == 1 ) {
                            $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
                            $totalQty = $getPart->quantity - $value;

                            $invQty = Inventory::findOne($getServicePartId);
                            $invQty->quantity = $totalQty;
                            $invQty->save();
                        }

                        $invD->invoice_id = $invoiceId;
                        $invD->service_part_id = $getServicePartId;
                        $invD->quantity = $value;
                        $invD->selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'][$key];
                        $invD->subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'][$key];
                        $invD->created_by = Yii::$app->user->identity->id;
                        $invD->created_at = date("Y-m-d");
                        $invD->type = $getType;
                        $invD->task = 0;

                        $invD->save();
                    }
                    
                    if( !empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        foreach( Yii::$app->request->post('InvoiceDetail')['task'] as $key => $tValue ) {
                            $qdTask = InvoiceDetail::find()->where(['invoice_id' => $invoiceId])->andWhere(['service_part_id' => $tValue])->andWhere('type = 0')->one();
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
                                    'invoiceId' => $invoiceId,
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

         $model = new Invoice();
         $searchModel = new SearchInvoice();

         $getProcessedInvoiceById = $searchModel->getProcessedInvoiceById($id); 
         $getProcessedServicesById = $searchModel->getProcessedServicesById($id); 
         $getProcessedPartsById = $searchModel->getProcessedPartsById($id);

        return $this->render('processed-invoice',[
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedInvoiceById,
                'services' => $getProcessedServicesById,
                'parts' => $getProcessedPartsById
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
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getProcessedInvoicebyId($id);
        $getService = $searchModel->getProcessedServicesbyId($id);
        $getPart = $searchModel->getProcessedPartsbyId($id);
        $getLastId = $searchModel->getLastId($id);

        $invoiceId = $this->_getInvoiceId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( $model->load(Yii::$app->request->post()) ) {
            $getGst = Gst::find()->where(['branch_id' => Yii::$app->request->post('Invoice')['selectedBranch'] ])->one();

            if( isset($getGst) ) {
                $totalWithGst = ( Yii::$app->request->post('Invoice')['grand_total'] * $getGst->gst );
            }else {
                $totalWithGst = Yii::$app->request->post('Invoice')['grand_total'];
            }

            if( empty(Yii::$app->request->post('Quotation')['quotationCode']) ) {
                $quotationCode = 0;
            } else {
                $quotationCode = Yii::$app->request->post('Quotation')['quotationCode'];
            }

            if( Yii::$app->request->post('Invoice')['dateIssue'] == "" || Yii::$app->request->post('Invoice')['selectedBranch'] == 0 || Yii::$app->request->post('Invoice')['selectedCustomer'] == 0 || Yii::$app->request->post('Invoice')['selectedUser'] == 0 || Yii::$app->request->post('Invoice')['remarks'] == "" ) {
                    
                    return $this->render('_update-form', [
                                                'model' => $model,
                                                'invoiceId' => $invoiceId,
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

            $findModel = Invoice::findOne($id);

            $findModel->invoice_no = Yii::$app->request->post('Invoice')['invoice_no'];
            $findModel->quotation_code = $quotationCode;
            $findModel->user_id = Yii::$app->request->post('Invoice')['selectedUser'];
            $findModel->customer_id = Yii::$app->request->post('Invoice')['selectedCustomer'];
            $findModel->branch_id = Yii::$app->request->post('Invoice')['selectedBranch'];
            $findModel->date_issue = Yii::$app->request->post('Invoice')['dateIssue'];
            $findModel->grand_total = $totalWithGst;
            $findModel->remarks = Yii::$app->request->post('Invoice')['remarks'];
            $findModel->updated_at = date("Y-m-d");
            $findModel->updated_by = Yii::$app->user->identity->id;
            $findModel->delete = 0;
            $findModel->task = 0;
            $findModel->paid = 0;
            $findModel->paid_type = 0;
            $findModel->status = 0;

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
                    
                    if( empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                        $task = 0;
                    } else {
                        $task = Yii::$app->request->post('InvoiceDetail')['task'];
                    }

                    foreach ( Yii::$app->request->post('InvoiceDetail')['quantity'] as $key => $value) {
                        $invD = new InvoiceDetail();

                        $getServicePart = explode('-', Yii::$app->request->post('InvoiceDetail')['service_part_id'][$key]);
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
                        $invD->selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'][$key];
                        $invD->subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'][$key];
                        $invD->created_at = date("Y-m-d");
                        $invD->created_by = Yii::$app->user->identity->id;
                        $invD->type = $getType;
                        $invD->task = 0;
                        $invD->status = 0;

                        $invD->save();

                    }
                 
                 if( !empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
                     foreach( Yii::$app->request->post('InvoiceDetail')['task'] as $key => $tValue ) {
                        $qdTask = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere(['service_part_id' => $tValue])->andWhere('type = 0')->one();
                        $qdTask->task = 1;
                        $qdTask->save();

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
                                    'getPartsList' => $getPartsList, 
                                    'errTypeHeader' => '', 
                                    'errType' => '', 
                                    'msg' => ''
                                ]);

        }

    }

    public function _getInvoiceId() 
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getInvoiceId();

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

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getInvoice' => $getInvoice,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully deleted in the database.'
                        ]);
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

    public function actionPrice() 
    {
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

    public function actionInsertInList() 
    {
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

    public function actionPaymentMethod($id) 
    {
         $model = new Invoice();
         $searchModel = new SearchInvoice();

         $getProcessedInvoiceById = $searchModel->getProcessedInvoiceById($id); 
         $getProcessedServicesById = $searchModel->getProcessedServicesById($id); 
         $getProcessedPartsById = $searchModel->getProcessedPartsById($id);

        return $this->render('payment-method',[
                    'model' => $this->findModel($id),
                    'customerInfo' => $getProcessedInvoiceById,
                    'services' => $getProcessedServicesById,
                    'parts' => $getProcessedPartsById
                ]);

    }

    public function actionSavePayment() 
    {
        $model = new Payment();
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( $model->load(Yii::$app->request->post()) ) {
            $paymentMethod = Yii::$app->request->post('Payment')['payment_method'];     
            
            if( $paymentMethod == 1 ) {
                
                if( empty(Yii::$app->request->post('Payment')['points_redeem']) ) {
                    $pointsRedeem = 0;
                } else {
                    $pointsRedeem = Yii::$app->request->post('Payment')['points_redeem'];
                }

                $checkIfExist = $searchModel->checkInvoice(Yii::$app->request->post('Payment')['invoice_id'], Yii::$app->request->post('Payment')['invoice_no'], Yii::$app->request->post('Payment')['customer_id']);

                if( $checkIfExist == 0 ) {
                    
                    $model->invoice_id = Yii::$app->request->post('Payment')['invoice_id'];
                    $model->invoice_no = Yii::$app->request->post('Payment')['invoice_no'];
                    $model->customer_id = Yii::$app->request->post('Payment')['customer_id'];
                    $model->amount = Yii::$app->request->post('Payment')['amount'];
                    $model->discount = Yii::$app->request->post('Payment')['discount'];
                    $model->payment_method = $paymentMethod;
                    $model->payment_type = Yii::$app->request->post('Payment')['payment_type'];
                    $model->points_earned = Yii::$app->request->post('Payment')['points_earned'];
                    $model->points_redeem = $pointsRedeem;
                    $model->remarks = Yii::$app->request->post('Payment')['remarks'];
                    $model->payment_date = Yii::$app->request->post('Payment')['payment_date'];
                    $model->payment_time = Yii::$app->request->post('Payment')['payment_time'];
                    $model->status = 1;
                    
                    $model->save();
                    
                    $lastId = $model->id;

                    $invoice = Invoice::findOne(Yii::$app->request->post('Payment')['invoice_id']);
                    $invoice->status = 1;
                    $invoice->paid = 1;
                    $invoice->paid_type = 1;
                    $invoice->save();

                    $invoice = Invoice::findOne(Yii::$app->request->post('Payment')['invoice_id']);
                    $invoice->status = 1;
                    $invoice->paid = 1;
                    $invoice->paid_type = 1;
                    $invoice->save();

                    $invoiceDetail = InvoiceDetail::find()->where(['invoice_id' => Yii::$app->request->post('Payment')['invoice_id'] ])->one();
                    $invoiceDetail->status = 1;
                    $invoiceDetail->save();

                    $getPoints = Customer::find()->where(['id' => Yii::$app->request->post('Payment')['customer_id'] ])->one();
                    $points = $getPoints->points;
                    $totalPoints = $points - $pointsRedeem;
                    $totalPoints += Yii::$app->request->post('Payment')['points_earned'];

                    $getPoints->points = $totalPoints;
                    $getPoints->save();

                    $getInvoice = $searchModel->getPaidInvoice($lastId,Yii::$app->request->post('Payment')['invoice_id'], Yii::$app->request->post('Payment')['invoice_no'], Yii::$app->request->post('Payment')['customer_id']);

                    $getServices = $searchModel->getInvoiceServiceDetail(Yii::$app->request->post('Payment')['invoice_id']);
                    $getParts = $searchModel->getInvoicePartDetail(Yii::$app->request->post('Payment')['invoice_id']);

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
                    
                    if( empty(Yii::$app->request->post('Payment')['mlPoints_redeem']) ) {
                        $mlPointsRedeem = 0;
                    } else {
                        $mlPointsRedeem = Yii::$app->request->post('Payment')['mlPoints_redeem'];
                    }

                    $getId = array();

                    foreach( Yii::$app->request->post('Payment')['mlPayment_type'] as $key => $value ) {
                         $mModel = new Payment();
                         
                         $mModel->invoice_id = Yii::$app->request->post('Payment')['mInvoice_id'];
                         $mModel->invoice_no = Yii::$app->request->post('Payment')['mInvoice_no'] . '-' . $key;
                         $mModel->customer_id = Yii::$app->request->post('Payment')['mCustomer_id'];
                         $mModel->amount = Yii::$app->request->post('Payment')['mlAmount'][$key];
                         $mModel->discount = Yii::$app->request->post('Payment')['mlDiscount'][$key];
                         $mModel->payment_method = $paymentMethod;
                         $mModel->payment_type = $value;
                         $mModel->points_earned = Yii::$app->request->post('Payment')['mlPoints_earned'][$key];
                         $mModel->points_redeem = $mlPointsRedeem[$key];
                         $mModel->remarks = Yii::$app->request->post('Payment')['mlRemarks'][$key];
                         $mModel->payment_date = Yii::$app->request->post('Payment')['mPayment_date'];
                         $mModel->payment_time = Yii::$app->request->post('Payment')['mPayment_time'];
                         $mModel->status = 1;
                         
                         $invoiceNo = Yii::$app->request->post('Payment')['mInvoice_no'] . '-' . $key;

                         $getMultipleInvoiceResult = $searchModel->checkMultipleInvoice(Yii::$app->request->post('Payment')['mInvoice_id'], $invoiceNo, Yii::$app->request->post('Payment')['mCustomer_id']);

                         if( empty($getMultipleInvoiceResult) ) {
                                $mModel->save();
                                $getId[] = $mModel->id;
                         }
                         
                         $getPoints = Customer::find()->where(['id' => Yii::$app->request->post('Payment')['mCustomer_id'] ])->all();
                         
                         foreach( $getPoints as $mcPointsRow) {
                            $customerPoints = $mcPointsRow['points'];
                            $totalPoints = $customerPoints - $mlPointsRedeem[$key];

                            $findCustomer = Customer::findOne(Yii::$app->request->post('Payment')['mCustomer_id']);
                            $findCustomer->points = $totalPoints;
                            $findCustomer->save();
                         }

                    }
                    
                        $invoice = Invoice::findOne(Yii::$app->request->post('Payment')['mInvoice_id']);
                        $invoice->status = 1;
                        $invoice->paid = 1;
                        $invoice->paid_type = 2;
                        $invoice->save();

                        $invoiceDetail = InvoiceDetail::find()->where(['invoice_id' => Yii::$app->request->post('Payment')['mInvoice_id'] ])->one();
                        $invoiceDetail->status = 1;
                        $invoiceDetail->save();

                     $getMultipleInvoice = $searchModel->getPaidMultipleInvoice($getId, Yii::$app->request->post('Payment')['mInvoice_id'], Yii::$app->request->post('Payment')['mInvoice_no'], Yii::$app->request->post('Payment')['mCustomer_id']);

                     $getServices = $searchModel->getInvoiceServiceDetail(Yii::$app->request->post('Payment')['mInvoice_id']);
                     $getParts = $searchModel->getInvoicePartDetail(Yii::$app->request->post('Payment')['mInvoice_id']);

                     $this->layout = 'print';

                     return $this->render('_print-multiple-invoice',[
                      'multipleInvoiceInfo' => $getMultipleInvoice,
                      'services' => $getServices,
                      'parts' => $getParts
                     ]);
            }

        }

    }

    public function actionInsertInPaymentList() 
    {
        $detail = new Payment();
        $this->layout = false;

        return $this->render('add-payment-lists', [
                            'n' => Yii::$app->request->post('n'),
                            'mPayment_type' => Yii::$app->request->post('mPayment_type'),
                            'mAmount' => Yii::$app->request->post('mAmount'),
                            'mDiscount' => Yii::$app->request->post('mDiscount'),
                            'mPoints_redeem' => Yii::$app->request->post('mPoints_redeem'),
                            'mPoints_earned' => Yii::$app->request->post('mPoints_earned'),
                            'mRemarks' => Yii::$app->request->post('mRemarks'),
                            'detail' => $detail,
                        ]);
    }

    public function actionPrintInvoice($id,$invoice_no) 
    {
        $model = new Payment();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getPaidInvoiceById($id,$invoice_no);
        $getServices = $searchModel->getInvoiceServiceDetail($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-invoice',[
            'customerInfo' => $getInvoice,
            'services' => $getServices,
            'parts' => $getParts
        ]);

    }

    public function actionPrintMultipleInvoice($id,$invoice_no) 
    {
        $model = new Payment();
        $searchModel = new SearchInvoice();

        $multipleInvoiceInfo = $searchModel->getPaidMultipleInvoiceById($id,$invoice_no);
        $getServices = $searchModel->getInvoiceServiceDetail($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-multiple-invoice',[
            'multipleInvoiceInfo' => $multipleInvoiceInfo,
            'services' => $getServices,
            'parts' => $getParts
        ]);
    }

    public function actionExportExcel() 
    {
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
