<?php
    require_once 'config.php';

    function ML_loadTheme() {
        $theme_dir = "theme/".THEME;
        require_once("$theme_dir/post_model.php");
    }

    function ML_header() {
        $theme_dir = "theme/".THEME;
        require_once("$theme_dir/header.php");
    }

    function ML_footer() {
        $theme_dir = "theme/".THEME;
        require_once("$theme_dir/footer.php");
    }

    function ML_stylesheet() {
        $theme_dir = "theme/".THEME;
        return "$theme_dir/css/style.css";
    }

    function ML_themeDirectory() {
        $theme_dir = "theme/".THEME;
        return $theme_dir;
    }
?>