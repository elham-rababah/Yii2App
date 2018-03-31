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
    

    /**
     * Find Images Based on UserID
     */
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
        return $dataProvider;

    }

    /**
     * update image status 
     */
    public static function updateImagesStatus($imageId,$status)
    {
        $image = self::findOne($imageId);
        $image->status = $status;
        //echo $image->update();die;
        return $image->update();
    }
}
