<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\SearchProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Modules'])->andWhere(['role_id' => $uRId ] )->all();
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
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     // 'only' => ['index', 'create', 'update', 'view', 'delete'],
            //     'rules' => [
                    
            //         [
            //             'actions' => $action['developer'],
            //             'allow' => $allow['developer'],
            //             'roles' => ['developer'],
            //         ],

            //         [
            //             'actions' => $action['admin'],
            //             'allow' => $allow['admin'],
            //             'roles' => ['admin'],
            //         ],

            //         [
            //             'actions' => $action['staff'],
            //             'allow' => $allow['staff'],
            //             'roles' => ['staff'],
            //         ],

            //         [
            //             'actions' => $action['customer'],
            //             'allow' => $allow['customer'],
            //             'roles' => ['customer'],
            //         ]
       
            //     ],
            // ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);
        
        if( isset(Yii::$app->request->get('SearchProduct')['category_id'] ) || isset(Yii::$app->request->get('SearchProduct')['product_code'] )  || isset(Yii::$app->request->get('SearchProduct')['product_name'] ) ) {

                $category_id = Yii::$app->request->get('SearchProduct')['category_id'];
                $product_code = Yii::$app->request->get('SearchProduct')['product_code'];
                $product_name = Yii::$app->request->get('SearchProduct')['product_name'];

                $getProduct = $searchModel->searchProduct($category_id,$product_code,$product_name);

        }elseif ( Yii::$app->request->get('SearchProduct')['category_id'] == "" || Yii::$app->request->get('SearchProduct')['product_code'] == "" || Yii::$app->request->get('SearchProduct')['product_name'] == "" ) {
                
                $getResult = new Product();
                $getProduct = $getResult->getProduct();
        }else {

                $getResult = new Product();
                $getProduct = $getResult->getProduct();
        }

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getProduct' => $getProduct, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Product();
        $getProducts = $model->getProductById($id);

        return $this->render('view', [
            'model' => $getProducts,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        // echo $product_code = Yii::$app->request->post('Product') ['unit_of_measure'];

        if ($model->load(Yii::$app->request->post())) {

            $product_code = Yii::$app->request->post('Product') ['product_code'];
            $product_name = Yii::$app->request->post('Product') ['product_name'];

            $result = $model->getProductCodeAndProductName($product_code, $product_name);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change product code or product name.']);
            }
            
            if( !empty(UploadedFile::getInstances($model, 'product_image')[0]->name) ) {
                $model->product_image = UploadedFile::getInstances($model, 'product_image')[0]->name;
                $tempName = UploadedFile::getInstances($model, 'product_image')[0]->tempName;

            }

            if($model->save()) {
                
                if( !empty(UploadedFile::getInstances($model, 'product_image')[0]->name) ) {

                move_uploaded_file($tempName, Yii::$app->basePath . '/web/assets/products/' . $model->product_image);
                // $model->product_image->saveAs(Yii::$app->basePath . '/web/assets/products/' . $model->product_image);
                }

                $searchModel = new SearchProduct();
                $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);

                $getResult = new Product();
                $getProduct = $getResult->getProduct();

                return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'getProduct' => $getProduct, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {
          
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( $model->load(Yii::$app->request->post()) ) {
            // return $this->redirect(['view', 'id' => $model->id]);
            
            if( !empty(UploadedFile::getInstances($model, 'product_image')[0]->name) ) {
                $model->product_image = UploadedFile::getInstances($model, 'product_image')[0]->name;
                $tempName = UploadedFile::getInstances($model, 'product_image')[0]->tempName;
                
                if($model->save()) {
                
                    move_uploaded_file($tempName, Yii::$app->basePath . '/web/assets/products/' . $model->product_image);

                    $searchModel = new SearchProduct();
                    $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);

                    $getResult = new Product();
                    $getProduct = $getResult->getProduct();
                
                    return $this->render('index', ['searchModel' => $searchModel,
                        'dataProvider' => $dataProvider, 'getProduct' => $getProduct, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
                }   

            }else{
                $model->product_image = Yii::$app->request->post('before_productImg');

                if($model->save()) {
                    
                    $searchModel = new SearchProduct();
                    $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);

                    $getResult = new Product();
                    $getProduct = $getResult->getProduct();;
                
                    return $this->render('index', ['searchModel' => $searchModel,
                        'dataProvider' => $dataProvider, 'getProduct' => $getProduct, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
                }

            }
            

        } else {

            $product_model = new Product();
            $getProducts = $product_model->getProductById($id);

            return $this->render('update', ['model' => $model, 'getProducts' => $getProducts, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        
        }
    }

    /**
     * Deletes an existing Product model.
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
        // $this->findModel($id)->delete();
        // $model = $this->findModel($id);
        // $model->deleted = 1;
        // if ( $model->save() ) {
        //     Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        // } else {
        //     Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
        // }

        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);

        $getResult = new Product();
        $getProduct = $getResult->getProduct();;

        $this->findModel($id)->delete();
        return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'getProduct' => $getProduct, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        $getResult = new Product();
        $result = $getResult->getProduct();

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
             ->setCellValue('B1', 'Parts-Category')
             ->setCellValue('C1', 'Product Code')
             ->setCellValue('D1', 'Product Name')
             ->setCellValue('E1', 'Unit of Measure');

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['product_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['unit_of_measure']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "PartsList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() {

        $getResult = new Product();
        $result = $getResult->getProduct();

        $content = $this->renderPartial('_pdf', ['result' => $result]);
        // instantiate and use the dompdf class
        // $dompdf = new Dompdf();

        $dompdf     = new Dompdf();
        //return $pdf->stream();

        $dompdf->loadHtml($content);

        // // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('PartsList-' . date('m-d-Y'));
          

    }


}
