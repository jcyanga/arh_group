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

use common\models\StockIn;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class StocksController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Stocks'])->andWhere(['role_id' => $uRId ] )->all();
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
     * Lists all Category models.
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

    public function actionCreate() {

        $updateQty = Yii::$app->request->post('updateQty');

        if( !empty($updateQty) ) {
            foreach($updateQty as $key => $value) {
                 $result = explode('|', $value);

                 $array = array('itemId' => $result[0], 'itemName' => $result[1], 'itemQty' => $result[2], 'ProductId' => $result[3], 'SupplierId' => $result[4], 'costPrice' => $result[5], 'sellingPrice' => $result[6]);
                 
                 $data[] = $array;    
            }

            return $this->render('update', ['data' => $data]);

        }else {

                $model = new Inventory();

                $searchModel = new SearchInventory();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getProductInInventory = $model->getProductInInventory();

                return $this->render('index', ['model' => $model, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getProductInInventory' => $getProductInInventory, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error, No record selected.'
                ]);


        }

    }

    public function actionUpdate() {

        $inventoryId = Yii::$app->request->post('inventoryId');
        $qtyStock = Yii::$app->request->post('qtyStock');
        $ProductId = Yii::$app->request->post('ProductId');
        $SupplierId = Yii::$app->request->post('SupplierId');
        $costPrice = Yii::$app->request->post('costPrice');  
        $sellingPrice = Yii::$app->request->post('sellingPrice');  

        foreach( $qtyStock as $key => $value ) {

            Yii::$app->db->createCommand()
                ->update('inventory', ['quantity' => $qtyStock[$key] ], "id = $inventoryId[$key]" )
                ->execute();
            
            $stockin = new StockIn();
            $stockin->product_id = $ProductId[$key];
            $stockin->supplier_id = $SupplierId[$key];
            $stockin->quantity = $qtyStock[$key];
            $stockin->cost_price = $costPrice[$key];
            $stockin->selling_price = $sellingPrice[$key];
            $stockin->date_imported = date('Y-m-d');
            $stockin->time_imported = date('H:i:s');
            $stockin->created_at = date("Y-m-d");
            $stockin->created_by = Yii::$app->user->identity->id;
            
            $stockin->save();
        }

        $model = new Inventory();

        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getProductInInventory = $model->getProductInInventory();

        return $this->render('index', ['model' => $model, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getProductInInventory' => $getProductInInventory, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    
    }

}    