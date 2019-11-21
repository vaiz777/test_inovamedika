<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pesanan".
 *
 * @property int $id
 * @property string $date
 * @property int $customer_id
 *
 * @property Customer $customer
 * @property PesananItem[] $pesananItems
 */
class Pesanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pesanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'customer_id'], 'required'],
            [['id', 'customer_id'], 'integer'],
            [['date'], 'safe'],
            [['id'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPesananItems()
    {
        return $this->hasMany(PesananItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function daftarPesananCustomer()
    {
        $query = new \yii\db\Query();
        return $query->select("o.id, c.nama")
                    ->from("customer c, pesanan o")
                    ->where("o.customer_id=c.id")
                    ->all();      
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(),['id' => 'item_id'])->viaTable('pesana_item',['pesanan_id' => 'id']);
    }

}
