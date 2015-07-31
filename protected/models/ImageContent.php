<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 *
 * @property string $id
 * @property string $title
 * @property string $filename
 * @property string $path
 * @property string $mime_type
 * @property integer $display_mode
 * @property string $signature
 * @property string $album_id
 * @property string $created
 * @property string $modified
 */
class ImageContent extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return ImageContent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_printer;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'image';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, filename, path, signature, album_id', 'required'),
//			array('signature', 'unique'),
            array('display_mode', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('filename, path', 'length', 'max' => 128),
            array('mime_type', 'length', 'max' => 40),
            array('signature', 'length', 'max' => 255),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, filename, path, mime_type, display_mode, signature, created, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'filename' => 'Filename',
            'path' => 'Path',
            'mime_type' => 'Mime Type',
            'display_mode' => 'Display Mode',
            'signature' => 'Signature',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('mime_type', $this->mime_type, true);
        $criteria->compare('display_mode', $this->display_mode);
        $criteria->compare('signature', $this->signature, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $now = date("Y-m-d H:m:s");
        if ($this->isNewRecord) {
            $this->created = $now;
        }
        $this->modified = $now;

        if (!isset($this->album_id) || !is_numeric($this->album_id)) return false;

        $dependency = new CDbCacheDependency();
        $album = Album::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findByPk($this->album_id);
        if (!$album) return false;
        $this->display_mode = $album->display_mode;
        return true;
    }
}