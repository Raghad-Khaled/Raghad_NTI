<?php
session_start();
include_once "questions.php";
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST){ 
    $totalscore=0;
    foreach ($questions as $key => $question) {
        if(isset($_POST["question".$key]))
            $totalscore+= $score [$_POST["question".$key]];
        else{
            header('Location: review.php');
            die;
        }    
    }
}else{
    header('Location: review.php');
    die;
}
$title="Result";
include_once "layout/header.php"
?>

<div class="container mx-auto mt-5">
    <h1 class="text-primary mb-5 text-center">Result</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Questions</th>
                    <th scope="col">Reviews</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $key => $question) { ?>
                <tr>
                    <th scope="row"><?= $question ?></th>
                    <td>
                        <?= $_POST["question".$key] ?>
                    </td>
                </tr>
            <?php } ?>

            <tr class="h3">
                <th scope="row">Total Review</th>
                <td class=<?=$totalscore>25? "text-success":"text-danger"?>> <?=$totalscore>25? "Good":"Bad" ?></td>
            </tr>
            </tbody>
        </table>
        
        <?php if($totalscore >25){ 
            echo "<div class='alert alert-primary' role='alert'>
                    Thank You
                </div> ";
        }else{
            echo "<div class='alert alert-danger' role='alert'>
                Sorry for You, We will call you later on this phone :{$_SESSION["phone"]}
                </div> ";
        }?>
            

</div>
<?php include_once "layout/scripts.php" ?>
