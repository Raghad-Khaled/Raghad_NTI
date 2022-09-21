<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
include "App/Http/Middlewares/Guest.php";
$title = "Login";
require_once "./layouts/header.php";
require_once "./layouts/navbar.php";
require_once "./layouts/breadcrumb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST) {
    $validate = new Validation;
    $validate->setValueName('Email')->setValue($_POST['email'] ?? "")->required()->regex("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i");
    $validate->setValueName('Password')->setValue($_POST['password'] ?? "")->required()->regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,23}$/");
    if (empty($validate->getErrors())) {
        $user = new User;
        $getUser = $user->setEmail($_POST['email'])->getbyEmail();
        if ($getUser->num_rows == 1) {
            $getUser = $getUser->fetch_object();
            if (password_verify($_POST['password'], $getUser->password)) {
                if (is_null($getUser->email_verified_at)) {  // email not verified
                    $_SESSION['verication_email'] = $_POST['email']; 
                    header('location:verification-code.php');  // go to verify 
                    die;
                } else {                                    
                    if(isset($_POST['remember-me'])){   // if remember me button clicked then save user email in the cookie
                        setcookie('remember_me',$_POST['email'],time() + 86400 * 30,'/');
                    }
                    $_SESSION['user'] = $getUser;
                    header('location:index.php');
                    die;
                }
            } else {
                $validationErorr = "<div class='alert alert-danger' role='alert'> Invalid Email or Password </div>";
            }
        } else { // can not select user by email
            $error = "<div class='alert alert-danger' role='alert'> Something went wrong </div>";
        }
    } else {
        $validationErorr = "<div class='alert alert-danger' role='alert'> Invalid Email or Password </div>";
    }
}
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="text" name="email" placeholder="Email">
                                        <input type="password" name="password" placeholder="Password">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input name="remember-me" type="checkbox">
                                                <label>Remember me</label>
                                                <a href="forget-password.php">Forgot Password?</a>
                                            </div>
                                            <?= $validationErorr ?? "" ?>
                                            <button type="submit"><span>Login</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "./layouts/footer.php";
require_once "./layouts/scripts.php";
?>