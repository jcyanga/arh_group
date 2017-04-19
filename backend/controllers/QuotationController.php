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
use common\models\Customer;
use common\models\SearchCustomer;
use common\models\SearchInventory;
use common\models\SearchService;
use common\models\SearchGst;
use common\models\SearchProduct;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
use common\models\CarInformation;

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
            $date_start = Yii::$app->request->get('date_start');
            $date_end = Yii::$app->request->get('date_end');
            $customerName = '';
            $vehicleNumber = '';

        } elseif ( Yii::$app->request->get('customer_name') <> "" || Yii::$app->request->get('carplate') <> "" ) {
            $getQuotation = $searchModel->getQuotationByCustomerInformation(Yii::$app->request->get('customer_name'), Yii::$app->request->get('carplate'));
            $date_start = '';
            $date_end = '';
            $customerName = Yii::$app->request->get('customer_name');
            $vehicleNumber = Yii::$app->request->get('carplate');
        
        } else {
            $getQuotation = $searchModel->getQuotation();
            $date_start = '';
            $date_end = '';
            $customerName = '';
            $vehicleNumber = '';

        }

        return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'getQuotation' => $getQuotation,
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
                        'parts' => $getProcessedParts, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
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
        $modelQD = new QuotationDetail();
        $searchModel = new SearchQuotation();

        $quotationLastId = $this->_getQuotationId();
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

            $model->quotation_code = Yii::$app->request->post('quotationCode');
            $model->user_id = Yii::$app->request->post('salesPerson');
            $model->customer_id = Yii::$app->request->post('customerId');
            $model->branch_id = Yii::$app->request->post('quoBranch');
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
            $model->invoice = 0;

            if ($model->validate()) {  
                $model->save();

                $quotationId = $model->id;
                
                foreach ( Yii::$app->request->post('itemQty') as $key => $value ) {
                    $quoD = new QuotationDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('servicePartId')[$key]['value']);
                    $getType = $getServicePart[0];
                    $getServicePartId = $getServicePart[1];

                    $quoD->quotation_id = $quotationId;
                    $quoD->service_part_id = $getServicePartId;
                    $quoD->quantity = Yii::$app->request->post('itemQty')[$key]['value'];
                    $quoD->selling_price = Yii::$app->request->post('itemPriceValue')[$key]['value'];
                    $quoD->subTotal = Yii::$app->request->post('itemSubTotal')[$key]['value'];
                    $quoD->created_at = date("Y-m-d");
                    $quoD->created_by = Yii::$app->user->identity->id;
                    $quoD->type = $getType; 
                    $quoD->task = 0;
                    $quoD->invoice = 0;

                    $quoD->save();
                }

                if( (Yii::$app->request->post('task')) ) {
                    foreach( Yii::$app->request->post('task') as $key => $tValue ) {
                        $qdTask = QuotationDetail::find()->where(['quotation_id' => $quotationId])->andWhere(['service_part_id' => Yii::$app->request->post('task')[$key]['value'] ])->andWhere('type = 0')->one();
                        $qdTask->task = 1;
                        $qdTask->save();
                    }
                }
                 
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $quotationId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);

            }

        }

        return $this->render('_form', [
                    'model' => $model,
                    'quotationId' => $quotationLastId,
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

        $getQuotation = $searchModel->getProcessedQuotationbyId($id);
        $getProcessedServicesById = $searchModel->getProcessedServicesById($id);
        $getProcessedPartsById = $searchModel->getProcessedPartsById($id);
        $getLastId = $searchModel->getLastId($id);
        $getGst = Gst::find()->where(['branch_id' => $getQuotation['branch_id'] ])->one();

        $quotation_id = $this->_getQuotationId();
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

                $findModel = Quotation::findOne($id);

                $findModel->quotation_code = Yii::$app->request->post('quotationCode');
                $findModel->user_id = Yii::$app->request->post('salesPerson');
                $findModel->customer_id = Yii::$app->request->post('customerId');
                $findModel->branch_id = Yii::$app->request->post('quoBranch');
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
                $findModel->invoice = 0;

                if ($findModel->validate()) {  
                    $findModel->save();
                                         
                    Yii::$app->db->createCommand()
                    ->delete('quotation_detail', "quotation_id = $id" )
                    ->execute();

                    foreach ( Yii::$app->request->post('itemQty') as $key => $value ) {
                        $quoD = new QuotationDetail();

                        $getServicePart = explode('-', Yii::$app->request->post('servicePartId')[$key]['value']);
                        $getType = $getServicePart[0];
                        $getServicePartId = $getServicePart[1];

                        $quoD->quotation_id = $id;
                        $quoD->service_part_id = $getServicePartId;
                        $quoD->quantity = Yii::$app->request->post('itemQty')[$key]['value'];
                        $quoD->selling_price = Yii::$app->request->post('itemPriceValue')[$key]['value'];
                        $quoD->subTotal = Yii::$app->request->post('itemSubTotal')[$key]['value'];
                        $quoD->created_at = date("Y-m-d");
                        $quoD->created_by = Yii::$app->user->identity->id;
                        $quoD->type = $getType; 
                        $quoD->task = 0;
                        $quoD->invoice = 0;

                        $quoD->save();
                    }

                if( (Yii::$app->request->post('task')) ) {
                    foreach( Yii::$app->request->post('task') as $key => $tValue ) {
                        $qdTask = QuotationDetail::find()->where(['quotation_id' => $id])->andWhere(['service_part_id' => Yii::$app->request->post('task')[$key]['value'] ])->andWhere('type = 0')->one();
                        $qdTask->task = 1;
                        $qdTask->save();
                    }
                }
                 
                return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success', 'id' => $id ]);

            }else{
                return json_encode(['message' => $findModel->errors, 'status' => 'Error']);

            }

        }
            
        return $this->render('_update-form', [
                                    'model' => $model, 
                                    'quotation' => $getQuotation, 
                                    'getService' => $getProcessedServicesById,
                                    'getPart' => $getProcessedPartsById,
                                    'getLastId' => $getLastId,
                                    'quotationId' => $id,
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
                        'date_start' => '',
                        'date_end' => '',
                        'customerName' => '',
                        'vehicleNumber' => '',
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

    public function actionInsertInList() 
    {
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

        $getQuotation = $searchModel->getProcessedQuotationbyId($id);
        
        $yrNow = date('Y');
        $monthNow = date('m');
        $getInvoiceId = $searchInvoice->getInvoiceId();

        $invoiceNo ='INV' . $yrNow  . $monthNow . sprintf('%003d', $getInvoiceId);
        
        $getService = $searchModel->getProcessedServicesById($id);
        $getPart = $searchModel->getProcessedPartsById($id);
        $getLastId = $searchModel->getLastId($id);

        $getInvoice = Invoice::find()->where(['quotation_code' => $getQuotation['quotation_code'] ])->one();
     
        if( empty($getInvoice) ) {
            $invoice = new Invoice();
        
            $invoice->quotation_code = $getQuotation['quotation_code'];
            $invoice->invoice_no = $invoiceNo;
            $invoice->user_id = Yii::$app->user->identity->id;
            $invoice->customer_id = $getQuotation['customer_id'];
            $invoice->branch_id = $getQuotation['branch_id'];
            $invoice->date_issue = $getQuotation['date_issue'];
            $invoice->grand_total = $getQuotation['grand_total'];
            $invoice->gst = $getQuotation['gst'];
            $invoice->net = $getQuotation['net'];
            $invoice->remarks = $getQuotation['remarks'];
            $invoice->mileage = $getQuotation['mileage'];
            $invoice->come_in = $getQuotation['come_in'];
            $invoice->come_out = $getQuotation['come_out'];
            $invoice->created_at = $getQuotation['created_at'];
            $invoice->time_created = $getQuotation['time_created'];
            $invoice->discount_amount = $getQuotation['discount_amount'];
            $invoice->discount_remarks = $getQuotation['discount_remarks'];
            $invoice->created_by = $getQuotation['created_by'];
            $invoice->updated_at = $getQuotation['updated_at'];
            $invoice->updated_by = $getQuotation['updated_by'];
            $invoice->delete = $getQuotation['delete'];
            $invoice->task = $getQuotation['task'];
            $invoice->paid = 0;
            $invoice->paid_type = 0;
            $invoice->status = 0;
            $invoice->payment_status = 'Unpaid';
            $invoice->balance_amount = $getQuotation['net'];

            $invoice->save();
            $invoiceId = $invoice->id;

            foreach( $getService as $sRow ) {

                $sDetails = new InvoiceDetail();

                $sDetails->invoice_id = $invoiceId;
                $sDetails->service_part_id = $sRow['service_part_id'];
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

                $getPart = Product::find()->where(['id' => $pRow['productId'] ])->one();
                $old_qty = $getPart->quantity;
                $new_qty = $getPart->quantity - $pRow['quantity'];

                $inventoryModel = new Inventory();
                            
                $inventoryModel->product_id = $pRow['productId'];
                $inventoryModel->old_quantity = $old_qty;
                $inventoryModel->new_quantity = $new_qty;
                $inventoryModel->qty_purchased = $pRow['quantity'];
                $inventoryModel->type = 2;
                $inventoryModel->invoice_no = $invoiceNo;
                $inventoryModel->datetime_purchased = date('Y-m-d H:i:s', strtotime($getQuotation['date_issue']));
                $inventoryModel->created_at = date('Y-m-d H:i:s');
                $inventoryModel->created_by = Yii::$app->user->identity->id;
                $inventoryModel->status = 1;
                
                $inventoryModel->save();

                $getPart = Product::find()->where(['id' => $pRow['productId'] ])->one();
                $getPart->quantity -= $pRow['quantity'];
                $getPart->save();
            }

            Yii::$app->db->createCommand()
                ->update('quotation', ['invoice' => 1], "id = $id")
                ->execute();

            Yii::$app->db->createCommand()
                ->update('quotation_detail', ['invoice' => 1], "quotation_id = $id")
                ->execute();
                
            return $this->redirect(['invoice/payment-method', 'id' => $invoiceId ]);

        }else{

            return $this->redirect(['invoice/payment-method', 'id' => $getInvoice->id ]);
        }  

    }

    public function actionCreateCustomer() 
    {
        $model = new Customer();
        $carModel = new CarInformation();
         
        return $this->render('_create-customer', [
                                    'model' => $model, 
                                    'carModel' => $carModel,
                                    'errTypeHeader' => '', 
                                    'errType' => '', 
                                    'msg' => ''
                                ]);
    }

    public function actionNewCompany()
    {
        if ( Yii::$app->request->post() ) {

            $model = new Customer();

            $contactPerson = (Yii::$app->request->post('contactPerson'))? Yii::$app->request->post('contactPerson') : '';
            $companyName = (Yii::$app->request->post('companyName'))? Yii::$app->request->post('companyName') : '';
            $uen_no = (Yii::$app->request->post('uenno'))? Yii::$app->request->post('uenno') : '';
            $companyAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $companyHanphoneNo = (Yii::$app->request->post('phoneNumber'))? Yii::$app->request->post('phoneNumber') : '';
            $companyOfficeNo = (Yii::$app->request->post('officeNumber'))? Yii::$app->request->post('officeNumber') : '';
            $companyEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';

            $model->password = Yii::$app->request->post('password');

            if ( !empty( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                $model->role = 10;
            }

            $model->fullname = $contactPerson;
            $model->company_name = $companyName;
            $model->uen_no = $uen_no;
            $model->address = $companyAddress;
            $model->hanphone_no = $companyHanphoneNo;
            $model->office_no = $companyOfficeNo;
            $model->email = $companyEmail;
            $model->remarks = $remarks;
            $model->join_date = $joinDate;
            $model->member_expiry = $memberExpiry;
            $model->is_member = $isMember;
            $model->is_blacklist = 0;
            $model->type = 1;
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->deleted = 0;

            if($model->validate()) {
               $model->save();

                $customerId = $model->id;

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');

                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    $commpanyCarInfo->customer_id = $customerId;
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;

                    $commpanyCarInfo->save();
                }

            // Yii::$app->mailer->compose()
            // ->setFrom('jcyanga28@yahoo.com')
            // ->setTo('jcyanga28@yahoo.com')
            // ->setSubject('Message subject')
            // ->setTextBody('content body here')
            // ->setHtmlBody('<b>CONTENT HEADER HERE</b>')
            // ->send();

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $model->id ]);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } 
    }

    public function actionNewCustomer()
    {
        if ( Yii::$app->request->post() ) {
            
            $model = new Customer();

            $fullname = (Yii::$app->request->post('customerName') )? Yii::$app->request->post('customerName') : '';
            $nric = (Yii::$app->request->post('nric') )? Yii::$app->request->post('nric') : '';
            $personAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $raceId = (Yii::$app->request->post('race') )? Yii::$app->request->post('race') : '';
            $personHanphone = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $personOfficeNo = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $personEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';

            $model->password = Yii::$app->request->post('password');

            if ( !empty( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                $model->role = 10;
            }

            $model->fullname = $fullname; 
            $model->nric = $nric;
            $model->address = $personAddress;
            $model->race_id = $raceId;
            $model->hanphone_no = $personHanphone;
            $model->office_no = $personOfficeNo;
            $model->email = $personEmail;
            $model->remarks = $remarks;
            $model->join_date =  $joinDate;
            $model->member_expiry = $memberExpiry;
            $model->is_member = $isMember;
            $model->is_blacklist = 0;
            $model->type = 2;
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->deleted = 0;
            
            if($model->validate()) {
               $model->save();

                $customerId = $model->id;

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');

                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    $commpanyCarInfo->customer_id = $customerId;
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;

                    $commpanyCarInfo->save();
                }

            // Yii::$app->mailer->compose()
            // ->setFrom('jcyanga28@yahoo.com')
            // ->setTo('jcyanga28@yahoo.com')
            // ->setSubject('Message subject')
            // ->setTextBody('content body here')
            // ->setHtmlBody('<b>CONTENT HEADER HERE</b>')
            // ->send();

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $model->id ]);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } 
    }

    public function actionCreateQuotation($id) 
    {
        $model = new Quotation();
        $modelQD = new QuotationDetail();
        $searchModel = new SearchQuotation();

        $quotationLastId = $this->_getQuotationId();
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

            $model->quotation_code = Yii::$app->request->post('quotationCode');
            $model->user_id = Yii::$app->request->post('salesPerson');
            $model->customer_id = Yii::$app->request->post('customerId');
            $model->branch_id = Yii::$app->request->post('quoBranch');
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
            $model->invoice = 0;

            if ($model->validate()) {  
                $model->save();

                $quotationId = $model->id;
                
                foreach ( Yii::$app->request->post('itemQty') as $key => $value ) {
                    $quoD = new QuotationDetail();

                    $getServicePart = explode('-', Yii::$app->request->post('servicePartId')[$key]['value']);
                    $getType = $getServicePart[0];
                    $getServicePartId = $getServicePart[1];

                    $quoD->quotation_id = $quotationId;
                    $quoD->service_part_id = $getServicePartId;
                    $quoD->quantity = Yii::$app->request->post('itemQty')[$key]['value'];
                    $quoD->selling_price = Yii::$app->request->post('itemPriceValue')[$key]['value'];
                    $quoD->subTotal = Yii::$app->request->post('itemSubTotal')[$key]['value'];
                    $quoD->created_at = date("Y-m-d");
                    $quoD->created_by = Yii::$app->user->identity->id;
                    $quoD->type = $getType; 
                    $quoD->task = 0;
                    $quoD->invoice = 0;

                    $quoD->save();
                }

                if( (Yii::$app->request->post('task')) ) {
                    foreach( Yii::$app->request->post('task') as $key => $tValue ) {
                        $qdTask = QuotationDetail::find()->where(['quotation_id' => $quotationId])->andWhere(['service_part_id' => Yii::$app->request->post('task')[$key]['value'] ])->andWhere('type = 0')->one();
                        $qdTask->task = 1;
                        $qdTask->save();
                    }
                }
                 
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success', 'id' => $quotationId ]);

            }else{
                return json_encode(['message' => $model->errors, 'status' => 'Error']);

            }

        }

        return $this->render('_quotation-form', [
                            'model' => $model,
                            'customer_id' => $id,
                            'quotationId' => $quotationLastId,
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
             ->setCellValue('C1', 'Jobsheet No.')
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
        $filename = "JobSheetList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

// ------- SELECT PARTS ------ //

    public function actionPartsList()
    {
        $searchModel = new SearchQuotation();
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
        $searchModel = new SearchQuotation();
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
        $detail = new QuotationDetail();
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
        $searchModel = new SearchQuotation();
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
        $searchModel = new SearchQuotation();
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
        $detail = new QuotationDetail();
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

}
