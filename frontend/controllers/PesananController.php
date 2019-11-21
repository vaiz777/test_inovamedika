<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Pesanan;
use frontend\models\PesananSearch;

use frontend\models\Item;
use frontend\models\PesananItem;
use frontend\models\ItemSearch;
use frontend\models\Customer;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use yii\web\Cookie;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PesananController implements the CRUD actions for Pesanan model.
 */
class PesananController extends Controller
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
     * Lists all Pesanan models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*
        $searchModel = new PesananSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        */

        $cartlist = $this->getCartList();

        $orderlist = Item::find()->where(['id' => $cartlist]);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderlist

        ]);

        return $this->render('index', [
            /*
            'searchModel' => $searchModel,
            */
            'dataProvider' => $dataProvider,
            

        ]);
    }

    /**
     * Displays a single Pesanan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pesanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCheckOut()
    {
        $cartlist = $this->getCartList;

        $transaction = Pesanan::getDb()->beginTransaction();
        try {
            $customer = Customer::findOne([
                'user_id' => Yii::$app->user->identify->id,

            ]);

            $pesanan = new Pesanan();
            $order->customer_id = $customer->id;
            $order->save();

            $orderId = Order::find([
                'customer_id' => $customer->id

            ])->orderBy('id DESC ')->one();

            for ($i=0; $i < sizeof($cartlist); $i++) { 
                $pesananItems = new PesananItem();
                $pesananItems->order_id = $orderId->id;
                $orderItems->item_id = $cartlist[$i];

            }

            $transaction->commit();
            $this->removeCartList();


        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }

        return $this->render('checkout');

    }

    public function actionClear()
    {
        $this->removeCartList();
        $this->redirect(['order/index']);
    }

    public function getCartList()
    {
        $count = 0;
        $cartlist = [];

        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('totalcart')) {
           $count = $cookies->getValue('totalcart');
           for ($i=0; $i <= $count ; $i++) { 
                    array_push($cartlist, $cookies->getValue('totalcart'));
           }
        }
        return $cartlist;
    }

    public function removeCartList()
    {
       $cookies =Yii::$app->request->cookies;
       if ($cookies->has('totalcart')) {
           $count = $cookies->getValue('totalcart');
           $cookies = Yii::$app->request->cookies;
           for ($i=0; $i < $count ; $i++) { 
               $cookies->remove('cart'.$i);
           }
           $cookies->remove('totalcart');
       }
    }

    public function actionCreate()
    {
        $model = new Pesanan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pesanan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pesanan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pesanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pesanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pesanan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
