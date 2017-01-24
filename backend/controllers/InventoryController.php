<?php

namespace backend\controllers;

use Yii;
use common\models\Inventory;
use common\models\SearchInventory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

use yii\web\Response;
use common\models\Product;
use common\models\StockIn;
use common\models\Supplier;

use common\models\SearchProduct;
/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Inventory'])->andWhere(['role_id' => $uRId ] )->all();
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
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Inventory();
        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getProductInInventory = $searchModel->getProductInInventory();

        return $this->render('index', [
                                'model' => $model, 
                                'searchModel' => $searchModel, 
                                'dataProvider' => $dataProvider, 
                                'getProductInInventory' => $getProductInInventory, 
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => ''
                            ]);
    }

    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new SearchInventory();
        $getProductInInventoryById = $model->getProductInInventoryById($id);

        return $this->render('view', [
                        'model' => $getProductInInventoryById,
        ]);
    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Inventory();
        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchProductModel = new SearchProduct();

        if ($model->load(Yii::$app->request->post())) {
            
            foreach ( Yii::$app->request->post('Inventory')['product'] as $key => $value) {
            
            $result = $searchModel->selectSupplierNameandProductName(Yii::$app->request->post('Inventory')['supplier_id'][$key], $value);

                $inventory = new Inventory();
                $inventory->supplier_id = Yii::$app->request->post('Inventory')['supplier_id'][$key];
                $inventory->product_id = $value;
                $inventory->quantity = Yii::$app->request->post('Inventory')['quantity'][$key];
                $inventory->cost_price = Yii::$app->request->post('Inventory')['cost_price'][$key];
                $inventory->selling_price = Yii::$app->request->post('Inventory')['selling_price'][$key];
                $inventory->date_imported = Yii::$app->request->post('Inventory')['date_imported'];
                $inventory->created_at = Yii::$app->request->post('Inventory')['created_at'];
                $inventory->created_by = Yii::$app->request->post('Inventory')['created_by'];

                if( $result != 1) { 
                    $inventory->save();  
                }

                $stockin = new StockIn();
                $stockin->supplier_id = Yii::$app->request->post('Inventory')['supplier_id'][$key];
                $stockin->product_id = $value;
                $stockin->quantity = Yii::$app->request->post('Inventory')['quantity'][$key];
                $stockin->cost_price =Yii::$app->request->post('Inventory')['cost_price'][$key];
                $stockin->selling_price = Yii::$app->request->post('Inventory')['selling_price'][$key];
                $stockin->date_imported = Yii::$app->request->post('Inventory')['date_imported'];
                $stockin->time_imported = date("H:i:s");
                $stockin->created_at = Yii::$app->request->post('Inventory')['created_at'];
                $stockin->created_by = Yii::$app->request->post('Inventory')['created_by'];

                if( $result != 1) { 
                    $stockin->save();  
                }
                    
            }

            $getProductInInventory = $searchModel->getProductInInventory();

            return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getProductInInventory' => $getProductInInventory,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully added in the database.'
                        ]);        

        } else {
                
                $getProductList = $searchProductModel->getProducts();

            return $this->render('create', [
                                'model' => $model, 
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => '', 
                                'getProductList' => $getProductList 
                            ]);
        }

    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteColumn($id,$product_id,$date_imported)
    {
        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        Yii::$app->db->createCommand()
            ->delete('stock_in', ['product_id' => $product_id, 'date_imported' => $date_imported])
            ->execute();

        $getProductInInventory = $searchModel->getProductInInventory();

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getProductInInventory' => $getProductInInventory, 
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully deleted in the database.'
                        ]);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $searchModel = new SearchInventory();
        $result = $searchModel->getProductInInventory();

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
             ->setCellValue('B1', 'Supplier Code')
             ->setCellValue('C1', 'Supplier Name')
             ->setCellValue('D1', 'Product Code')
             ->setCellValue('E1', 'Product Name')
             ->setCellValue('F1', 'Quantity')
             ->setCellValue('G1', 'Cost Price')
             ->setCellValue('H1', 'Selling Price');

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['supplier_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['supplier_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['product_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['cost_price']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$result_row['selling_price']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "PartsInventory-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $searchModel = new SearchInventory();
        $result = $searchModel->getProductInInventory();

        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('PartsInventory-' . date('m-d-Y'));
    }

    public function actionInsertInInventory() 
    {
        $detail = new Inventory();
        $this->layout = false;

        $n = Yii::$app->request->post('n');
        $inventorySupplierId = Yii::$app->request->post('inventorySupplier');
        $inventoryProductId = Yii::$app->request->post('inventoryProduct');
        $inventoryQty = Yii::$app->request->post('inventoryQty');
        $inventoryCost = Yii::$app->request->post('inventoryCost');
        $inventorySelling = Yii::$app->request->post('inventorySelling');

        $getProductName = Product::find()->where(['id' => $inventoryProductId])->one();
        $inventoryProductName = $getProductName->product_name;

        $getSupplierName = Supplier::find()->where(['id' => $inventorySupplierId])->one();
        $inventorySupplierName = $getSupplierName->supplier_name;

        return $this->render('product-lists',[
                                        'n' => $n,
                                        'inventorySupplier' => $inventorySupplierId,
                                        'inventorySupplierName' => $inventorySupplierName,
                                        'inventoryProduct' => $inventoryProductId,
                                        'inventoryProductName' => $inventoryProductName,
                                        'inventoryQty' => $inventoryQty,
                                        'inventoryCost' => $inventoryCost,
                                        'inventorySelling' => $inventorySelling,
                                        'detail' => $detail
                                    ]);
    }


}
