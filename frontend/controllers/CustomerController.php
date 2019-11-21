<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Customer;
use frontend\models\CustomerSearch;
use frontend\models\Pesanan;
use frontend\models\PesananItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;


/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new CustomerSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $userdata = count(Customer::find()->where(['user_id' => Yii::$app->user->identify->id])->one());
        $query = Customer::find()->where(['user_id' => Yii::$app->user->identify->id]);

        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,

            'userData'      =>$userdata,
            'dataProvider'  =>$dataProvider,
        ]);
    }

    public function actionShowOrder()
    {
        $model1 = new Pesanan();
        $model2 = new PesananItem();
        $models1 = $model1->daftarPesananCustomer();
        $models2 = $model2->daftarPesananItem();
            return $this->render('show-order',[
                'models1' => $models1,
                'models2' => $models2
            ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->isGuest){
            $customer = false;
        }else{
            $customer = Customer::findOne(['user_id' => Yii::$app->user->identify->id]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'customer' => $customer,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /*public function actionCreate()
    {
        $model = new Customer();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    */

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */
    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddToCart($id)
    {
        $count = 0;
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('totalcart')) {
           $count = $cookies->getValue('totalcart');
           $count++;

           $cookies = Yii::$app->response->cookies;
           $cookies-add(new Cookie([
            'name' => 'totalcart',
            'value' => $count,
           ]));

        }else{
            $cookies = Yii::$app->response->cookies;
            $cookies-add(new Cookie([
            'name' => 'totalcart',
            'value' => 0,
           ]));            
        }

        $cookies = Yii::$app->response->cookies;
        if (!$cookies->has('username')) {
           $cookies->add(new Cookie([
                'name'  => 'username',
                'value' => Yii::$app->user->identify->username,
           ]));
        }

        $cookies->add(new Cookie([
            'name'  => 'cart'.$count,
            'value' =>  $id,

        ]));
        return $this->redirect('index');
    }
}
