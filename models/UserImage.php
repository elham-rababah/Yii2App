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

    public static function findImagesByUserID($userId)
    {   
        //echo "$userId ";die;
        $dataProvider = new ActiveDataProvider([
            'query' => self::find()->where([
                'userId' => $userId
            ]),
            'pagination' => [
            'pageSize' => 5,
            ],
            ]);

        //print_r($dataProvider);die;
        return $dataProvider;

    }
}
