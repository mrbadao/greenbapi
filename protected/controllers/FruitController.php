<?php

class FruitController extends Controller
{
    const AUTHORIZTION_KEY = "Client-Token";

    public function actionGetAll()
    {

        $postData = $this->getJsonData();
        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents']))
            throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if (!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $responseData = array();

        $fruits = Fruits::model()->findAll();

        foreach ($fruits as $fruit) {
            $fruitNutritions = FruitNutrition::model()->findAllByAttributes(array('fruit_id' => $fruit->id));
            $fullFruitData = $fruit->attributes;
            foreach ($fruitNutritions as $fruitNutrition) {
                $fullFruitData = array_merge($fullFruitData, array($fruitNutrition->name => $fruitNutrition->value));
            }
            $responseData['fruits'][] = $fullFruitData;
        }

        $this->render($responseData);
    }

    public function ActionGetFruit()
    {

    }
}