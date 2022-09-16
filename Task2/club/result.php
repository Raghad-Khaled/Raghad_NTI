<?php
session_start();
include_once "typegames.php";
if(!($_SERVER["REQUEST_METHOD"]=="POST" && $_POST)){
    header('Location: games.php');
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
                    <th scope="col">Subscriber</th>
                    <th scope="col"><?=$_SESSION['name']?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total_sports_price=0; 
            for ($i=0 ; $i < $_SESSION["familynum"] ;$i++) {
                $membergames=0;
                ?>
                <tr>
                    <th scope="row"><?=$_POST["names"][$i] ?></th>
                    <?php foreach ($_POST["member".$i] as $game) {
                        $membergames+=$games[$game];    // to get total price for the sports of one member 
                        $priceforclub[$game]+=$games[$game];  // to get total subscription price in each club
                        echo "<td>{$game}</td>";
                    } ?>
                    <td> <?= $membergames ?>  </td>
                </tr>
            <?php $total_sports_price+= $membergames; } ?>

            <tr>
                <th scope="row">total Price</th>
                <td><?=$total_sports_price?> </td>
            </tr>

            </tbody>
        </table>

        <h1 class="text-primary mb-5 text-center">Sports</h1>
        <table class="table table-striped">
            <tbody>
            <?php foreach ($priceforclub as $sport => $price) {?>
                <tr>
                    <th scope="row"><?=$sport?></th>
                    <td> <?= $price ?>  </td>
                </tr>
            <?php } ?>

            <tr>
                <th scope="row">Club subscribtion</th>
                <td><?=$_SESSION["familynum"] *2500 + 10000?> </td>
            </tr>

            <tr>
                <th scope="row">Final Price Price</th>
                <td><?=$_SESSION["familynum"] *2500 + 10000 + $total_sports_price?> </td>
            </tr>

            </tbody>
        </table>
        
</div>
<?php include_once "layout/scripts.php" ?>
