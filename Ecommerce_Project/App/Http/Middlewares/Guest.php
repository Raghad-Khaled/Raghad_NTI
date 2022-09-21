<?php 
// allow guests
// prevent authenticated
if(isset($_SESSION['user'])){
    header('location:index.php');die;
}