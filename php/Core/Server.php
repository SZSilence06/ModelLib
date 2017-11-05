<?php
    require_once 'Router.php';

    class Server {
        private $router_;

        public function __construct() {
            $this->router_ = new DefaultRouter();
        }

        public function run() {
            $this->router_->route($_SERVER['REQUEST_URI']);
        }
    }
?>