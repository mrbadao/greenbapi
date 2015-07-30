<?php

class ImageController extends Controller
{
    const AUTHORIZTION_KEY = "Client-Token";

    public function actionUpload()
    {

        $postData = $this->getJsonData();
        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if (!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $authorization = explode(' ', $this->getHttpRequestHeaderAuthorization());
        if (count($authorization) != 3) throw new CHttpException(204, $this->getStatusCodeMessage(204));
        if ($authorization[0] != self::AUTHORIZTION_KEY || !Tokens::checkToken($authorization[1], $authorization[2])) throw new CHttpException(401, $this->getStatusCodeMessage(401));
        if (!isset($postData['data'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));

        $Images = isset($postData['data']['files']) ? $postData['data']['files'] : array();

        $responseData = array("data" => array());
        for ($i = 0; $i < count($Images); $i++) {
            $responseData["data"][$Images[$i]['title']]["success"] = true;

            $imageModel = new Image($Images[$i]);

            if (!$imageModel->save(isset($postData['data']['album_id']) && is_numeric($postData['data']['album_id']) ? $postData['data']['album_id'] : '')) {
                $responseData["data"][$Images[$i]['title']]["success"] = false;
                $responseData["data"][$Images[$i]['title']]["ValidateError"] = array($imageModel->getErrors());
                continue;
            }

            $imageSchema = new ImageContent();
            $imageSchema->attributes = array(
                "album_id" => isset($postData['data']['album_id']) && is_numeric($postData['data']['album_id']) ? $postData['data']['album_id'] : '',
                "title" => $imageModel->title,
                "filename" => $imageModel->getfullname(),
                "path" => $imageModel->getAccessLink(),
                "mime_type" => $imageModel->mime_type,
                "signature" => md5($imageModel->content),
            );

            if (!$imageSchema->save()) {
                $imageModel->removeImage();
                $responseData["data"][$Images[$i]['title']]["success"] = false;
                $responseData["data"][$Images[$i]['title']]["ValidateError"] = array($imageModel->getErrors());
            }

        }

        $this->render($responseData);
    }

    public function ActionCreateAlbum()
    {
        $postData = $this->getJsonData();
        if (!isset($postData['Request-Agent']) || !in_array($postData['Request-Agent'], Yii::app()->params['requestAgents'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));
        if (!isset($postData['data']) || !is_array($postData['data'])) throw new CHttpException(204, $this->getStatusCodeMessage(204));

        $authorization = explode(' ', $this->getHttpRequestHeaderAuthorization());
        if (count($authorization) != 3) throw new CHttpException(204, $this->getStatusCodeMessage(204));
        if ($authorization[0] != self::AUTHORIZTION_KEY || !Tokens::checkToken($authorization[1], $authorization[2])) throw new CHttpException(401, $this->getStatusCodeMessage(401));
        if (!isset($postData['data'])) throw new CHttpException(400, $this->getStatusCodeMessage(400));

        $responseData = null;
        $album = new Album();
        $album->attributes = $postData['data'];

        if (!$album->save()) {
            $responseData["success"] = false;
            $responseData["data"]["ValidateError"] = array($album->getErrors());
            $this->render($responseData);
        }

        $responseData["success"] = false;
        $responseData["data"]["album"] = $album->attributes;
        $this->render($responseData);
    }

    public function actionTest()
    {
        $imgUrUploader = Yii::app()->imgUrUploader;
        var_dump($imgUrUploader->checkAlbumExists('123123'));
    }
}