<?php
include "App/Http/Middlewares/Guest.php";
$title = "Reset Password";
require_once "./layouts/header.php";

use App\Database\Models\User;
use App\Http\Requests\Validation;
use Mail\VerificationCodeMail;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST) {
    $validate = new Validation;
    $validate->setValueName('Password')->setValue($_POST['password'] ?? "")->required()->confirmed($_POST["confirmpassword"])->regex(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,23}$/",
        "password should has Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character"
    );
    $validate->setValueName("Confirme Password")->setValue($_POST['confirmpassword'] ?? "")->required();

    if (empty($validate->getErrors())) {
        $user = new User;
        $user->setPassword($_POST['password'])->setEmail($_SESSION["verication_email"]);

        if ($user->updatePassword()) {
            $sucsessmessage = "<div class='alert alert-success w-100' role='alert'> Password Reset Sucssefuly,  You will be Redirect to LogIn </div>";
            header('refresh:5; url=login.php');
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
                            <h4> Reset Password </h4>
                        </a>
                        <?= $sucsessmessage ?? "" ?>
                    </div>
                    <div id="lg2" class="tab-pane active">
                        <div class="login-form-container">
                            <div class="login-register-form">
                                <form method="post">
                                    <?= $error ?? "" ?>
                                    <input type="password" name="password" placeholder="Password">
                                    <?= isset($validate) ? $validate->getMessage("Password") : "" ?>

                                    <input type="password" name="confirmpassword" placeholder="Confirm password">
                                    <?= isset($validate) ? $validate->getMessage("Confirme Password") : "" ?>

                                    <div class="button-box">
                                        <button type="submit"><span>Reset</span></button>
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