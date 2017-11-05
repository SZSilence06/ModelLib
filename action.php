<?php
    require_once 'php/ModelLib.php';

    function postModel()
    {
        if(isset($_FILES['model_file']) == false || $_FILES['model_file']['error']) {
            throw new Exception('post model failed!');
        }
        
        $dao = ModelDAO::getInstance();
        $model = new Model();
        $model->setName($_FILES['model_file']['name']);
        $model->setFile($_FILES['model_file']['tmp_name']);
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