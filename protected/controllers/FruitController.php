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

        $postData = $postData['data'];
        $responseData = array(
            'success' => false,
            'data' => array(),
            'pages' => 1,
        );

        $dependency = new CDbCacheDependency();
        $criteria = new CDbCriteria();
        $criteria->addCondition('isuse = 1', 'AND');
        $criteria->limit = isset($postData["pagesize"]) ? $postData["pagesize"] : $criteria->limit;
        $criteria->offset = isset($postData["page"]) ? $criteria->limit * ($postData["page"] - 1) : $criteria->offset;

        $count = Fruits::model()->cache(Yii::app()->params["cache_duration"], $dependency)->count($criteria);
        $fruits = Fruits::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findAll($criteria);

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

        $responseData['pages'] = isset($postData["pagesize"]) ? ceil($count / $postData["pagesize"]) : $responseData['pages'];

        $this->render($responseData);
    }

    public function ActionGetFruit()
    {

    }
}