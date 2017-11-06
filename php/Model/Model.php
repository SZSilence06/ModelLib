<?php
    class Model
    {
        private $file_;   //string
        private $tags_;    //array of string
        private $name_;         //string
        private $avatar_;       //string indicating address of the avatar
        private $id_;
        private $originalSource_;  //string indicatiing the original source of the model
        private $description_;
        
        public function getName() {
            return $this->name_;
        }

        public function setName($name) {
            $this->name_ = $name;
        }

        public function getFile() {
            return $this->file_;
        }

        public function setFile($file) {
            $this->file_ = $file;
        }

        public function setAvatar($avatar) {
            $this->avatar_ = $avatar;
        }

        public function getAvatar() {
            return $this->avatar_;
        }

        public function getSize() {
            $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
            $decimals = 2;
            $bytes = filesize($this->file_);
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
        }

        public function setId($id) {
            $this->id_ = $id;
        } 

        public function getId() {
            return $this->id_;
        }

        public function setDescription($description) {
            $this->description_ = $description;
        }

        public function getDescription() {
            return $this->description_;
        }

        public function setOriginalSource($originalSource) {
            $this->originalSource_ = $originalSource;
        }

        public function getOriginalSource() {
            return $this->originalSource_;
        }
    }
?>