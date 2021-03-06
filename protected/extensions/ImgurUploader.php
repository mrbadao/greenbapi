<?php

/**
 * Class ImgurUploader
 */
class ImgurUploader extends CApplicationComponent
{
    const ImgUrAPI_ALIAS_PASTH = "application.vendors.ImgUrAPI";
    const ImgUrAPI_MINE_URL = "https://api.imgur.com/3/account/[:user_id]/[:action]";
    const ImgUrAPI_DEFAULT_URL = "https://api.imgur.com/3/[:action]";
    const  ImgUrAPI_OAUTH_URL = "https://api.imgur.com/oauth2/[:action]";
    const  TIMEOUT = 30;

    public $refreshToken;
    public $client_id;
    public $client_secret;
    public $user_id;
    private $accessToken;

    function _loadmodel($classname = "*")
    {
        $path = sprintf("%s/models/", Yii::getPathOfAlias(self::ImgUrAPI_ALIAS_PASTH));

        if($classname != "*" && $classname){
            $filename = $path.$classname.".php";
            if(file_exists($filename)) include_once($filename);
            else throw new CHttpException(404,"File '$filename' does not exist.",100);
        }else{
            $path = sprintf("%s*.php",$path);
            foreach (glob($path) as $filename) {
                include_once($filename);
            }
        }
    }

    function init()
    {
        self::_loadmodel("*");
        $postFields = array(
            "refresh_token" => $this->refreshToken,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "refresh_token",
        );
        $url = str_replace("[:action]", "token", self::ImgUrAPI_OAUTH_URL);
        $result = self::excuteHTTPSRequest($url, null, $postFields);

        if (isset($result['access_token'])) $this->accessToken = $result['access_token'];
        else $this->accessToken = null;
    }

    /**
     * get all images infomation
     *
     * @return array|string
     */
    public function getImages()
    {
        $url = str_replace("[:action]", "images", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_images = '';
        foreach ($result['data'] as $item) {
            $_img = new ImgUrImage();
            $_img->setAttributes($item);
            $_images[] = $_img;
        }

        return $_images;
    }

    /**
     * get all Albums infomation
     *
     * @return array|string
     */
    public function getAlbums()
    {
        $url = str_replace("[:action]", "albums", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_albums = '';

        foreach ($result['data'] as $item) {
            $_album = new ImgUrAlbum();
            $_album->setAttributes($item);
            $_albums[] = $_album;
        }

        return $_albums;
    }

    /**
     * get image infomation
     *
     * @param $id
     * @return \Image
     */
    public function getImage($id)
    {
        $url = str_replace("[:action]", "image/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_img = new ImgUrImage();
        $_img->setAttributes($result['data']);
        return $_img;
    }

    /**
     * get Album infomation
     *
     * @param $id
     * @return \Album
     */
    public function getAlbum($id)
    {
        $url = str_replace("[:action]", "album/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        if(isset($result['data']['error']) && $result['data']['error']) return false;

        $_album = new ImgUrAlbum();
        $_album->setAttributes($result['data']);

        return $_album;
    }

    /**
     * check Album exists
     *
     * @param $id
     * @return \Album
     */
    public function checkAlbumExists($id)
    {
        $url = str_replace("[:action]", "album/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);
        if(isset($result['data']['error']) && $result['data']['error']) return false;
        return true;
    }


    /**
     * Get all albums id
     *
     * @return array|null
     */
    public function getAlbumsId()
    {
        $url = str_replace("[:action]", "albums/ids", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        return isset($result['data']) && !empty($result['data']) ? $result['data'] : null;
    }

    /**
     * Get all albums id     *
     *
     * @return array|null
     */
    public function getImagesId()
    {
        $url = str_replace("[:action]", "images/ids", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        return isset($result['data']) && !empty($result['data']) ? $result['data'] : null;
    }


    /**
     * delete image
     *
     * @param $id
     * @return bool
     */
    public function deleteImage($id)
    {
        $img = self::getImage($id);
        if ($img) {
            $url = str_replace("[:action]", "image/" . $img->_deletehash, self::ImgUrAPI_MINE_URL);
            $url = str_replace("[:user_id]", $this->user_id, $url);
            $result = self::excuteHTTPSRequest($url, $this->accessToken, null, "DELETE");
            return isset($result['data']) && $result['data'] == true && $result['success'] ? true : false;
        }
        return true;
    }


    /**
     * delete Album
     *
     * @param $id
     * @return bool
     */
    public function deleteAlbum($id)
    {
        $album = self::getAlbum($id);
        if ($album) {
            $url = str_replace("[:action]", "albums/" . $album->_deletehash, self::ImgUrAPI_MINE_URL);
            $url = str_replace("[:user_id]", $this->user_id, $url);
            $result = self::excuteHTTPSRequest($url, $this->accessToken, null, "DELETE");
            return isset($result['data']) && $result['data'] == true && $result['success'] ? true : false;
        }
        return true;
    }


    /**
     * Create Album
     *
     * @param null $params
     * @return \Album|null
     */
    public function createAlbum($params = null)
    {
        $url = str_replace("[:action]", "album", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);

        if ($result['success']) {
            $newAlbum = new ImgUrAlbum();
            $newAlbum->setAttributes($result['data']);
            return $newAlbum;
        }

        return null;
    }

    /**
     * Upload Image
     *
     * @param null $params
     * @return \Image|null
     */
    public function uploadImage($params = null)
    {
        $url = str_replace("[:action]", "image.json", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);

        if ($result['success']) {
            $newImage = new ImgUrImage();
            $newImage->setAttributes($result['data']);
            return $newImage;
        }
        return null;
    }

    /**
     * Get credit current user.
     *
     * @return null
     */
    public function getCredit()
    {
        $url = str_replace("[:action]", "credits", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, null, null);
        return isset($result['data']) && $result['data'] == true && $result['success'] ? $result['data'] : null;
    }

    /**
     * Update Image Information
     *
     * @param $id
     * @param null $params
     * @return bool
     */
    public function UpdateImageInfo($id, $params = null)
    {
        $url = str_replace("[:action]", "image/$id", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);
        return $result['success'] ? true : false;
    }


    public function UpdateAlbumInfo($id, $params = null)
    {
        $url = str_replace("[:action]", "album/$id", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);
        return $result['success'] ? true : false;
    }

    private function excuteHTTPSRequest($url, $accessToken = null, $postFields = null, $customRequestMethod = null)
    {
        $curl = curl_init();
        $header = null;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        if ($accessToken) {
            $header[] = "Authorization:Bearer " . $accessToken;
        } else {
            $header[] = "Authorization:Client-ID " . $this->client_id;
        }

        if ($customRequestMethod) curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($customRequestMethod));

        if ($postFields) {
            curl_setopt($curl, CURLOPT_POST, count($postFields));
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postFields));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $out = curl_exec($curl);
        curl_close($curl);
        return json_decode($out, true);
    }
}