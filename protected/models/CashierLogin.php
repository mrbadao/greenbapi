<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class CashierLogin extends CModel
{
    public $loginid;
    public $password;

    private $_identity;

    function __construct($params)
    {
        foreach ($params as $attr => $val) {
            $this->{$attr} = $val;
        }
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // email and password are required
            array('loginid, password', 'required'),
            array('password', 'length', 'min' => 6, 'max' => 32),
            // password needs to be authenticated
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'loginid' => 'Login id',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate()
    {
        if (!$this->hasErrors()) {
            $this->_identity = new CashierIdentity($this->loginid, $this->password);
            $authResult = $this->_identity->authenticate();
            if ($authResult) return $authResult;
            else $this->addError("loginid", "Authorized faild.");
        }
        return $this->getErrors();
    }


    public function attributeNames()
    {
        // TODO: Implement attributeNames() method.
    }
}
