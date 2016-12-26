<?php

namespace backend\controllers;

use Yii;
use common\models\Modules;
use common\models\SearchModules;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModulesController implements the CRUD actions for Modules model.
 */
class ModulesController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all Modules models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchModules();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Modules model.
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
     * Creates a new Modules model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modules();

        if ($model->load(Yii::$app->request->post())) {

            $modules = Yii::$app->request->post('Modules') ['modules'];

            $result = $model->getModules($modules);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change the modules.']);
            }

            if($model->save()) {
                $searchModel = new SearchModules();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Modules model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchModules();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing Modules model.
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
        $searchModel = new SearchModules();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();
        return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }
    
    /**
     * Finds the Modules model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Modules the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modules::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
