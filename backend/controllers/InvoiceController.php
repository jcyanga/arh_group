<?php

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use common\models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use common\models\Service;
use common\models\Inventory;
use common\models\InvoiceDetail;
use common\models\Product;
use common\models\Gst;
use common\models\Payment;
use common\models\ProductLevel;
use common\models\Customer;
use common\models\PaymentType;
use common\models\SearchCustomer;
use common\models\SearchInventory;
use common\models\SearchService;
use common\models\SearchGst;
use common\models\CarInformation;
use common\models\SearchProduct;

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
        
        if( Yii::$app->request->get('date_start') <> "" && Yii::$app->request->get('date_end') <> "" ) {
            $getInvoice = $searchModel->getInvoiceByDateRange(Yii::$app->request->get('date_start'), Yii::$app->request->get('date_end'));
            $date_start = Yii::$app->request->get('date_start');
            $date_end = Yii::$app->request->get('date_end');
            $customerName = '';
            $vehicleNumber = '';

        } elseif ( Yii::$app->request->get('customer_name') <> "" || Yii::$app->request->get('carplate') <> "" ) {
            $getInvoice = $searchModel->getInvoiceByCustomerInformation(Yii::$app->request->get('customer_name'), Yii::$app->request->get('carplate'));
            $date_start = '';
            $date_end = '';
            $customerName = Yii::$app->request->get('customer_name');
            $vehicleNumber = Yii::$app->request->get('carplate'); 

        } else {
            $getInvoice = $searchModel->getInvoice();
            $date_start = '';
            $date_end = '';
            $customerName = '';
            $vehicleNumber = '';
            
        }

        return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'getInvoice' => $getInvoice,
                        'date_start' => $date_start,
                        'date_end' => $date_end, 
                        'customerName' => $customerName,
                        'vehicleNumber' => $vehicleNumber,
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
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

         $paymentInformation = ( $getProcessedInvoice['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        return $this->render('view',[
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedInvoice,
                'services' => $getProcessedServices,
                'parts' => $getProcessedParts,
                'paymentInformation' => $paymentInformation,
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

        $invoiceLastId = $this->_getInvoiceId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( Yii::$app->request->post() ) {
            
            $grandTotal = (Yii::$app->request->post('grandTotal')) ? Yii::$app->request->post('grandTotal') : 0;

            $gstResult = (Yii::$app->request->post('gstResult')) ? Yii::$app->request->post('gstResult') : 0;
            $netTotal = (Yii::$app->request->post('netTotal')) ? Yii::$app->request->post('netTotal') : 0;

            $remarks = (Yii::$app->request->post('remarks')) ? Yii::$app->request->post('remarks') : 'No remarks.';
            $discount_amount = (Yii::$app->request->post('discountAmount')) ? Yii::$app->request->post('discountAmount') : '0.00';
            $discount_remarks = (Yii::$app->request->post('discountRemarks')) ? Yii::$app->request->post('discountRemarks') : 'No discount remarks.';

            $model->quotation_code = 0;
            $model->invoice_no = Yii::$app->request->post('invoiceCode');
            $model->user_id = Yii::$app->request->post('salesPerson');
            $model->customer_id = Yii::$app->request->post('customerId');
            $model->branch_id = Yii::$app->request->post('invBranch');
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
            $model->grand_total = $grandTotal;
            $model->gst = $gstResult;
            $model->net = $netTotal;
            $model->remarks = $remarks;
            $model->mileage = Yii::$app->request->post('mileage');
            $model->come_in = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('comein')));
            $model->come_out = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('comeout')));
            $model->created_by = Yii::$app->user->identity->id;
            $model->discount_amount = $discount_amount;
            $model->discount_remarks = $discount_remarks;
            $model->created_at = date("Y-m-d");
            $model->time_created = date("H:i:s");
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = date("Y-m-d");
            $model->delete = 0;
            $model->task = 0;
            $model->paid = 0;
            $model->paid_type = 0;
            $model->status = 0;

            if ($model->validate()) {  
                $model->save();

                $invoiceId = $model->id;
                
                foreach ( Yii::$app->request->post('itemQty') as $key => $value ) {
                    $invD = new InvoiceDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('servicePartId')[$key]['value']);
                    $getType = $getServicePart[0];
                    $getServicePartId = $getServicePart[1];

                    $invD->invoice_id = $invoiceId;
                    $invD->service_part_id = $getServicePartId;
                    $invD->quantity = Yii::$app->request->post('itemQty')[$key]['value'];
                    $invD->selling_price = Yii::$app->request->post('itemPriceValue')[$key]['value'];
                    $invD->subTotal = Yii::$app->request->post('itemSubTotal')[$key]['value'];
                    $invD->created_at = date("Y-m-d");
                    $invD->created_by = Yii::$app->user->identity->id;
                    $invD->type = $getType; 
                    $invD->task = 0;
                    $invD->status = 0;

                    $invD->save();

                    if( $getType == '1' ) {
                        $getPart = Product::find()->where(['id' => $getServicePartId])->one();
                        $old_qty = $getPart->quantity;
                        $new_qty = $getPart->quantity - Yii::$app->request->post('itemQty')[$key]['value'];

                        $inventoryModel = new Inventory();
                        
                        $inventoryModel->product_id = $getServicePartId;
                        $inventoryModel->old_quantity = $old_qty;
                        $inventoryModel->new_quantity = $new_qty;
                        $inventoryModel->qty_purchased = Yii::$app->request->post('itemQty')[$key]['value'];
                        $inventoryModel->type = 2;
                        $inventoryModel->invoice_no = Yii::$app->request->post('invoiceCode');
                        $inventoryModel->datetime_purchased = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
                        $inventoryModel->created_at = date('Y-m-d H:i:s');
                        $inventoryModel->created_by = Yii::$app->user->identity->id;
                        $inventoryModel->status = 1;
                        $inventoryModel->save();

                        $getPart = Product::find()->where(['id' => $getServicePartId])->one();
                        $getPart->quantity -= Yii::$app->request->post('itemQty')[$key]['value'];
                        $getPart->save();                        
                    }
                }

                if( (Yii::$app->request->post('task')) ) {
                    foreach( Yii::$app->request->post('task') as $key => $tValue ) {
                        $idTask = InvoiceDetail::find()->where(['invoice_id' => $invoiceId])->andWhere(['service_part_id' => Yii::$app->request->post('task')[$key]['value'] ])->andWhere('type = 0')->one();
                        $idTask->task = 1;
                        $idTask->save();
                    }
                }
                 
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $invoiceId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);

            }

        }

        return $this->render('_form', [
                        'model' => $model,
                        'invoiceId' => $invoiceLastId,
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
        $getGst = Gst::find()->where(['branch_id' => $getInvoice['BranchId'] ])->one();

        $invoiceLastId = $this->_getInvoiceId();
        $getBranchList = $searchModel->getBranch();
        $getUserList = $searchModel->getUser();
        $getCustomerList = $searchModel->getCustomer();
        $getServicesList = $searchModel->getServicesList();
        $getPartsList = $searchModel->getPartsList();

        if ( Yii::$app->request->post() ) {
            
            $grandTotal = (Yii::$app->request->post('grandTotal')) ? Yii::$app->request->post('grandTotal') : 0;

            $gstResult = (Yii::$app->request->post('gstResult')) ? Yii::$app->request->post('gstResult') : 0;
            $netTotal = (Yii::$app->request->post('netTotal')) ? Yii::$app->request->post('netTotal') : 0;

            $remarks = (Yii::$app->request->post('remarks')) ? Yii::$app->request->post('remarks') : 'No remarks.';
            $discount_amount = (Yii::$app->request->post('discountAmount')) ? Yii::$app->request->post('discountAmount') : '0.00';
            $discount_remarks = (Yii::$app->request->post('discountRemarks')) ? Yii::$app->request->post('discountRemarks') : 'No discount remarks.';

            $findModel = Invoice::findOne(6);

            $findModel->quotation_code = 0;
            $findModel->invoice_no = Yii::$app->request->post('invoiceCode');
            $findModel->user_id = Yii::$app->request->post('salesPerson');
            $findModel->customer_id = Yii::$app->request->post('customerId');
            $findModel->branch_id = Yii::$app->request->post('invBranch');
            $findModel->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
            $findModel->grand_total = $grandTotal;
            $findModel->gst = $gstResult;
            $findModel->net = $netTotal;
            $findModel->remarks = $remarks;
            $findModel->mileage = Yii::$app->request->post('mileage');
            $findModel->come_in = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('comein')));
            $findModel->come_out = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('comeout')));
            $findModel->created_by = Yii::$app->user->identity->id;
            $findModel->discount_amount = $discount_amount;
            $findModel->discount_remarks = $discount_remarks;
            $findModel->created_at = date("Y-m-d");
            $findModel->time_created = date("H:i:s");
            $findModel->updated_by = Yii::$app->user->identity->id;
            $findModel->updated_at = date("Y-m-d");
            $findModel->delete = 0;
            $findModel->task = 0;
            $findModel->paid = 0;
            $findModel->paid_type = 0;
            $findModel->status = 0;

            if ($findModel->validate()) {  
                $findModel->save();

                $getQty = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere('type = 1')->all();
                        
                foreach( $getQty as $partsInfo ) {
                    $partsid = $partsInfo['service_part_id'];
                     
                    $findPartModel = Product::findOne($partsid);
                    $findPartModel->quantity += $partsInfo['quantity'];
                    $findPartModel->save();
                }

                Yii::$app->db->createCommand()
                ->delete('invoice_detail', "invoice_id = $id" )
                ->execute();
                
                foreach ( Yii::$app->request->post('itemQty') as $key => $value ) {
                    $invD = new InvoiceDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('servicePartId')[$key]['value']);
                    $getType = $getServicePart[0];
                    $getServicePartId = $getServicePart[1];

                    $invD->invoice_id = $id;
                    $invD->service_part_id = $getServicePartId;
                    $invD->quantity = Yii::$app->request->post('itemQty')[$key]['value'];
                    $invD->selling_price = Yii::$app->request->post('itemPriceValue')[$key]['value'];
                    $invD->subTotal = Yii::$app->request->post('itemSubTotal')[$key]['value'];
                    $invD->created_at = date("Y-m-d");
                    $invD->created_by = Yii::$app->user->identity->id;
                    $invD->type = $getType; 
                    $invD->task = 0;
                    $invD->status = 0;

                    $invD->save();

                    if( $getType == '1' ) {
                        $getPart = Product::find()->where(['id' => $getServicePartId])->one();
                        $old_qty = $getPart->quantity;
                        $new_qty = $getPart->quantity - Yii::$app->request->post('itemQty')[$key]['value'];

                        $inventoryModel = new Inventory();
                        
                        $inventoryModel->product_id = $getServicePartId;
                        $inventoryModel->old_quantity = $old_qty;
                        $inventoryModel->new_quantity = $new_qty;
                        $inventoryModel->qty_purchased = Yii::$app->request->post('itemQty')[$key]['value'];
                        $inventoryModel->type = 2;
                        $inventoryModel->invoice_no = Yii::$app->request->post('invoiceCode');
                        $inventoryModel->datetime_purchased = date('Y-m-d', strtotime(Yii::$app->request->post('dateIssue')));
                        $inventoryModel->created_at = date('Y-m-d H:i:s');
                        $inventoryModel->created_by = Yii::$app->user->identity->id;
                        $inventoryModel->status = 1;
                        $inventoryModel->save();

                        $getPart = Product::find()->where(['id' => $getServicePartId])->one();
                        $getPart->quantity -= Yii::$app->request->post('itemQty')[$key]['value'];
                        $getPart->save();                        
                    }
                }

                if( (Yii::$app->request->post('task')) ) {
                    foreach( Yii::$app->request->post('task') as $key => $tValue ) {
                        $idTask = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere(['service_part_id' => Yii::$app->request->post('task')[$key]['value'] ])->andWhere('type = 0')->one();
                        $idTask->task = 1;
                        $idTask->save();
                    }
                }
                 
                return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success', 'id' => $id ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);

            }

        }

        return $this->render('_update-form', [
                        'model' => $model,
                        'invoice' => $getInvoice, 
                        'getService' => $getService,
                        'getPart' => $getPart,
                        'getLastId' => $getLastId,
                        'invoiceId' => $invoiceLastId,
                        'getBranchList' => $getBranchList,
                        'getUserList' => $getUserList,
                        'getCustomerList' => $getCustomerList,
                        'getServicesList' => $getServicesList,
                        'getPartsList' => $getPartsList, 
                        'gst' => $getGst['gst'],
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
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

        Yii::$app->db->createCommand()
            ->delete('payment', "invoice_id = $id" )
            ->execute();

        $getInvoice = $searchModel->getInvoice();

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getInvoice' => $getInvoice,
                            'dataProvider' => $dataProvider, 
                            'date_start' => '',
                            'date_end' => '',
                            'customerName' => '',
                            'vehicleNumber' => '',
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

         $paymentInformation = ($getProcessedInvoiceById['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        if($getProcessedInvoiceById['paid'] >= 2 || $getProcessedInvoiceById['paid'] == 0){

            return $this->render('payment-method',[
                        'model' => $this->findModel($id),
                        'customerInfo' => $getProcessedInvoiceById,
                        'services' => $getProcessedServicesById,
                        'parts' => $getProcessedPartsById,
                        'paymentInformation' => $paymentInformation,
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
        }else{

            return $this->redirect(['view', 'id' => $id]);
        }

    }

    public function actionInsertInPaymentList() 
    {
        $detail = new Payment();
        $this->layout = false;

        $getPaymentTypeName = PaymentType::find()->where(['id' => Yii::$app->request->post('mPayment_type') ])->one();

        if(is_null(Yii::$app->request->post('mPoints_redeem')) || Yii::$app->request->post('mPoints_redeem') == ''){
            
            $pointsRedeem = 0;
        
        }else{

            $pointsRedeem = Yii::$app->request->post('mPoints_redeem');

        }

        return $this->render('add-payment-lists', [
                            'n' => Yii::$app->request->post('n'),
                            'mPayment_type' => $getPaymentTypeName['id'],
                            'mPayment_type_name' => $getPaymentTypeName['name'],
                            'mAmount' => Yii::$app->request->post('mAmount'),
                            'mPoints_redeem' => $pointsRedeem,
                            'mRemarks' => Yii::$app->request->post('mRemarks'),
                            'detail' => $detail,
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

// ------- SELECT PARTS ------ //

    public function actionPartsList()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getPartsList();

        $data = array();
        foreach($result as $rowP)
        {
           $products = array(
                    'id' => $rowP['id'],
                    'supplier_name' => $rowP['supplier_name'],
                    'product_name' => $rowP['product_name'],   
                );
            
            $data[] = $products;    
        }
         
        return json_encode($data);
    }

    public function actionPartsByCategory()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getPartsByCategory(Yii::$app->request->get('partsCategory'));

        $data = array();
        foreach($result as $rowP)
        {
           $products = array(
                    'id' => $rowP['id'],
                    'supplier_name' => $rowP['supplier_name'],
                    'product_name' => $rowP['product_name'],   
                );
            
            $data[] = $products;    
        }
        

        return json_encode($data);
    }

    public function actionInsertOtherPart() 
    {
        $this->layout = false;

        if( Yii::$app->request->post() ) {

            return $this->render('item-list', [
                    'n' => Yii::$app->request->post('n'),
                    'itemQty' => 1,
                    'itemPriceValue' => Yii::$app->request->post()['partsPrice'],
                    'itemSubTotal' => Yii::$app->request->post()['partsPrice'],
                    'partId' => 1,
                    'partName' => Yii::$app->request->post()['partsDescription'],
                    'serviceId' => false,
                    'serviceName' => false,
                    'itemType' => 2,
                ]);
        }  

    }

    public function actionInsertPartsInItemList() 
    {
        $searchModel = new SearchProduct();
        $getParts = $searchModel->getProductListById(Yii::$app->request->post('services_parts'));

        $this->layout = false;

        if( Yii::$app->request->post() ) {

            return $this->render('parts-in-item-list', [
                                'getParts' => $getParts,
                                'partsCtr' => Yii::$app->request->post('partsCtr')
                            ]);

        }
    }

    public function actionInsertPartsInList() 
    {
        $detail = new InvoiceDetail();
        $this->layout = false;

        if( Yii::$app->request->post() ) {
        
            return $this->render('item-list', [
                    'n' => Yii::$app->request->post('n'),
                    'itemQty' => Yii::$app->request->post('itemQty'),
                    'itemPriceValue' => Yii::$app->request->post('itemUnitPrice'),
                    'itemSubTotal' => Yii::$app->request->post('itemSubTotal'),
                    'partId' => Yii::$app->request->post('itemProductId'),
                    'partName' => Yii::$app->request->post('itemProductName'),
                    'serviceId' => false,
                    'serviceName' => false,
                    'itemType' => 1,
                    'detail' => $detail,
                ]);
        }  

    }

// -------- SELECT SERVICE ---------- //

    public function actionServiceList()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getServicesList();

        $data = array();
        foreach($result as $rowS)
        {
           $services = array(
                    'id' => $rowS['id'],
                    'service_category' => $rowS['name'],
                    'service_name' => $rowS['service_name'],   
                );
            
            $data[] = $services;    
        }
         
        return json_encode($data);
    }

    public function actionServiceByCategory()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getServicesByCategory(Yii::$app->request->get('serviceCategory'));

        $data = array();
        foreach($result as $rowS)
        {
           $products = array(
                    'id' => $rowS['id'],
                    'service_category' => $rowS['name'],
                    'service_name' => $rowS['service_name'],   
                );
            
            $data[] = $products;    
        }
        

        return json_encode($data);
    }

    public function actionInsertOtherService() 
    {
        $this->layout = false;

        if( Yii::$app->request->post() ) {
            
            return $this->render('item-list', [
                    'n' => Yii::$app->request->post('n'),
                    'itemQty' => 1,
                    'itemPriceValue' => Yii::$app->request->post()['servicePrice'],
                    'itemSubTotal' => Yii::$app->request->post()['servicePrice'],
                    'serviceId' => 1,
                    'serviceName' => Yii::$app->request->post()['serviceDescription'],
                    'partId' => false,
                    'partName' => false,
                    'itemType' => 3,
                ]);
        }  
    }

    public function actionInsertServiceInItemList() 
    {
        $searchModel = new SearchService();
        $getServices = $searchModel->getServiceListById(Yii::$app->request->post('parts_services'));

        $this->layout = false;

        if( Yii::$app->request->post() ) {

            return $this->render('service-in-item-list', [
                                'getServices' => $getServices,
                                'serviceCtr' => Yii::$app->request->post('serviceCtr')
                            ]);

        }
    }

    public function actionInsertServiceInList() 
    {
        $detail = new InvoiceDetail();
        $this->layout = false;

        if( Yii::$app->request->post() ) {
        
            return $this->render('item-list', [
                    'n' => Yii::$app->request->post('n'),
                    'itemQty' => Yii::$app->request->post('itemQty'),
                    'itemPriceValue' => Yii::$app->request->post('itemUnitPrice'),
                    'itemSubTotal' => Yii::$app->request->post('itemSubTotal'),
                    'partId' => false,
                    'partName' => false,
                    'serviceId' => Yii::$app->request->post('itemServiceId'),
                    'serviceName' => Yii::$app->request->post('itemServiceName'),
                    'itemType' => 0,
                    'detail' => $detail,
                ]);
        }  

    }

    // ---------------------------------------- //
    public function actionGetBranchGstById()
    {
        $searchModel = new SearchGst();
        $getBranchGst = $searchModel->getBranchGst(Yii::$app->request->get('branchId'));
        
        if( $getBranchGst == 0 ) {
            return 0;

        }else{
            return $getBranchGst;

        }

    }

    public function actionGetCustomerInformation()
    {
        $searchModel = new SearchCustomer();

        $getCustId = CarInformation::findOne(Yii::$app->request->get('car_id'));
        $getCustInfo = $searchModel->getCustomerListById($getCustId['customer_id']);

        $data = array();
        $data['fullname'] = $getCustInfo['fullname'];
        $data['nric'] = $getCustInfo['nric'];
        $data['company_name'] = $getCustInfo['company_name'];
        $data['uen_no'] = $getCustInfo['uen_no'];
        $data['address'] = $getCustInfo['address'];
        $data['hanphone_no'] = $getCustInfo['hanphone_no'];
        $data['office_no'] = $getCustInfo['office_no'];
        $data['email'] = $getCustInfo['email'];
        $data['remarks'] = $getCustInfo['remarks'];
        $data['type'] = $getCustInfo['type'];
        $data['name'] = $getCustInfo['name'];

        $getCarInfo = CarInformation::find()->where(['id' => Yii::$app->request->get('car_id') ])->one();
        
        $carInfo = array();
        $carInfo['carplate'] = $getCarInfo['carplate'];
        $carInfo['make'] = $getCarInfo['make'];
        $carInfo['model'] = $getCarInfo['model'];
        $carInfo['engine_no'] = $getCarInfo['engine_no'];
        $carInfo['year_mfg'] = $getCarInfo['year_mfg'];
        $carInfo['chasis'] = $getCarInfo['chasis'];
        $carInfo['points'] = $getCarInfo['points'];

        return json_encode(['customer_information' => $data, 'car_information' => $carInfo ]);
    }

    // ---------------------------------------- //
    public function actionGetPaymentType()
    {
        $getPaymentType = PaymentType::findOne(Yii::$app->request->post('mode_payment'));

        $data = array();
        $data['id'] = $getPaymentType['id'];
        $data['name'] = $getPaymentType['name'];
        $data['interest'] = $getPaymentType['interest'];

        return json_encode($data);
    }

    // ---------------------------------------- //
    public function actionGetPaymentTypeAndOthers()
    {
        $getPaymentType = PaymentType::findOne(Yii::$app->request->post('mode_payment'));

        $data = array();
        $data['id'] = $getPaymentType->id;
        $data['name'] = $getPaymentType->name;
        $data['interest'] = $getPaymentType->interest;
        $data['amount'] = Yii::$app->request->post('amount');
        $data['redeem_points'] = Yii::$app->request->post('redeem_points');
        $data['remarks'] = Yii::$app->request->post('remarks');

        return json_encode($data);
    }
    
    // ------------- Payment ----------------- //
    public function actionSaveSinglePayment()
    {
        $payment = new Payment();

        $payment->invoice_id = Yii::$app->request->post('invoice_id');
        $payment->invoice_no = Yii::$app->request->post('invoice_no');
        $payment->customer_id = Yii::$app->request->post('customer_id');
        $payment->net = Yii::$app->request->post('net');
        $payment->net_with_interest = Yii::$app->request->post('net_with_interest');
        $payment->amount = Yii::$app->request->post('amount');
        $payment->payment_method = Yii::$app->request->post('payment_method');
        $payment->points_earned = Yii::$app->request->post('net');
        $payment->points_redeem = Yii::$app->request->post('redeem_points');
        $payment->payment_type = Yii::$app->request->post('mode_payment');
        $payment->interest = Yii::$app->request->post('interest');
        $payment->remarks = Yii::$app->request->post('remarks');
        $payment->payment_status = Yii::$app->request->post('payment_status');
        $payment->payment_date = Yii::$app->request->post('payment_date');
        $payment->payment_time = Yii::$app->request->post('payment_time');
        $payment->status = 1;


        if( $payment->save() ) {

            $paidStatus = Invoice::findOne(Yii::$app->request->post('invoice_id'));
            $pointsEarned = ($paidStatus->paid_type == 0)? Yii::$app->request->post('net') : 0;

            switch(Yii::$app->request->post('payment_status'))
            {
                case 'Paid':
                    $paid_status = 1;
                break;

                case 'Partially Paid':
                    $paid_status = 2;
                break;

                default:
                    $paid_status = 0;
            }   

            $invoice = Invoice::findOne( Yii::$app->request->post('invoice_id') );
                        $invoice->status = 1;
                        $invoice->paid = $paid_status;
                        $invoice->paid_type = 1;
                        $invoice->payment_status = Yii::$app->request->post('payment_status');
                        $invoice->balance_amount = Yii::$app->request->post('totalAmount');
                        $invoice->save();

            $invoiceId = Yii::$app->request->post('invoice_id');

            Yii::$app->db->createCommand()
                ->update('invoice_detail', ['status' => 1], "invoice_id = $invoiceId")
                ->execute();

            $customerId = Yii::$app->request->post('customer_id');

            $customerPts = CarInformation::findOne( Yii::$app->request->post('customer_id') );
            
            $customerPointsInfo = $customerPts->points;
            $customerPointsInfo -= Yii::$app->request->post('redeem_points');
            $customerPointsInfo += $pointsEarned;
            
            Yii::$app->db->createCommand()
                ->update('car_information', ['points' => $customerPointsInfo], "id = $customerId")
                ->execute();
 
            return json_encode([ 'invoiceId' => Yii::$app->request->post('invoice_id'),
                                 'invoiceNo' => Yii::$app->request->post('invoice_no'),
                                 'customerId' => Yii::$app->request->post('customer_id'),
                              ]);
        }

    }

    public function actionPrintSinglePayment($invoiceId,$invoiceNo,$customerId)
    {
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getPaidInvoice($invoiceId,$invoiceNo,$customerId);
        $getServices = $searchModel->getInvoiceServiceDetail($invoiceId);
        $getParts = $searchModel->getInvoicePartDetail($invoiceId);

        $this->layout = 'print';

        return $this->render('_print-invoice',[
                            'customerInfo' => $getInvoice,
                            'services' => $getServices,
                            'parts' => $getParts
                        ]);
    }

    public function actionSaveMultiplePayment()
    {
        $amount = Yii::$app->request->post('amount');
        $payment_type = Yii::$app->request->post('mode_payment');
        $points_redeem = Yii::$app->request->post('redeem_points');
        $remarks = Yii::$app->request->post('remarks');
        $net = Yii::$app->request->post('net');
        $balance_amount = Yii::$app->request->post('balance_amount');

        foreach ($amount as $key => $mValue) {

            $getInterest = PaymentType::findOne($payment_type[$key]['value']);
            $interest = $getInterest->interest;

            if( $interest == '' ){
                $interest = 0;
            }else{
                $interest = '.'.$interest;
            }

            if( is_null($points_redeem[$key]['value']) || $points_redeem[$key]['value'] == '' ){
                $points_redeem[$key]['value'] = 0;
            }else{
                $points_redeem[$key]['value'] = $points_redeem[$key]['value'];
            }

            $amount_interest = $net * $interest;
            $amount_interest /= 100;

            $totalAmount = $balance_amount - $points_redeem[$key]['value'];
            $totalAmount += $amount_interest;

            if( $amount[$key]['value'] >= $totalAmount ) {
                $payment_status = 'Paid';
                $balance_amount = 0;

            }else if( $amount[$key]['value'] == 0 || $amount[$key]['value'] == '0.00' ) {
                $payment_status = 'Unpaid';
                $balance_amount = $net;

            }else{
                $payment_status = 'Partially Paid';
                $balance_amount = $totalAmount - $amount[$key]['value'];
            } 

            $net_with_interest = $net + $amount_interest;

            $payment = new Payment();

            $payment->invoice_id = Yii::$app->request->post('invoice_id');
            $payment->invoice_no = Yii::$app->request->post('invoice_no');
            $payment->customer_id = Yii::$app->request->post('customer_id');
            $payment->net = $net;
            $payment->net_with_interest = $net_with_interest;
            $payment->amount = $amount[$key]['value'];
            $payment->payment_method = Yii::$app->request->post('payment_method');
            $payment->points_earned = $net;
            $payment->points_redeem = $points_redeem[$key]['value'];
            $payment->payment_type = $payment_type[$key]['value'];
            $payment->interest = $interest;
            $payment->remarks = $remarks[$key]['value'];
            $payment->payment_status = $payment_status;
            $payment->payment_date = Yii::$app->request->post('payment_date');
            $payment->payment_time = Yii::$app->request->post('payment_time');
            $payment->status = 1;    

            if( $payment->save() ) {
                
                $paidStatus = Invoice::findOne(Yii::$app->request->post('invoice_id'));
                $pointsEarned = ($paidStatus->paid_type == 0)? $net : 0;

                switch($payment_status)
                {
                    case 'Paid':
                        $paid_status = 1;
                    break;

                    case 'Partially Paid':
                        $paid_status = 2;
                    break;

                    default:
                        $paid_status = 0;
                }   

                $invoice = Invoice::findOne( Yii::$app->request->post('invoice_id') );
                            $invoice->status = 1;
                            $invoice->paid = $paid_status;
                            $invoice->paid_type = 2;
                            $invoice->payment_status = $payment_status;
                            $invoice->balance_amount = $balance_amount;
                            $invoice->save();

                $invoiceId = Yii::$app->request->post('invoice_id');

                Yii::$app->db->createCommand()
                    ->update('invoice_detail', ['status' => 1], "invoice_id = $invoiceId")
                    ->execute();

                $customerId = Yii::$app->request->post('customer_id');

                $customerPts = CarInformation::findOne( Yii::$app->request->post('customer_id') );
            
                $customerPointsInfo = $customerPts->points;
                $customerPointsInfo -= $points_redeem[$key]['value'];
                $customerPointsInfo += $pointsEarned;
                
                Yii::$app->db->createCommand()
                    ->update('car_information', ['points' => $customerPointsInfo], "id = $customerId")
                    ->execute();
            }
        }
 
        return json_encode([ 'invoiceId' => Yii::$app->request->post('invoice_id'),
                             'invoiceNo' => Yii::$app->request->post('invoice_no'),
                             'customerId' => Yii::$app->request->post('customer_id'),
                          ]);

    }

    public function actionPrintMultiplePayment($invoiceId,$invoiceNo,$customerId)
    {
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getPaidMultipleInvoice($invoiceId,$invoiceNo,$customerId);
        $getServices = $searchModel->getInvoiceServiceDetail($invoiceId);
        $getParts = $searchModel->getInvoicePartDetail($invoiceId);

        $this->layout = 'print';

        return $this->render('_print-multiple-invoice',[
                            'multipleInvoiceInfo' => $getInvoice,
                            'services' => $getServices,
                            'parts' => $getParts
                        ]);
    }

    // ------------------------ PRINT -------------------------- //
    public function actionPrintInvoice($id,$invoice_no) 
    {
        $model = new Payment();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getPaidInvoiceById($id,$invoice_no);
        $getServices = $searchModel->getInvoiceServiceDetail($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-single-payment-invoice',[
            'getInvoice' => $getInvoice,
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

        return $this->render('_print-multiple-payment-invoice',[
            'multipleInvoiceInfo' => $multipleInvoiceInfo,
            'services' => $getServices,
            'parts' => $getParts
        ]);
    }

    public function actionPrintInvoiceNotPaid($id,$invoice_no) 
    {
        $model = new Payment();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getNotPaidInvoiceById($id,$invoice_no);
        $getServices = $searchModel->getInvoiceServiceDetail($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $this->layout = 'print';

        return $this->render('_print-single-notpaid-invoice',[
            'getInvoice' => $getInvoice,
            'services' => $getServices,
            'parts' => $getParts
        ]);
    }

    // ------ VIEW INVOICE FROM DASHBOARD ------- //

    public function actionViewByCustomerSearch($id,$invoiceNo)
    {
        $model = new Invoice();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getProcessedInvoice($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $paymentInformation = ( $getInvoice['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        return $this->render('_view-customer-invoice',[
            'customerInfo' => $getInvoice,
            'parts' => $getParts,
            'paymentInformation' => $paymentInformation,
        ]);

    }

    public function actionViewByOutstandingPayments($id,$invoiceNo)
    {
        $model = new Invoice();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getOutstandingPaymentInvoice($id);
        $getServices = $searchModel->getInvoiceServiceDetail($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $paymentInformation = ( $getInvoice['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        return $this->render('_view-outstanding-payment-invoice',[
            'customerInfo' => $getInvoice,
            'services' => $getServices,
            'parts' => $getParts,
            'paymentInformation' => $paymentInformation,
        ]);

    }

    public function actionViewByPendingServices($id,$invoiceNo)
    {
        $model = new Invoice();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getProcessedInvoice($id);
        $getServices = $searchModel->getInvoiceServiceDetail($id);

        $paymentInformation = ( $getInvoice['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        return $this->render('_view-pending-services-invoice',[
            'customerInfo' => $getInvoice,
            'services' => $getServices,
            'paymentInformation' => $paymentInformation,
        ]);

    }


    // ---------- RESERVE FUNCTIONS ------------- //

    // public function actionPrice() 
    // {
    //     $this->layout = false;

    //     if( Yii::$app->request->post() ) {

    //         $getItemType = explode('-', Yii::$app->request->post()['services_parts']);
    //         $ItemType = $getItemType[0];
    //         $ItemId = $getItemType[1];

    //         $itemSellingPrice = false;

    //         if( $ItemType == '0' ) {
    //             $service = Service::find()->where(['id' => $ItemId])->one();
    //             $itemSellingPrice = $service->default_price;
    //             $status = '';

    //         }else{
    //             $part = Inventory::find()->where(['id' => $ItemId])->one();
    //             $itemQty = $part->quantity;
                
    //             $getPartLevel = ProductLevel::find()->one();
    //             $criticalLvl = $getPartLevel->critical_level;
    //             $minimumLvl = $getPartLevel->minimum_level;

    //             switch($itemQty) {
    //                 case $minimumLvl:
    //                     $itemSellingPrice = $part->selling_price;
    //                     $status = 'minimum_level';
    //                  break;
                    
    //                 case $criticalLvl:
    //                     $itemSellingPrice = $part->selling_price;
    //                     $status = 'critical_level';
    //                  break;
                    
    //                 case 0:
    //                     $itemSellingPrice = '0';
    //                     $status = '0';
    //                  break;

    //                 default:
    //                     $itemSellingPrice = $part->selling_price;
    //                     $status = '';      
    //             } 

    //         }
    //         return json_encode(['price' => $itemSellingPrice, 'status' => $status]);

    //     }
    // }

    // public function actionCreateFromQuotation($id) 
    // {
    //     $model = new Invoice();
    //     $details = new InvoiceDetail();
    //     $searchModel = new SearchInvoice();

    //     $getInvoice = $searchModel->getProcessedInvoicebyId($id);
    //     $getService = $searchModel->getProcessedServicesbyId($id);
    //     $getPart = $searchModel->getProcessedPartsbyId($id);
    //     $getLastId = $searchModel->getLastId($id);

    //     $invoiceId = $this->_getInvoiceId();
    //     $getBranchList = $searchModel->getBranch();
    //     $getUserList = $searchModel->getUser();
    //     $getCustomerList = $searchModel->getCustomer();
    //     $getServicesList = $searchModel->getServicesList();
    //     $getPartsList = $searchModel->getPartsList();

    //     if ( $model->load(Yii::$app->request->post()) ) {
    //         $getGst = Gst::find()->where(['branch_id' => Yii::$app->request->post('Invoice')['selectedBranch'] ])->one();

    //         if( isset($getGst) ) {
    //             $totalWithGst = ( Yii::$app->request->post('Invoice')['grand_total'] * $getGst->gst);
    //             $totalWithGst = $totalWithGst / 100;
    //             $totalWithGst = Yii::$app->request->post('Invoice')['grand_total'] + $totalWithGst;
    //         } else {
    //             $totalWithGst = Yii::$app->request->post('Invoice')['grand_total'];
    //         }

    //         if( empty(Yii::$app->request->post('Quotation')['quotationCode']) ) {
    //             $quotationCode = 0;
    //         } else {
    //             $quotationCode = Yii::$app->request->post('Quotation')['quotationCode'];
    //         }

    //         if( Yii::$app->request->post('Invoice')['dateIssue'] == "" || Yii::$app->request->post('Invoice')['selectedBranch'] == 0 || Yii::$app->request->post('Invoice')['selectedCustomer'] == 0 || Yii::$app->request->post('Invoice')['selectedUser'] == 0 ) {
                    
    //                 return $this->render('_update-form', [
    //                                             'model' => $getInvoice, 
    //                                             'getService' => $getService,
    //                                             'getPart' => $getPart,
    //                                             'getLastId' => $getLastId,
    //                                             'invoiceId' => $invoiceId,
    //                                             'getBranchList' => $getBranchList,
    //                                             'getUserList' => $getUserList,
    //                                             'getCustomerList' => $getCustomerList,
    //                                             'getServicesList' => $getServicesList,
    //                                             'getPartsList' => $getPartsList, 
    //                                             'errTypeHeader' => 'Error!', 
    //                                             'errType' => 'alert alert-error', 
    //                                             'msg' => 'Fill-up all the *required fields in the form.'
    //                                         ]);
    //         }

    //         $findModel = Invoice::findOne($id);

    //         $findModel->invoice_no = Yii::$app->request->post('Invoice')['invoice_no'];
    //         $findModel->quotation_code = $quotationCode;
    //         $findModel->user_id = Yii::$app->request->post('Invoice')['selectedUser'];
    //         $findModel->customer_id = Yii::$app->request->post('Invoice')['selectedCustomer'];
    //         $findModel->branch_id = Yii::$app->request->post('Invoice')['selectedBranch'];
    //         $findModel->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('Invoice')['dateIssue']));
    //         $findModel->grand_total = $totalWithGst;
    //         $findModel->remarks = Yii::$app->request->post('Invoice')['remarks'];
    //         $findModel->updated_at = date("Y-m-d");
    //         $findModel->updated_by = Yii::$app->user->identity->id;
    //         $findModel->delete = 0;
    //         $findModel->task = 0;
    //         $findModel->paid = 0;
    //         $findModel->paid_type = 0;
    //         $findModel->status = 0;

    //         if ( $findModel->save() ) {

    //             if( $details->load(Yii::$app->request->post()) ) {   
    //                 $getQty = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere('type = 1')->all();
                    
    //                 foreach( $getQty as $idInfo ) {
    //                     $getPartInventoryQty = Inventory::find()->where(['id' => $idInfo['service_part_id'] ])->all();
                        
    //                     foreach( $getPartInventoryQty as $pInfo ) {
    //                         $totalPartQty = $pInfo['quantity'] + $idInfo['quantity'];
                            
    //                         $findPartModel = Inventory::findOne($idInfo['service_part_id']);
    //                         $findPartModel->quantity = $totalPartQty;
    //                         $findPartModel->save();
    //                     }
    //                 }

    //                 Yii::$app->db->createCommand()
    //                 ->delete('invoice_detail', "invoice_id = $id" )
    //                 ->execute();
                    
    //                 if( empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
    //                     $task = 0;
    //                 } else {
    //                     $task = Yii::$app->request->post('InvoiceDetail')['task'];
    //                 }

    //                 foreach ( Yii::$app->request->post('InvoiceDetail')['quantity'] as $key => $value) {
    //                     $invD = new InvoiceDetail();

    //                     $getServicePart = explode('-', Yii::$app->request->post('InvoiceDetail')['service_part_id'][$key]);
    //                     $getType = $getServicePart[0];
    //                     $getServicePartId = $getServicePart[1];
                        
    //                     $invD->invoice_id = $id;
    //                     $invD->service_part_id = $getServicePartId;
    //                     $invD->quantity = $value;
    //                     $invD->selling_price = Yii::$app->request->post('InvoiceDetail')['selling_price'][$key];
    //                     $invD->subTotal = Yii::$app->request->post('InvoiceDetail')['subTotal'][$key];
    //                     $invD->created_at = date("Y-m-d");
    //                     $invD->created_by = Yii::$app->user->identity->id;
    //                     $invD->type = $getType;
    //                     $invD->task = 0;
    //                     $invD->status = 0;

    //                     $invD->save();

    //                     if( $getType == 1 ) {
    //                         $getPart = Inventory::find()->where(['id' => $getServicePartId])->one();                           
    //                         $totalQty = $getPart->quantity - $value;
                            
    //                         Yii::$app->db->createCommand()
    //                             ->update('inventory', ['quantity' => $totalQty ], "id = $getServicePartId" )
    //                             ->execute();
    //                     }
    //                 }
                 
    //              if( !empty(Yii::$app->request->post('InvoiceDetail')['task']) ) {
    //                  foreach( Yii::$app->request->post('InvoiceDetail')['task'] as $key => $tValue ) {
    //                     $qdTask = InvoiceDetail::find()->where(['invoice_id' => $id])->andWhere(['service_part_id' => $tValue])->andWhere('type = 0')->one();
    //                     $qdTask->task = 1;
    //                     $qdTask->save();

    //                  }
    //              }

    //              return $this->redirect(['view', 'id' => $id]);
    //             }
    //         }

    //     } else {

    //         return $this->render('_create-from-quotation', [
    //                                 'model' => $getInvoice, 
    //                                 'getService' => $getService,
    //                                 'getPart' => $getPart,
    //                                 'getLastId' => $getLastId,
    //                                 'invoiceId' => $invoiceId,
    //                                 'getBranchList' => $getBranchList,
    //                                 'getUserList' => $getUserList,
    //                                 'getCustomerList' => $getCustomerList,
    //                                 'getServicesList' => $getServicesList,
    //                                 'getPartsList' => $getPartsList, 
    //                                 'errTypeHeader' => '', 
    //                                 'errType' => '', 
    //                                 'msg' => ''
    //                             ]);

    //     }

    // }

}
