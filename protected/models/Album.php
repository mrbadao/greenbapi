<?php

/**
 * This is the model class for table "albums".
 *
 * The followings are the available columns in table 'albums':
 * @property string $id
 * @property string $is_use_third_party
 * @property string $thrird_party_id
 * @property string $name
 * @property string $description
 * @property integer $display_mode
 * @property string $created
 * @property string $modified
 */
class Album extends CActiveRecord
{
    const THRIRD_PARTY_IMGUR = "imgur";

    const DISPLAY_MODE_PUBLIC = 1;
    const DISPLAY_MODE_PRIVATE = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Albums the static model class
	 */
	public static function model($className=__CLASS__)
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
		return 'album';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, display_mode', 'required'),
//			array('name', 'unique'),
			array('display_mode', 'numerical', 'integerOnly'=>true),
			array('is_use_third_party', 'length', 'max'=>20),
			array('thrird_party_id, name', 'length', 'max'=>50),
			array('description, created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, is_use_third_party, thrird_party_id, name, description, display_mode, created, modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'is_use_third_party' => 'Is Use Third Party',
			'thrird_party_id' => 'Thrird Party',
			'name' => 'Name',
			'description' => 'Description',
			'display_mode' => 'Display Mode',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('is_use_third_party',$this->is_use_third_party,true);
		$criteria->compare('thrird_party_id',$this->thrird_party_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('display_mode',$this->display_mode);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        $now = date("Y-m-d H:m:s");
        if($this->isNewRecord){
            $this->created = $now;
        }
        $this->modified = $now;

        if(!$this->is_use_third_party) return true;

        switch($this->is_use_third_party){
            case self::THRIRD_PARTY_IMGUR:
                $imgUrUploader = Yii::app()->imgUrUploader;

                $pVars = array(
                    "title" => $this->name,
                    "description" => $this->description ? $this->description :$this->name,
                    "privacy" => "hidden"
                );

                $imgurAlbum = $imgUrUploader->createAlbum($pVars);

                if($imgurAlbum && $imgurAlbum->_id){
                    $this->thrird_party_id = $imgurAlbum->_id;
                    return true;
                }
                else{
                    $this->addError("is_use_third_party","The service down.");
                    return false;
                }

                break;

            default:
                $this->addError("is_use_third_party","The service isn't supported.");
                return false;
        }
    }
}