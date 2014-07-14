<?php

/**
 * class.imageEncode
 *
 * Simple class to base64 encode an image. This class will read in an image then provide the 
 * encoded image in either an img tag or css.     
 *
 * @package    class.imageEncode.php
 * @link       /includes/class.imageEncode.php
 * @author     Dan Ward <dpw989@gmail.com>
 * @copyright  2014
 * @version    1.0
 * @since      1.0
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License v3
 */
class imageEncode {

    protected static $instance = null;
    private $okMimeTypes = array("image/gif", "image/jpeg", "image/png", "image/bmp", "image/tiff");
    private $error;
    private $mimeType = "";
    private $fileSize = "";
    private $fileContent = "";
    private $imageUrl = "";
    private $imageHeight = "";
    private $imageWidth = "";
    private $imageHW = "";

    /**
     * call this method to get instance
     * */
    public static function getInstance() {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     *  Class constructor
     * 
     * @param string $image - path to image.
     * @return boolean
     */
    public function __construct($image) {

        if (!$this->setMimeType($image)) {
            $this->setError("Incorrect mime type.");
            return false;
        }

        $this->setImageHW($image);
        $this->setFileSize($image);
        $this->setFileContent($image);
        $this->setImageUrl();
    }

    /**
     * Remove instance when we destroy the class. 
     */
    public function __destruct() {
        static::$instance = null;
    }

    /**
     * Get the Mime Type of the given image. 
     * @return String
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Get the file size of the Image.
     * @return int
     */
    public function getFileSize() {
        return $this->fileSize;
    }

    /**
     * Get the image as a string. 
     * @return String
     */
    public function getFileContent() {
        return $this->fileContent;
    }

    /**
     * Get the image in a base64 encoded URL.
     * @return String
     */
    public function getImageUrl() {
        return $this->imageUrl;
    }

    /**
     *  Get the image warpped in an img tag
     * @param String $alt - the text for the alt element.  
     * @param Float $percent - Adjust the hight/width to a percentage. 
     * @return String
     */
    public function getImageHtml($alt = null, $percent = 1.00) {
        return "<img src='" . $this->getImageUrl() . "' alt='$alt' height='" . ($this->getImageHeight() * $percent) . "' width='" . ($this->getImageWidth() * $percent) . "' />";
    }

    /**
     * Get the encoded inage CSS
     * @param String $className - Class to output with the CSS. 
     * @return string
     */
    public function getImageCSS($className) {
        $css = ".$className{" . PHP_EOL;
        $css .= "color: #fff;" . PHP_EOL;
        $css .= "text-decoration:none;" . PHP_EOL;
        $css .= "background-image: url('" . $this->getImageUrl() . "')" . PHP_EOL;
        $css .= "background-repeat:no-repeat;" . PHP_EOL;
        $css .= "height:" . $this->getImageHeight() . ";" . PHP_EOL;
        $css .= "width:" . $this->getImageWidth() . ";" . PHP_EOL;
        $css .= "}" . PHP_EOL;
        return $css;
    }

    /**
     * get the height/width in a string. 
     * @return String. 
     */
    public function getImageHW() {
        return $this->imageHW;
    }

    /**
     * Get the height of the image. 
     * @return int
     */
    public function getImageHeight() {
        return $this->imageHeight;
    }

    /**
     * Get the width of the image. 
     * @return int
     */
    public function getImageWidth() {
        return $this->imageWidth;
    }

    /**
     * Gets the last error. 
     * @return String
     */
    public function getError() {
        return $this->error;
    }

    /**
     *  Set the Mime type of this image. 
     * @param String $image - Path to Image
     * @param String $mime - Manually set the mime type. 
     * @return Boolean - If this is an accepted mime type. 
     */
    private function setMimeType($image, $mime = '') {
        if (function_exists('mime_content_type') && $mime === '') {
            $this->mimeType = mime_content_type($image);
        } else {
            $this->mimeType = $mime;
        }
        return in_array($this->mimeType, $this->okMimeTypes);
    }

    /**
     * Set the file sixe of the image. 
     * @param String $image - Path to Image
     */
    private function setFileSize($image) {
        $this->fileSize = filesize($image);
    }

    /**
     * Sets the File contents 
     * @param String $image - Path to Image
     */
    private function setFileContent($image) {
        $this->fileContent = file_get_contents($image);
    }

    /**
     * Sets the image URL 
     */
    private function setImageUrl() {
        $this->imageUrl = 'data: ' . $this->getMimeType() . ';base64,' . base64_encode($this->getFileContent());
    }

    /**
     * Set the image dimensions
     * @param String $image - Path to Image
     */
    private function setImageHW($image) {
        $imgArray = getimagesize($image);
        $this->imageWidth = $imgArray[0];
        $this->imageHeight = $imgArray[1];
        $this->imageHW = $imgArray[3];
    }

    /**
     * Set an error message. 
     * @param String $error - Error Message. 
     */
    private function setError($error) {
        $this->error = $error;
    }

}
