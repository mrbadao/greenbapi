<?php

class ImageController extends Controller
{
    const AUTHORIZTION_KEY = "Client-Token";

    public function actionUpload()
    {

        $postData = $this->getJsonData();
        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if(!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $authorization = explode(' ',$this->getHttpRequestHeaderAuthorization());
        if(count($authorization) != 3) throw new CHttpException(204, $this->getStatusCodeMessage(204));
        if($authorization[0] != self::AUTHORIZTION_KEY || !Tokens::checkToken($authorization[1], $authorization[2])) throw new CHttpException(401, $this->getStatusCodeMessage(401));
        if(!isset($postData['data'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));

        $Images = isset($postData['data']['files']) ? $postData['data']['files'] : array();

        $responseData = array("data" => array());
        for($i =0; $i<count($Images); $i++){
            $responseData["data"][$Images[$i]['filename']]["success"] = true;

            $imageModel = new Image($Images[$i]);

            if($imageModel->save())
                $imageListModel[] = $imageModel;
            else {
                $responseData["data"][$Images[$i]['filename']]["success"] = false;
                $responseData["data"][$Images[$i]['filename']]["ValidateError"] = array($imageModel->getErrors());
            }

            $imageSchema = new ImageContent();
            $imageSchema->attributes = array(
                "name" => strtotime(date("Y-m-d H:m:s")),
                "filename"=> $imageModel->getfullname(),
                "path" => "123",
                "mime_type" => $imageModel->mime_type,
                "display_mode" => 1,
                "signature" => md5($imageModel->content),
            );

            if(!$imageSchema->save(false)) {
                $imageModel->removeImage();
                $responseData["data"][$Images[$i]['filename']]["success"] = false;
                $responseData["data"][$Images[$i]['filename']]["ValidateError"] = array($imageModel->getErrors());
            }

        }

        $this->render($responseData);
    }

    public function actionTest(){
        echo(Image::getBase64Data());
    }
}