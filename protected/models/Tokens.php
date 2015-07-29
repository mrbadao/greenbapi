<?php

/**
 * This is the model class for table "tokens".
 *
 * The followings are the available columns in table 'tokens':
 *
 * @property string $uid
 * @property string $token
 * @property string $last_access_ip
 * @property string $expired
 * @property string $last_access
 * @property string $created
 */
class Tokens extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Tokens the static model class
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
        return 'tokens';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, token, expired', 'required'),
            array('uid', 'length', 'max' => 10),
            array('token', 'length', 'max' => 40),
            array('last_access_ip', 'length', 'max' => 64),
            array('last_access, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('uid, token, last_access_ip, expired, last_access, created', 'safe', 'on' => 'search'),
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
            'uid' => 'Uid',
            'token' => 'Token',
            'last_access_ip' => 'Last Access Ip',
            'expired' => 'Expired',
            'last_access' => 'Last Access',
            'created' => 'Created',
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

        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('last_access_ip', $this->last_access_ip, true);
        $criteria->compare('expired', $this->expired, true);
        $criteria->compare('last_access', $this->last_access, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getNewToken($uid, $lastAccessIP)
    {
        Tokens::model()->deleteAllByAttributes(array(
            "uid" => $uid,
            "last_access_ip" => $lastAccessIP,
        ));

        $token = new Tokens();
        $tokenSerial = md5(self::randomString(32));

        $token->setAttributes(array(
            "uid" => $uid,
            "token" => $tokenSerial,
            "last_access_ip" => $lastAccessIP,
            "created" => date("Y-m-d H:m:s"),
            "last_access" => date("Y-m-d H:m:s"),
        ));

        $token->expired = date("Y-m-d H:m:s", strtotime($token->last_access) + Yii::app()->params['duration']);

        if ($token->save())
            return $tokenSerial;
        return null;
    }

    protected static function randomString($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";

        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    public static function checkToken($uid, $token, $renew = true)
    {
        $_token = Tokens::model()->findByAttributes(array(
            "uid" => $uid,
            "token" => $token,
        ));

        if (!$_token) return false;

        if ($_token->expired < date("Y-m-d H:m:s")) {
            if (!$renew) {
                $_token->delete();
                return false;
            }
            $_token->renewToken();
            $_token->signAccess();
            $_token->save();
            if ($_token->save())
                return true;
            return false;
        }

        return true;
    }

    public function signAccess()
    {
        $this->last_access = date("Y-m-d H:m:s");
    }

    public function renewToken()
    {
        $this->expired = date("Y-m-d H:m:s", strtotime(date("Y-m-d H:m:s")) + Yii::app()->params['duration']);
    }
}