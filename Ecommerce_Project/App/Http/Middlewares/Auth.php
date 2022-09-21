<?php 
// allow authenticated
// prevent guests
if(! isset($_SESSION['user'])){
    header('location:login.php');die;
}