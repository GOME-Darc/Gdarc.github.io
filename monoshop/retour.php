<?php 

session_start();

if(isset($_SESSION['Gomedarc2003@'])){

    $_SESSION['Gomedarc2003@']= array();

    session_destroy();

    header("Location: ../");
 
}else{
    header("Location: index.php");
}

?>
