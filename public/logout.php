<?php
session_start();
if(isset($_SESSION["username"])){
    $_SESSION = array();
    $_COOKIE = array();
    session_destroy();  
    header("Location: index.php");
    
}else header("Location: login.php");
?>