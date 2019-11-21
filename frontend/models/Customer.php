<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property int $user_id
 *
 * @property User $user
 * @property Pesanan[] $pesanans
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'email', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], 'unique'],
            [['nama', 'email'], 'string', 'max' => 50],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'email' => 'Email',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPesanans()
    {
        return $this->hasMany(Pesanan::className(), ['customer_id' => 'id']);
    }
}
