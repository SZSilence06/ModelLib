<?php
    class MySQLException extends Exception
    {
        
    }

    class UploadException extends Exception{
        public function __construct($errorCode) {
            $message = $this->codeToMessage($errorCode); 
            parent::__construct($message, $errorCode); 
        }

        private function codeToMessage($code) 
        { 
            switch ($code) { 
                case UPLOAD_ERR_INI_SIZE: 
                    $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                    break; 
                case UPLOAD_ERR_FORM_SIZE: 
                    $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                    break; 
                case UPLOAD_ERR_PARTIAL: 
                    $message = "The uploaded file was only partially uploaded"; 
                    break; 
                case UPLOAD_ERR_NO_FILE: 
                    $message = "No file was uploaded"; 
                    break; 
                case UPLOAD_ERR_NO_TMP_DIR: 
                    $message = "Missing a temporary folder"; 
                    break; 
                case UPLOAD_ERR_CANT_WRITE: 
                    $message = "Failed to write file to disk"; 
                    break; 
                case UPLOAD_ERR_EXTENSION: 
                    $message = "File upload stopped by extension"; 
                    break; 
    
                default: 
                    $message = "Unknown upload error. error code is $code"; 
                    break; 
            } 
            return $message; 
        } 
    }

    class DownloadException extends Exception {
        
    }

    class ModelExistingException extends Exception {
        
    }

    class IOException extends Exception {

    }

    class FileException extends IOException {
        private $filename_ = NULL;
        public function __construct($message, $filename)
        {
            parent::__construct($message);
            $this->filename_ = $filename;
        }
    }

    class OpenFileException extends FileException {
        
    }

    class ReadFileException extends FileException {
        
    }

    class ParamException extends Exception {
        public function __construct($paramName, $paramValue) {
            parent::__construct('Invalid Paramter: $paramName = $paramValue');
        }
    }

    class InvalidRequestException extends Exception {
    }
?>