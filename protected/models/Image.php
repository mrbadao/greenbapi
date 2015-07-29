<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Image extends CModel
{
    public $filename;
    public $extension;
    public $content;
    public $mime_type;

    protected $allowType = array("image/jpeg");

    function __construct($params)
    {
        foreach ($params as $attr => $val) {
            $this->{$attr} = $val;
        }
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // required
            array('filename, extension, content', 'required'),
            // validateMimeType
            array('content', 'validateMimeType'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'filename' => 'Filename',
            'extension' => 'Extension',
        );
    }

    /**
     * validateMimeType the Content.
     * This is the 'validateMimeType' validator as declared in rules().
     */
    public function validateMimeType()
    {
        $f = finfo_open();
        $this->mime_type = finfo_buffer($f, base64_decode($this->content), FILEINFO_MIME_TYPE);

        if (!in_array($this->mime_type, $this->allowType)) {
            $this->addError("content", "Are u troll me ???");
            return false;
        }
        return true;
    }


    public function attributeNames()
    {
        // TODO: Implement attributeNames() method.
        return array('filename', 'extension');
    }

    public function getfullname()
    {
        return sprintf('%s.%s', $this->filename, $this->extension);
    }

    public function save($path = null)
    {
        if (!$this->validate()) return false;

        $path = $path ? $path : Yii::getPathOfAlias("application.runtime");
        $imgData = base64_decode($this->content);
        $filename = sprintf($path . DIRECTORY_SEPARATOR . "%s.%s", $this->filename, $this->extension);
        file_put_contents($filename, $imgData);

        return true;
    }

    public function removeImage($path = null)
    {
        $path = $path ? $path : Yii::getPathOfAlias("application.runtime");
        $filename = sprintf($path . DIRECTORY_SEPARATOR . "%s.%s", $this->filename, $this->extension);
        if(file_exists($filename)) unlink($filename);
    }

    public static function getBase64Data($filename = "sample.jpg")
    {
        $path = Yii::getPathOfAlias("application.runtime");
        $saveName = $path . DIRECTORY_SEPARATOR . $filename;
        $file = file_get_contents($saveName);
        return base64_encode($file);
    }
}
