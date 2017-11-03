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

    function doPost()
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
        catch(Exception $e) {
            //default exception type
            echo $e->getMessage();
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
        doPost();
?>