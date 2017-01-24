<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\LoginForm;

use common\models\Inventory;
use common\models\ProductLevel;
use common\models\SearchService;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Inventory();
        $getPartLevel = new ProductLevel();
        $searchPendingService = new SearchService();

        $getPartLevel = ProductLevel::find()->one();
        $criticalLevel = $getPartLevel->critical_level;
        $minimumLevel = $getPartLevel->minimum_level;
        
        $getZeroStock = $model->getZeroStock();
        $getCriticalStock = $model->getCriticalStock($criticalLevel);
        $getWarningStock = $model->getWarningStock($minimumLevel);

        $pendingServices = $searchPendingService->getPendingServices();
        $pendingInvoiceServices = $searchPendingService->getPendingInvoiceServices();

        return $this->render('index', ['getZeroStock' => $getZeroStock, 'getCriticalStock' => $getCriticalStock, 'getWarningStock' => $getWarningStock, 'pendingServices' => $pendingServices, 'pendingInvoiceServices' => $pendingInvoiceServices ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout=false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
