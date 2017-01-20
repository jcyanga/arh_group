<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\LoginForm;

use common\models\SearchInventory;
use common\models\ProductLevel;
use common\models\SearchService;
use common\models\SearchCustomer;

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
        $inventoryModel = new SearchInventory();
        $serviceModel = new SearchService();
        $customerModel = new SearchCustomer();
        
        // customer list
        if( Yii::$app->request->post()) {
            $getCustomerQuotationBySearch = $customerModel->getCustomerQuotationBySearch(Yii::$app->request->post('customerSearchkeyword'));
            $getCustomerInvoiceBySearch = $customerModel->getCustomerInvoiceBySearch(Yii::$app->request->post('customerSearchkeyword'));
            $keywordValue = Yii::$app->request->post('customerSearchkeyword');

        }else{
            $getCustomerQuotationBySearch = '';
            $getCustomerInvoiceBySearch = '';
            $keywordValue = '';

        }

        // pending services dashboard
        $pendingQuotationServices = $serviceModel->getPendingServices();
        $pendingInvoiceServices = $serviceModel->getPendingInvoiceServices();

        // products dashboard
        $getZeroStock = $inventoryModel->getZeroStock();
        $getTotalZeroStock = count($inventoryModel->getTotalZeroStock());

        $getPartLevel = ProductLevel::find()->one();
        $criticalLevel = $getPartLevel->critical_level;
        $minimumLevel = $getPartLevel->minimum_level;

        $getCriticalStock = $inventoryModel->getCriticalStock($criticalLevel);
        $getTotalCriticalStock = count($inventoryModel->getTotalCriticalStock($criticalLevel));
        $getWarningStock = $inventoryModel->getWarningStock($minimumLevel);
        $getTotalWarningStock = count($inventoryModel->getTotalWarningStock($minimumLevel));

        return $this->render('index', [
                        'getZeroStock' => $getZeroStock, 
                        'getTotalZeroStock' => $getTotalZeroStock,
                        'getCriticalStock' => $getCriticalStock, 
                        'getTotalCriticalStock' => $getTotalCriticalStock,
                        'getWarningStock' => $getWarningStock, 
                        'getTotalWarningStock' => $getTotalWarningStock,
                        'pendingQuotationServices' => $pendingQuotationServices, 
                        'pendingInvoiceServices' => $pendingInvoiceServices,
                        'getCustomerQuotationBySearch' => $getCustomerQuotationBySearch,
                        'getCustomerInvoiceBySearch' => $getCustomerInvoiceBySearch,
                        'keywordValue' => $keywordValue,
                    ]);
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
