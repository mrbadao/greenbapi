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

        $responseData = array(
            'success' => false,
            'data' => array(),
        );

        $criteria = new CDbCriteria();
        $criteria->addCondition('isuse = 1', 'AND');
        $fruits = Fruits::model()->findAll($criteria);

        if (!$fruits) $this->render($responseData);
        $responseData['success'] = true;

        foreach ($fruits as $fruit) {
            $fruitNutritions = FruitNutrition::model()->findAllByAttributes(array('fruit_id' => $fruit->id));
            $fullFruitData = $fruit->attributes;
            foreach ($fruitNutritions as $fruitNutrition) {
                $fullFruitData = array_merge($fullFruitData, array($fruitNutrition->name => $fruitNutrition->value));
            }
            $responseData['data'][] = $fullFruitData;
        }

        $this->render($responseData);
    }

    public function ActionGetFruit()
    {

    }
}