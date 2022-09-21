<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['verication_email']);
setcookie('remember_me', '', time() - 1, '/');

header("location: login.php");
