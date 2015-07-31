<?php

class AuthenticationController extends Controller
{
    const AUTHORIZTION_ADMIN_LOGIN_KEY = "Admin-Login";
    const AUTHORIZTION_CASHIER_LOGIN_KEY = "Cashier-Login";

    /**
     * This is the default 'Authenticate' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAuthenticate()
    {
        $postData = $this->getJsonData();

        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if (!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $authModel = null;
        $resultData = null;
        switch ($this->getHttpRequestHeaderAuthorization()) {
            case self::AUTHORIZTION_ADMIN_LOGIN_KEY:
                $authModel = new AdminLogin($postData['data']);
                $authModel->validate();
                $authToken = $authModel->authenticate();
                if (is_array($authToken) && isset($authToken['token']) && $authToken['token'])
                    $this->render(array("success" => true, "data" => $authToken));
                else  $this->render(array("success" => false, "data" => $authToken));
                break;

            case self::AUTHORIZTION_CASHIER_LOGIN_KEY:
                $authModel = new CashierLogin($postData['data']);
                $authModel->validate();
                $authData = $authModel->authenticate();
                if (is_array($authData) && isset($authData['id']) && $authData['id'])
                    $this->render(array("success" => true, "data" => $authData));
                else {
                    $this->render(array(
                        "success" => false,
                        "error" => array(
                            "code" => 1001,
                            "errorCode" => 0,
                            "message" => $this->getStatusCodeMessage(1001),
                            "content" => $authData,
                        )
                    ));
                }
                break;

            default:
                throw new CHttpException(400, $this->getStatusCodeMessage(400));
        }
    }

    /**
     * This is the action ValidateToken
     */
    public function actionValidateToken()
    {
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("uid", "token", "role"));

        if ($this->getHttpRequestHeaderAuthorization() !== self::AUTHORIZTION_ADMIN_LOGIN_KEY) throw new CHttpException(400, $this->getStatusCodeMessage(400));

        switch ($postData["role"]) {
            case "Administrators":
                if (Tokens::checkToken($postData["uid"], $postData["token"])) {
                    $this->render(array(
                        "success" => true,
                        "data" => array(
                            "token" => Tokens::model()->findByAttributes(array("token" => $postData["token"]))->attributes,
                        )
                    ));
                } else throw new CHttpException(1000, $this->getStatusCodeMessage(1000));
                break;

            default:
                throw new CHttpException(400, $this->getStatusCodeMessage(400));
                break;
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        Yii::log($error['message'], 'error', 'application');
        $this->render(array(
            "success" => false,
            "error" => array(
                "code" => $error['code'],
                "errorCode" => $error['errorCode'],
                "message" => $error['message'],
            )
        ));
    }


}