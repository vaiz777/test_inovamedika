<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $category_id
 *
 * @property ItemCategory $category
 * @property PesananItem[] $pesananItems
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['price', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ItemCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPesananItems()
    {
        return $this->hasMany(PesananItem::className(), ['item_id' => 'id']);
    }
}
