<?php 
$title="Register";
require_once "./layouts/header.php";
require_once "./layouts/navbar.php";
require_once "./layouts/breadcrumb.php";
use App\Http\Requests\Validation;
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST ){
    $validate=new Validation;
    $validate->setValueName('First Name')->setValue($_POST['fname'])->required()->isstring()->between(2,32);
    $validate->setValueName('Last Name')->setValue($_POST['lname'])->required()->isstring()->between(2,32);
    $validate->setValueName('Email')->setValue($_POST['email'])->required()->regex("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i")->unique('users','email');
    $validate->setValueName('Phone')->setValue($_POST['phone'])->required()->unique('users','phone');
    $validate->setValueName('Password')->setValue($_POST['password'])->required()->confirmed($_POST["confirmpassword"]);
    $validate->setValueName("Confirme Password")->setValue($_POST['confirmpassword'])->required();
    $validate->setValueName("Gender")->setValue($_POST['gender'])->required()->in(["m","f"]);

    if(empty($validate->getErrors())){
        echo "Okay";
    }else{
        print_r($validate->getErrors());
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
                                <form action="#" method="post">
                                    <input type="text" name="fname" placeholder="First Name">
                                    <?=isset($validate)? $validate->getMessage("First Name"):""?> 
                                    <input type="text" name="lname" placeholder="Last Name">
                                    <?=isset($validate)? $validate->getMessage("Last Name"):""?> 
                                    <div class="form-group">
                                        <select class="form-control" name="gender" id="exampleFormControlSelect2">
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </div>
                                    <?=isset($validate)? $validate->getMessage("Gender"):""?> 
                                    <input name="phone" placeholder="Phone number" type="tel">
                                    <?=isset($validate)? $validate->getMessage("Phone"):""?> 
                                    <input name="email" placeholder="Email" type="email">
                                    <?=isset($validate)? $validate->getMessage("Email"):""?> 
                                    <input type="password" name="password" placeholder="Password">
                                    <?=isset($validate)? $validate->getMessage("Password"):""?> 
                                    <input type="password" name="confirmpassword" placeholder="Confirm password">
                                    <?=isset($validate)? $validate->getMessage("Confirme Password"):""?> 
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