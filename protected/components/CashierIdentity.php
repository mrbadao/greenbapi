<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CashierIdentity extends CUserIdentity
{
    const CASHIER_STATUS_ACTIVE = 1;
    const CASHIER_STATUS_DEACTIVE = 0;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = Cashier::model()->findByAttributes(array(
            'loginid' => $this->username,
            'password' => Cashier::hashPassword($this->password),
            'status' => self::CASHIER_STATUS_ACTIVE
        ));
        if ($user) {
            $this->errorCode = self::ERROR_NONE;
        } else $this->errorCode = self::ERROR_USERNAME_INVALID;
        return !$this->errorCode ? $user->attributes : false;
    }
}