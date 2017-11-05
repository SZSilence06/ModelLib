<?php
    class Router {
        private $get_routes_ = array();
        private $post_routes_ = array();

        public function route($url) {
            if($_SERVER['REQUEST_METHOD'] === 'GET')
                $routes = $this->get_routes_;
            else if($_SERVER['REQUEST_METHOD'] === 'POST')
                $routes = $this->post_routes_;
        
            foreach($routes as $regex => $handler) {
                $regex = $this->prepare($regex);
                if(preg_match($regex, $url)) {
                    $handler();
                    return;
                }
            }
            
            $theme_dir = "theme/".THEME;
            require_once("$theme_dir/404.php");
        }

        public function get($regex_url, $handler) {
            $this->get_routes_[$regex_url] = $handler;
        }

        public function post($regex_url, $handler) {
            $this->post_routes_[$regex_url] = $handler;
        }

        private function prepare($regex) {
            $regex = str_replace('/', '\/', $regex);
            return '/'. $regex . '/';
        }
    }

    class DefaultRouter extends Router {
        public function __construct() {
            $this->get('^/$', function() {
                $theme_dir = "theme/".THEME;
                require_once("$theme_dir/index.php");
            });
            $this->post('^/$', function() {
                $theme_dir = "theme/".THEME;
                require_once("$theme_dir/index.php");
            });
            $this->get('^/post_models$', function() {
                $theme_dir = "theme/".THEME;
                require_once("$theme_dir/post_models.php");
            });
            $this->get('^/list_models$', function() {
                $theme_dir = "theme/".THEME;
                require_once("$theme_dir/list_models.php");
            });
        }
    }
?>