<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

// to detect where user come from and decide whre to redirect him
include "App/Http/Middlewares/Guest.php";
define('FORGETPASSWORDPAGE', 1);
define('REGISTERPAGE', 2);

$title = "Verification";
require_once "./layouts/header.php";
if (!($_GET && isset($_GET['redirect']) && is_numeric($_GET['redirect']) && ($_GET['redirect'] == FORGETPASSWORDPAGE || $_GET['redirect'] == REGISTERPAGE))) {
    header('location:404.php');
    die;
}

if ($_GET['redirect'] == FORGETPASSWORDPAGE && !isset($_SESSION['verication_email'])) { //check if there is email in session
    header('location:forget-password.php');
    die;
}

if ($_GET['redirect'] == REGISTERPAGE && !isset($_SESSION['verication_email'])) { //check if there is email in session
    header('location:register.php');
    die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST) {
    $validate = new Validation;
    $validate->setValueName("Code")->setValue($_POST["verification"])->required()->digits(6);
    if (empty($validate->getErrors())) {
        // check if the code is correct
        $user = new User;
        $user->setEmail($_SESSION['verication_email']);
        $user->setVerification_code($_POST["verification"]);
        $verificationResult = $user->checkVerifiedCode();
        if ($verificationResult) {
            if ($verificationResult->num_rows == 1) {
                if ($_GET['redirect'] == REGISTERPAGE) {
                    $user->setEmail_verified_at(Date("Y-m-d H:i:s"));
                    $user->makeUserVirified();
                    header('location:login.php');
                    die;
                } else if ($_GET['redirect'] == FORGETPASSWORDPAGE) {
                    header('location:reset-password.php');
                }
            } else {
                $error = "<div class='alert alert-danger' role='alert'> Invalid Code </div>";
            }
        } else {
            $error = "<div class='alert alert-danger' role='alert'> Something went wrong </div>";
        }
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
                            <h4> Verification Code Send, Check your inbox </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <?= $error ?? "" ?>
                                        <input type="number" name="verification" placeholder="Verification Code">
                                        <?= isset($validate) ? $validate->getMessage("Code") : "" ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Check</span></button>
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
require_once "./layouts/scripts.php";
?>