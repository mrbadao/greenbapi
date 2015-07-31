<?php

class CashierController extends Controller
{
    const AUTHORIZTION_KEY = "Cashier";

    /**
     * This is the default 'Authenticate' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionCreate()
    {
        $this->validateAuthorizationToken(self::AUTHORIZTION_KEY);
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("cashier"));

        $cashier = new Cashier();
        $cashier->attributes = $postData["cashier"];
        $cashier->scenario = 'createScenario';
        if ($cashier->save()) {
            $this->render(array(
                "success" => true,
                "data" => array(
                    "cashier" => $cashier->attributes,
                )
            ));
        } else {
            $this->render(array(
                "success" => false,
                "error" => array(
                    "code" => 1001,
                    "errorCode" => 0,
                    "message" => $this->getStatusCodeMessage(1001),
                    "content" => $cashier->getErrors(),
                )
            ));
        }
    }

    /**
     * This is the action ValidateToken
     */
    public function actionEdit()
    {
        $this->validateAuthorizationToken(self::AUTHORIZTION_KEY);
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("cashier"));
        if (!isset($postData["cashier"]["id"]) || !is_numeric($postData["cashier"]["id"])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        $cashier = Cashier::model()->findByPk($postData["cashier"]["id"]);
        if (!$cashier) {
            throw new CHttpException(204, $this->getStatusCodeMessage(204));
        }

        $cashier->attributes = $postData["cashier"];

        if ($cashier->save()) {
            $this->render(array(
                "success" => true,
                "data" => array(
                    "cashier" => $cashier->attributes,
                )
            ));
        } else {
            $this->render(array(
                "success" => false,
                "error" => array(
                    "code" => 1001,
                    "errorCode" => 0,
                    "message" => $this->getStatusCodeMessage(1001),
                    "content" => $cashier->getErrors(),
                )
            ));
        }
    }

    public function actionDelete()
    {
        $this->validateAuthorizationToken(self::AUTHORIZTION_KEY);
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("id"));

        $cashier = Cashier::model()->findByPk($postData["id"]);

        if (!$cashier) {
            throw new CHttpException(204, $this->getStatusCodeMessage(204));
        }

        if (!$cashier->delete()) {
            $this->render(array(
                "success" => false,
                "error" => array(
                    "code" => 1001,
                    "errorCode" => 0,
                    "message" => $this->getStatusCodeMessage(1001),
                    "content" => $cashier->getErrors(),
                )
            ));
        }

        $this->render(array(
            "success" => true
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionGetCashier()
    {
        $this->validateAuthorizationToken(self::AUTHORIZTION_KEY);
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("pagesize"));
        $postData["page"] = isset($postData["page"]) && is_numeric($postData["page"]) && $postData["page"] >= 1 ? $postData["page"] : 1;
        $postData["pagesize"] = isset($postData["pagesize"]) && is_numeric($postData["pagesize"]) && $postData["pagesize"] >= 1 ? $postData["pagesize"] : 10;

        $dependency = new CDbCacheDependency();
        $criteria = new CDbCriteria();
        $criteria->limit = $postData["pagesize"];
        $criteria->offset = $criteria->limit * ($postData["page"] - 1);

        $count = Cashier::model()->cache(Yii::app()->params["cache_duration"], $dependency)->count($criteria);
        $cashiers = array();

        foreach (Cashier::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findAll($criteria) as $cashier) {
            $cashiers[] = $cashier->attributes;
        }

        $this->render(array(
            "success" => true,
            "data" => array(
                "cashiers" => $cashiers,
                "pages" => ceil($count / $postData["pagesize"]),
            )
        ));
    }


}