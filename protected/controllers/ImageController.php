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

    public function actionGetImageFile()
    {
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("id"));
        $dependency = new CDbCacheDependency();
        $image = ImageContent::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findByAttributes(array(
            "id" => $postData["id"],
            "display_mode" => Album::DISPLAY_MODE_PUBLIC,
        ));
        if (!$image) throw new CHttpException(204, $this->getStatusCodeMessage(204));
        $this->render(array(
            "success" => true,
            "data" => array(
                "content" => base64_encode(@file_get_contents($image->path)),
            )
        ));
    }

    public function actionGetImageInfo()
    {
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("id"));
        $dependency = new CDbCacheDependency();
        $image = ImageContent::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findByAttributes(array(
            "id" => $postData["id"],
            "display_mode" => Album::DISPLAY_MODE_PUBLIC,
        ));
        if (!$image) throw new CHttpException(204, $this->getStatusCodeMessage(204));
        $this->render(array(
            "success" => true,
            "data" => array(
                $image->attributes,
            )
        ));
    }

    public function actionGetImages()
    {
        $this->validateAuthorizationToken(self::AUTHORIZTION_KEY);
        $postData = $this->getJsonData();
        $postData = $this->checkDatatInput($postData, array("pagesize", "album_id"));
        $postData["page"] = isset($postData["page"]) && is_numeric($postData["page"]) && $postData["page"] >= 1 ? $postData["page"] : 1;
        $postData["pagesize"] = isset($postData["pagesize"]) && is_numeric($postData["pagesize"]) && $postData["pagesize"] >= 1 ? $postData["pagesize"] : 10;

        $dependency = new CDbCacheDependency();
        $criteria = new CDbCriteria();
        $criteria->addCondition("album_id = " . $postData["album_id"], 'AND');
        $criteria->limit = $postData["pagesize"];
        $criteria->offset = $criteria->limit * ($postData["page"] - 1);

        $count = ImageContent::model()->cache(Yii::app()->params["cache_duration"], $dependency)->count($criteria);
        $images = array();

        foreach (ImageContent::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findAll($criteria) as $image) {
            $images[] = $image->attributes;
        }

        $this->render(array(
            "success" => true,
            "data" => array(
                "images" => $images,
                "pages" => ceil($count / $postData["pagesize"]),
            )
        ));
    }

    public function actionGetAlbums()
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

        $count = Album::model()->cache(Yii::app()->params["cache_duration"], $dependency)->count($criteria);
        $albums = array();

        foreach (Album::model()->cache(Yii::app()->params["cache_duration"], $dependency)->findAll($criteria) as $album) {
            $albums[] = $album->attributes;
        }

        $this->render(array(
            "success" => true,
            "data" => array(
                "albums" => $albums,
                "pages" => ceil($count / $postData["pagesize"]),
            )
        ));
    }

    public function actionTest()
    {
        $imgUrUploader = Yii::app()->imgUrUploader;
        $img = ImageContent::model()->findByPk(3);
        var_dump(Yii::app()->getRequest()->sendFile("123.jpg", @file_get_contents($img->path)));
    }
}