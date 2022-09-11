<?php
session_start();
include_once "questions.php";
if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST && isset($_POST["phone"])){ 
    $_SESSION["phone"] = $_POST["phone"];
}else{
    header('Location: number.php');
    die;
}
$title="Review";
include_once "layout/header.php"
?>

<div class="container">
    <form  class="mx-auto mt-5" action="result.php" method="POST">
    <h1 class="text-primary mb-5 text-center">Review</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Questions</th>
                    <th scope="col">Bad</th>
                    <th scope="col">Good</th>
                    <th scope="col">Very Good</th>
                    <th scope="col">Excelant</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $key => $question) { ?>
                <tr>
                    <th scope="row"><?= $question ?></th>
                    <td>
                        <div class="form-check">
                            <input type="radio" value="Bad" class="form-check-input" name=<?="question".$key?> required >
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="radio" value="Good" class="form-check-input" name=<?="question".$key?> >
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="radio" value="Very Good" class="form-check-input" name=<?="question".$key?> >
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="radio" value="Excelant" class="form-check-input" name=<?="question".$key?> >
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Result</button>
    </form>
</div>

<?php include_once "layout/scripts.php" ?>