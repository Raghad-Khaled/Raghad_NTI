<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
use Mail\VerificationCodeMail;

include "App/Http/Middlewares/Guest.php";
$title = "Register";
require_once "./layouts/header.php";
require_once "./layouts/navbar.php";
require_once "./layouts/breadcrumb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST) {
    $validate = new Validation;
    $validate->setOldValues($_POST);
    $validate->setValueName('First Name')->setValue($_POST['fname'] ?? "")->required()->isstring()->between(2, 32);
    $validate->setValueName('Last Name')->setValue($_POST['lname'] ?? "")->required()->isstring()->between(2, 32);
    $validate->setValueName('Email')->setValue($_POST['email'] ?? "")->required()->regex("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i")->unique('users', 'email');
    $validate->setValueName('Phone')->setValue($_POST['phone'] ?? "")->required()->regex("/^01[0125][0-9]{8}$/")->unique('users', 'phone');
    $validate->setValueName('Password')->setValue($_POST['password'] ?? "")->required()->confirmed($_POST["confirmpassword"])->regex(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,23}$/",
        "password should has Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character"
    );
    $validate->setValueName("Confirme Password")->setValue($_POST['confirmpassword'] ?? "")->required();
    $validate->setValueName("Gender")->setValue($_POST['gender'] ?? "")->required()->in(["m", "f"]);

    if (empty($validate->getErrors())) {
        $user = new User;
        $verfication_code = rand(100000, 999999); //generate random 6 digits code
        $user->setFirst_name($_POST['fname'])->setLast_name($_POST['lname'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setVerification_code($verfication_code);

        if ($user->create()) {
            // $verificationMail = new VerificationCodeMail;
            // $messageBody = "<h1>Your Verification Code</h1> <h2>{$verfication_code}</h2>";
            // $subject = "Verification Code";
            // if ($verificationMail->send($_POST['email'], $messageBody, $subject)) {
            $_SESSION['verication_email'] = $_POST['email'];
            header('location:verification-code.php?redirect=2');
            die;
            // } else {
            //     $error = "<div class='alert alert-danger' role='alert'> Please try again1 </div>";
            // }
        } else {
            $error = "<div class='alert alert-danger' role='alert'> Please try again </div>";
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
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div id="lg2" class="tab-pane active">
                        <div class="login-form-container">
                            <div class="login-register-form">
                                <form method="post">
                                    <?= $error ?? "" ?>
                                    <input type="text" value="<?= isset($validate) ? $validate->getOldValue("fname") : "" ?>" name="fname" placeholder="First Name">
                                    <?= isset($validate) ? $validate->getMessage("First Name") : "" ?>

                                    <input type="text" value="<?= isset($validate) ? $validate->getOldValue("lname") : "" ?>" name="lname" placeholder="Last Name">
                                    <?= isset($validate) ? $validate->getMessage("Last Name") : "" ?>

                                    <div class="form-group">
                                        <select class="form-control" name="gender" id="exampleFormControlSelect2">
                                            <option <?= isset($validate) && $validate->getOldValue("gender") == 'm' ? "selected" : "" ?> value="m">Male</option>
                                            <option <?= isset($validate) && $validate->getOldValue("gender") == 'f' ? "selected" : "" ?> value="f">Female</option>
                                        </select>
                                    </div>
                                    <?= isset($validate) ? $validate->getMessage("Gender") : "" ?>

                                    <input name="phone" value="<?= $_POST["phone"] ?? "" ?>" placeholder="Phone number" type="tel">
                                    <?= isset($validate) ? $validate->getMessage("Phone") : "" ?>

                                    <input name="email" value="<?= $_POST["email"] ?? "" ?>" placeholder="Email" type="email">
                                    <?= isset($validate) ? $validate->getMessage("Email") : "" ?>

                                    <input type="password" name="password" placeholder="Password">
                                    <?= isset($validate) ? $validate->getMessage("Password") : "" ?>

                                    <input type="password" name="confirmpassword" placeholder="Confirm password">
                                    <?= isset($validate) ? $validate->getMessage("Confirme Password") : "" ?>

                                    <div class="button-box">
                                        <button type="submit"><span>Register</span></button>
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