<?php
    require_once 'php/ModelLib.php';

    ini_set('display_errors', 1);
    error_reporting(-1);

    function postModel()
    {
        if(isset($_FILES['model_file']) == false ) {
            throw new Exception("No model file.");
        }
        if($_FILES['model_file']['error']) {
            throw new UploadException($_FILES['model_file']['error']);
        }
        if(isset($_FILES['model_avatar']) && $_FILES['model_avatar']['name'] && $_FILES['model_avatar']['error']) {
            throw new UploadException($_FILES['model_avatar']['error']);
        }
        
        $dao = ModelDAO::getInstance();
        $model = new Model();
        $model->setName($_POST['model_name']);
        $model->setFile($_FILES['model_file']['tmp_name']);
        $model->setOriginalSource($_POST['model_source']);
        $model->setDescription($_POST['model_desc']);
        $model->setAvatar($_FILES['model_avatar']['tmp_name']);
        $dao->addModel(NULL, $model);
        echo 'succeeded!';
    }

    function doUpload()
    {
        try{
            postModel();
        }
        catch(ModelExistingException $e) {
            //TODO
            echo 'model already exists!';
        }
        catch(MySQLException $mysqlException) {
            //TODO
            echo $e->getMessage();
        }
        catch(UploadException $e) {
            echo 'Upload failed due to the following reason:' . $e->getMessage();
        }
    }

    function downloadModel() {
        $id = $_GET['id'];
        if(!$id) 
            throw new InvalidRequestException("Invalid request: no parameter 'ID' for 'method=download'");

        $dao = ModelDAO::getInstance();
        $model = $dao->getModelById($id);
        if(!$model)
            throw new DownloadException("The model does not exist.");
        
        $filePath = $model->getFile();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        if(readfile($filePath) == FALSE)
            throw new DownloadException("Unknown Error");
    }

    function doDownload() {
        try {
            downloadModel();
        }
        catch(DownloadException $e) {
            echo 'Download Failed: ' . $e->getMessage(); 
        }
    }

    function doGet() {
        switch($_GET["method"]) {
            case 'download':
                doDownload();
                break;
        }
    }

    function doPost() {
        switch($_POST["method"]) {
            case 'upload' :
                doUpload();
                break; 
        }
    }

    try{
        if($_SERVER["REQUEST_METHOD"] == "GET")
          doGet();

        if($_SERVER["REQUEST_METHOD"] == "POST")
          doPost();
    }
    catch(Exception $e) {
        //default exception type
        echo $e->getMessage();
    }
?>