<?php

/**
 * This is the model class for table "cashier".
 *
 * The followings are the available columns in table 'cashier':
 *
 * @property string $id
 * @property string $loginid
 * @property string $password
 * @property string $display_name
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $created
 * @property string $modified
 * @property integer $status
 */
class Cashier extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Ca the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cashier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('loginid, password, display_name, phone', 'required'),
            array('loginid, display_name, phone', 'unique', 'on' => 'createScenario'),
            array('status', 'numerical', 'integerOnly' => true),
            array('loginid', 'length', 'max' => 60),
            array('password', 'length', 'max' => 64),
            array('display_name', 'length', 'max' => 250),
            array('phone', 'length', 'max' => 50),
            array('address, email', 'length', 'max' => 100),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, loginid, password, display_name, phone, address, email, created, modified, status', 'safe', 'on' => 'search'),
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
            'loginid' => 'Loginid',
            'password' => 'Password',
            'display_name' => 'Display Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'email' => 'Email',
            'created' => 'Created',
            'modified' => 'Modified',
            'status' => 'Status',
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
        $criteria->compare('loginid', $this->loginid, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('display_name', $this->display_name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('modified', $this->modified, true);
        $criteria->compare('status', $this->status);

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

        if (!self::isValidMd5($this->password)) $this->password = self::hashPassword($this->password);

        return true;
    }

    function isValidMd5($pwd)
    {
        return !empty($pwd) && preg_match('/^[a-f0-9]{32}$/', $pwd);
    }

    public static function hashPassword($pwd)
    {
        return md5($pwd);
    }
}