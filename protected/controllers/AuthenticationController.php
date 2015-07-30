<?php

class AuthenticationController extends Controller
{
    const AUTHORIZTION_ADMIN_LOGIN_KEY = "Admin-Login";

    /**
     * This is the default 'Authenticate' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAuthenticate()
    {
        $postData = $this->getJsonData();

        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if(!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $authModel = null;
        $resultData =null;
        switch ($this->getHttpRequestHeaderAuthorization()) {
            case self::AUTHORIZTION_ADMIN_LOGIN_KEY:
                $authModel = new AdminLogin($postData['data']);
                $authModel->validate();
                $this->render(array("success" => true, "data" => $authModel->authenticate()));
                break;

            default:
                throw new CHttpException(400, $this->getStatusCodeMessage(400));
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