<?php
session_start();
include_once "typegames.php";
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST && isset($_POST["name"]) && isset($_POST["familynum"]) ){ 
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["familynum"] = $_POST["familynum"];
}else{
    header('Location: subscribe.php');
    die;
}
$title="Games";
include_once "layout/header.php"
?>

<div class="container">
    <form  class="mx-auto mt-5" action="result.php" method="POST">
    <h1 class="text-primary mb-5 text-center">Add Games to each member</h1>
    <?php for ($i=0 ; $i < $_SESSION["familynum"] ;$i++) { ?>
        <h4 class="text-primary mb-5 text-center">Member <?=$i+1?></h4>
        <input class="form-control" name="names[]" type="text" placeholder="ex: mbmber name" required />
        <?php foreach ($games as $key => $value) {
           echo "<div class='form-check'>
           <input type='checkbox' value='{$key}'  class='form-check-input' name='member{$i}[]'>
           <label class='form-check-label'>{$key} {$value} EL</label>
           </div>
           ";
        } } ?>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Result</button>
    </form>
</div>

<?php include_once "layout/scripts.php" ?>