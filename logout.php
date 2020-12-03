<?php
    session_start();
    if(isset($_COOKIE['cartproducts'])){
        unset($_COOKIE['cartproducts']);
        setcookie('cartproducts',null,-1,"/");
    }
    session_unset();
    session_destroy();
    header("location: index.php");
?>