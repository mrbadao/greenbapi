<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AdminLogin extends CModel
{
	public $email;
	public $password;

	private $_identity;

	function __construct($params) {
		foreach($params as $attr => $val){
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
			array('email, password', 'required'),
			array('email','email'),
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
			'email'=>'Admin Email',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate()
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new MasterIdentity($this->email,$this->password);
            $authResult = $this->_identity->authenticate();
			if($authResult) return array(
                "uid" => $authResult,
                "token" => Tokens::getNewToken($authResult, Yii::app()->request->getUserHostAddress())
            );
			else $this->addError("email", "Authorized faild.");
		}
		return array("AuthError" => $this->getErrors());
	}



	public function attributeNames()
	{
		// TODO: Implement attributeNames() method.
	}
}
