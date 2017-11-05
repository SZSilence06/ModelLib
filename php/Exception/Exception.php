<?php
    class MySQLException extends Exception
    {
        
    }

    class UploadException extends Exception{
        
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