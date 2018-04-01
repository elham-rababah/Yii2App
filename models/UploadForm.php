<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;


class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('./uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension, false);
            return true;
        } else {
            return false;
        }
    }
}