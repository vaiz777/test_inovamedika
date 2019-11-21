<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pesanan_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $item_id
 *
 * @property Pesanan $order
 * @property Item $item
 */
class PesananItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pesanan_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id'], 'required'],
            [['order_id', 'item_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pesanan::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'item_id' => 'Item ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    public function daftarPesananItem()
    {
        $query = new \yii\db\Query();
        return $query->select("oi.order_id, i.name")
                     ->from("pesanan_item oi, item i")
                     ->where("i.id=oi.item_id")
                     ->all();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getOrder()
    {
        return $this->hasOne(Pesanan::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
