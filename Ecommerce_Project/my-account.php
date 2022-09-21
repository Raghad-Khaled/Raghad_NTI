<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
use App\Services\Media;

include "App/Http/Middlewares/Auth.php";
$title = 'my account';
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
if (isset($_POST['update-image'])) {
    if ($_FILES['image']['error'] == 0) { // no errors
        $media = new Media;
        $media->setFile($_FILES['image']);
        $media->size(1024 ** 2)->extension(['png', 'jpg', 'jpeg']);
        if (empty($media->getErrors())) {  // all validations are okay
            if ($media->upload('assets/img/users/')) {
                if ($_SESSION['user']->image != 'default.jpg') {
                    $media->delete('assets/img/users/' . $_SESSION['user']->image);
                }
                $user = new User;
                $user->setImage($media->getFileName())->setEmail($_SESSION['user']->email);
                if ($user->updateImage()) {
                    $_SESSION['user']->image = $media->getFileName();
                } else {
                    $error = "<div class='alert alert-danger' role='alert'>Something want wrong, Please try again </div>";
                }
            } else {
                $error = "<div class='alert alert-danger' role='alert'> Can not Upload image, Please try again </div>";
            }
        }
    } else {
        $error = "<div class='alert alert-danger' role='alert'> Please select image to be upload </div>";
    }
}
if (isset($_POST['update-data'])) {
    $validate = new Validation;
    $validate->setValueName('First Name')->setValue($_POST['fname'] ?? "")->required()->isstring()->between(2, 32);
    $validate->setValueName('Last Name')->setValue($_POST['lname'] ?? "")->required()->isstring()->between(2, 32);
    $validate->setValueName("Gender")->setValue($_POST['gender'] ?? "")->required()->in(["m", "f"]);
    if (empty($validate->getErrors())) { // no validation errors
        $user = new User;
        $user->setEmail($_SESSION['user']->email)->setFirst_name($_POST['fname'])->setLast_name($_POST['lname'])->setGender($_POST['gender']);
        if ($user->updateData()) { //update database
            // update sessions
            $_SESSION['user']->first_name = $_POST['fname'];
            $_SESSION['user']->last_name = $_POST['lname'];
            $_SESSION['user']->gender = $_POST['gender'];
        } else {
            $dataerror = "<div class='alert alert-danger' role='alert'>Something want wrong, Please try again </div>";
        }
    }
}

if (isset($_POST['update-password'])) {
    $validatepassword = new Validation;
    $validatepassword->setValueName("Old Password")->setValue($_POST['oldpassword'] ?? "")->required()->regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,23}$/");
    $validatepassword->setValueName('Password')->setValue($_POST['password'] ?? "")->required()->confirmed($_POST["confirmpassword"])->regex(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,23}$/",
        "password should has Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character"
    );
    $validatepassword->setValueName("Confirme Password")->setValue($_POST['confirmpassword'] ?? "")->required();
    if (empty($validatepassword->getErrors())) { // no validation errors
        $user = new User;
        $getUser = $user->setEmail($_SESSION['user']->email)->getbyEmail();
        if ($getUser->num_rows == 1) {
            $getUser = $getUser->fetch_object();
            if (password_verify($_POST['oldpassword'], $getUser->password)) {
                if ($user->setPassword($_POST['password'])->updatePassword()) {
                    $sucsessmessage = "<div class='alert alert-success w-100' role='alert'> Password sucsessfuly updated  </div>";
                } else {
                    $validationErorr = "<div class='alert alert-danger' role='alert'> Something went wrong </div>";
                }
            } else {
                $validationErorr = "<div class='alert alert-danger' role='alert'> Wrong Old password </div>";
            }
        } else { // can not select user by email
            $validationErorr = "<div class='alert alert-danger' role='alert'> Something went wrong </div>";
        }
    }
}
?>
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="message" class="login-register-tab-list nav">
                        <?= $sucsessmessage ?? "" ?>
                    </div>
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit Your Image </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="row">
                                            <div class="col-4 offset-4">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <?= $error ?? "" ?>
                                                    <?php
                                                    if ($_SESSION['user']->image == 'default.png') {
                                                        if ($_SESSION['user']->gender == 'm') {
                                                            $image = 'male.jpg';
                                                        } else {
                                                            $image = 'female.jpg';
                                                        }
                                                    } else {
                                                        $image = $_SESSION['user']->image;
                                                    }
                                                    ?>
                                                    <label for="file">
                                                        <img class="w-100" style="cursor:pointer" id="image" src="assets/img/users/<?= $image ?>" alt="userimage">
                                                    </label>
                                                    <input type="file" onchange="loadFile(event)" name="image" id="file" class="d-none form-control">
                                                    <button name="update-image" style="cursor:pointer" class="btn btn-success rounded form-control"><i class="fa fa-camera" aria-hidden="true"></i></button>
                                                    <?php
                                                    if (isset($media)) {
                                                        foreach ($media->getErrors() as $error) {
                                                            echo $media->getMessage($error);
                                                        }
                                                    }
                                                    ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Edit your Data </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Edit your Data</h4>
                                        </div>
                                        <form method="POST">
                                            <?= $dataerror ?? "" ?>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="fname" value="<?= $_SESSION['user']->first_name ?>">
                                                        <?= isset($validate) ? $validate->getMessage("First Name") : "" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text" name="lname" value="<?= $_SESSION['user']->last_name ?>">
                                                        <?= isset($validate) ? $validate->getMessage("Last Name") : "" ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Gender</label>
                                                        <select name="gender" id="" class="form-control">
                                                            <option <?= $_SESSION['user']->gender == 'm' ? 'selected' : '' ?> value="m">Male</option>
                                                            <option <?= $_SESSION['user']->gender == 'f' ? 'selected' : '' ?> value="f">Female</option>
                                                        </select>
                                                    </div>
                                                    <?= isset($validate) ? $validate->getMessage("Gender") : "" ?>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button name="update-data" type="submit">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3"> Change Password </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                        </div>
                                        <form method="POST">
                                            <?= $validationErorr ?? "" ?>
                                            <?= $sucsessmessage ?? "" ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>your Password</label>
                                                        <input name="oldpassword" type="password">
                                                        <?= isset($validatepassword) ? $validatepassword->getMessage("Old Password") : "" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Password</label>
                                                        <input name="password" type="password">
                                                        <?= isset($validatepassword) ? $validatepassword->getMessage("Password") : "" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password Confirm</label>
                                                        <input name="confirmpassword" type="password">
                                                        <?= isset($validatepassword) ? $validatepassword->getMessage("Confirme Password") : "" ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">

                                                <div class="billing-btn">
                                                    <button name="update-password" type="submit">

                                                        Change
                                                    </button>
                                                </div>
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
</div>
<?php
include "layouts/footer.php";
include "layouts/scripts.php";

?>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    setTimeout(function() {
        document.getElementById("message").innerHTML = '';
    }, 3000);
</script>