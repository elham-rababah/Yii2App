<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class UserImage  extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    public static function findImagesByUserID($userId = null)
    {   
        if(!$userId){
            $whereArr = [];
        } else {
            $whereArr = ['userId' => $userId];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => self::find()->where($whereArr),
            'pagination' => [
            'pageSize' => 3,
            ],
            ]);

        //print_r($dataProvider);die;
        return $dataProvider;

    }
}
