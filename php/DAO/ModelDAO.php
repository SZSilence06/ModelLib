<?php
    require_once "php/Exception/Exception.php";
    require_once "php/Model/Model.php";

    class ModelDAO
    {
        private static $instance_;
        private $modelDir_ = "/home/zju/sites/ModelLib/data/model/";
        private $connection_;
        private $table_ = "Model";
        private $colId_ = "ID";
        private $colName_ = "name";
        private $colLocation_ = "location";
        private $colHash_ = "hash";
        private $colDesc_ = "description";
        private $colOriginal_ = "original";
        private $colAvatar_  = "avatar";

        private $stmAddModel_;
        private $stmQueryExisting_;
        private $stmGetModels_;
        private $stmGetModelById_;

        private  function connect()
        {
            $host = "localhost";
            $dbname = "ModelLib";
            $username = "ModelLib";
            $password = "zju123456";
    
            $this->connection_ = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $password, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));

            //create statements
            $sql = "INSERT INTO $this->table_  ($this->colName_, $this->colLocation_, $this->colHash_, $this->colOriginal_, $this->colDesc_,
                    $this->colAvatar_) 
                   VALUES(:name, :modelPath, :hashcode, :original, :description, :avatar);";
            $this->stmAddModel_ = $this->connection_->prepare($sql);
            
            $sql = "SELECT * FROM $this->table_ WHERE $this->colHash_ = :hashcode;";
            $this->stmQueryExisting_ = $this->connection_->prepare($sql);

            $sql = "SELECT * FROM $this->table_;";
            $this->stmGetModels_ = $this->connection_->prepare($sql);

            $sql = "SELECT * FROM $this->table_ WHERE $this->colId_ = :id;";
            $this->stmGetModelById_ = $this->connection_->prepare($sql);
        }

        private function __construct()
        {
            $this->connect();
        }

        private function computeHash($file)
        {
            if(($handle = fopen($file, "r")) == FALSE)
                throw new OpenFileException("unable to open file $file", $file);
            if(($content = fread($handle, filesize($file))) == FALSE)
                throw new ReadFileException("unable to read file $file", $file);
            return hash("sha256", $content);
        }

        private function removeDir($fullPath) {
            $dirIndex = strrpos($fullPath, '/');
            return substr($fullPath, $dirIndex + 1, strlen($fullPath) - $dirIndex - 1);
        }

        private function getExtension($fullPath) {
            $dotIndex = strrpos($fullPath, '.');
            return substr($fullPath, $dotIndex + 1, strlen($fullPath) - $dotIndex - 1);
        }
       
        public function addModel($user, $model)
        {
            $name = $model->getName();
            
            $file = $model->getFile();
            $filename = $this->removeDir($file);
            $ext = $this->getExtension($file);
            if($ext != 'obj') {
                throw new Exception("only .obj files are allowed.");
            }

            //check whether the file has existed
            $hashcode = $this->computeHash($file);
            //$this->stmQueryExisting_->execute(array(":hashcode" => $hashcode));
            //if($this->stmQueryExisting_->rowCount())
            //    throw new ModelExistingException();

            $modelPath = $this->modelDir_.$name.'.obj';
            if(file_exists($modelPath)) {
                for($i = 2;; $i++) {
                    $modelPath = $this->modelDir_.$name . '(' . $i . ').obj';
                    if(file_exists($modelPath) === FALSE)
                        break;
                }
            }
           
            if(move_uploaded_file($file, $modelPath) == false) 
                throw new UploadException("Failed to upload model!");

            $this->stmAddModel_->execute(array(":name" => $name, ":modelPath" => $modelPath, ":hashcode" => $hashcode, 
                                               ":original" => $model->getOriginalSource(), ":description" => $model->getDescription(),
                                               ":avatar" => $model->getAvatar()));
        }

        private function makeModelFromRow($row) {
            $model = new Model();
            $model->setId($row[$this->colId_]);
            $model->setName($row[$this->colName_]);
            $model->setFile($row[$this->colLocation_]);
            $model->setAvatar($row[$this->colAvatar_]);
            $model->setOriginalSource($row[$this->colOriginal_]);
            $model->setDescription($row[$this->colDesc_]);
            return $model;
        }

        public function getModels() {
            $this->stmGetModels_->execute();
            $models = array();
            foreach($this->stmGetModels_ as $row) {
                array_push($models, $this->makeModelFromRow($row));
            }
            return $models;
        }

        public function getModelById($id) {
            $this->stmGetModelById_->execute(array(":id" => $id));
            $row = $this->stmGetModelById_->fetch(PDO::FETCH_ASSOC);
            if(!$row)
                return NULL;
            
            return $this->makeModelFromRow($row);    
        }

        public static function getInstance()
        {
            if(!isset(self::$instance_)) {
                self::$instance_ = new ModelDAO();
            }
            return self::$instance_;
        }
    }
?>