<?php

namespace backend\controllers;

use Yii;
use backend\models\Item;
use backend\models\ItemCategory;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Item();
        $model2 = new ItemCategory();
        $category = $model2->listItemCategory();

        if ($model->load(Yii::$app->request->post())) {
            $gambar = UploadedFile::getInstance($model, 'gambar');
            $gambar->saveAs(Yii::getAlias('@backend/upload/').$model->name."-".$model->price.".".$gambar->extension);
            $model->save(false);
            return $this->redirect(['view','id' => $model->id ]);
        }else{
            return $this->render('update',['model' => $model, 'category' => $category]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model2 = new ItemCategory();
        $category = $model2->listItemCategory();

        if ($model->load(Yii::$app->request->post())) {
            $gambar = UploadedFile::getInstance($model, 'gambar');
            $gambar->saveAs(Yii::getAlias('@backend/upload/').$model->name."-".$model->price.".".$gambar->extension);
            $model->save(false);
            return $this->redirect(['view','id' => $model->id ]);
        }else{
            return $this->render('update',['model' => $model, 'category' => $category]);
        }
    }

    /**
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
