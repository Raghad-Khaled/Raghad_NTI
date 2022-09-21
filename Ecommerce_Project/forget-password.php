<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
use Mail\VerificationCodeMail;
include "App/Http/Middlewares/Guest.php";
$title = "Verification";
require_once "./layouts/header.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST) {
    $validate = new Validation;
    $validate->setValueName("Email")->setValue($_POST["email"])->required()->regex("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i");
    if (empty($validate->getErrors())) { // no validation error on email
        // check if the Email is Exist
        $user = new User;
        $user->setEmail($_POST['email']);
        $selecteduser = $user->getbyEmail();
        if ($selecteduser->num_rows == 1) {
            //generate code & store it in database
            $verfication_code = rand(100000, 999999); //generate random 6 digits code
            $user->setVerification_code($verfication_code);
            if ($user->updateVerificationCode()) {
                // $verificationMail = new VerificationCodeMail;
                // $messageBody = "<h1>Your Verification Code</h1> <h2>{$verfication_code}</h2>";
                // $subject = "Verification Code";
                // if ($verificationMail->send($_POST['email'], $messageBody, $subject)) {
                $_SESSION['verication_email'] = $_POST['email'];
                header('location:verification-code.php?redirect=1');
                die;
                // } else {
                //     $error = "<div class='alert alert-danger' role='alert'> Something want Wrong, Please try again </div>";
                // }

            }else{
                $error = "<div class='alert alert-danger' role='alert'> Something want Wrong, Please try again </div>";
            }
        } else {
            $error = "<div class='alert alert-danger' role='alert'> Wrong Eamil </div>";
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
                            <h4> Enter Your Email to Reset your password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <?= $error ?? "" ?>
                                        <input type="email" name="email" placeholder="Your Email">
                                        <?= isset($validate) ? $validate->getMessage("Email") : "" ?>
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