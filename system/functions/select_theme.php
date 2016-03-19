<?php
/**
 * Function for selecting theme
 */
function select_theme() {
    if(isset($_POST['switch_theme'])) {
        $requested_file = __THEMES_DIR__ . "/${_POST['switch_theme']}/theme.php";
        if(file_exists($requested_file)) {
            $_SESSION['theme'] = $_POST['switch_theme'];
        }
    }
    if(!isset($_SESSION['theme'])) {
        $_SESSION['theme'] = Config::get("themes_default");
    }
}
