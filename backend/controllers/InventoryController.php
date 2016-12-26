<?php

namespace backend\controllers;

use Yii;
use common\models\Inventory;
use common\models\SearchInventory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

        $getProductInInventory = $model->getProductInInventory();

        return $this->render('index', ['model' => $model, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getProductInInventory' => $getProductInInventory, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        
       Yii::$app->response->format = Response::FORMAT_JSON;
       
       $supplier_id = Yii::$app->request->post('supplier_id');
       $product_id = Yii::$app->request->post('product_id');
       $quantity = Yii::$app->request->post('quantity');
       $cost_price = Yii::$app->request->post('cost_price');
       $selling_price = Yii::$app->request->post('selling_price');

       $getItem = $model->selectSupplierNameandProductName($supplier_id,$product_id);

       if( $getItem == 1 ) {
            return ['message' => 'warning' , 'content' => 'You already enter an existing product, Please! Change supplier or product.'];
       }

       $model->supplier_id = $supplier_id;
       $model->product_id = $product_id;
       $model->quantity = $quantity;
       $model->cost_price = $cost_price;
       $model->selling_price = $selling_price;
       $model->status = 1;
       $model->created_at = date('Y-m-d');
       $model->date_imported = date('Y-m-d');
       $model->created_by = Yii::$app->user->identity->id;

       if( $model->save() ) {
            return ['message' => 'success' , 'content' => 'Your record was successfully added in the database.'];
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
        // $model = $this->findModel($id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['message' => 'success' , 'content' => 'Your record was selected in the database.'];
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // } else {
        //     return $this->render('update', [
        //         'model' => $model,
        //     ]);
        // }
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
}
