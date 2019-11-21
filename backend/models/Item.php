<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $category_id
 * @property string $gambar
 *
 * @property ItemCategory $category
 * @property PesananItem[] $pesananItems
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $gambar;
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
            [['gambar'], 'file', 'extensions' => 'jpg, png, jpeg', 'maxSize' => 200000],
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
            'gambar' => 'Gambar',
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
