<?php 
$title="Super Market";
$delivery=[
"cairo"=>0,
"giza"=>30,
"alex"=>50,
"other"=>100
];
include_once "layout/header.php" ?>

<div class="container">
    <form style="width: 500px;" class="mx-auto mt-5" method="POST">
        <h1 class="text-primary text-center mb-5">Super Market</h1>
        <!------------------------------ first part ------------------------->
        <div class="form-group">
            <label for="name">Your Name</label>
            <input id="name" class="form-control" name="username"  type="text" placeholder="ex: Raghad" value="<?=$_POST["username"]?? "" ?>" />    
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">City</label>
            <select name="city" value="<?=$_POST["city"]?? "cairo"?>"  class="form-control" id="exampleFormControlSelect2">
            <option value="cairo">cairo</option>
            <option value="giza">Giza</option>
            <option value="alex" >Alex</option>
            <option value="other">Ohter</option>
            </select>
        </div>
        <div class="form-group">
            <label for="products">Number of products</label>
            <input id="products" class="form-control"  name="num" value="<?=$_POST["num"]?? "" ?>" type="number" placeholder="ex: 3" required />
        </div>
        <button type="submit" name="add" class="btn btn-primary btn-lg btn-block mb-5">Enter products</button>

        <!------------------------------ Second part ------------------------->

        <?php if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST && isset($_POST["add"]) && !isset($_POST["bill"]) ){ ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quentities</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=0;$i<$_POST["num"];$i++) { ?>
                        <tr>
                            <td>
                            <input class="form-control" name=<?="pname".$i?> value="<?=$_POST["pname".$i]?? ""?>"  type="text" />
                            </td>
                            <td>
                            <input class="form-control" name=<?="price".$i?> value="<?=$_POST["price".$i]?? ""?>"  type="number" />
                            </td>
                            <td>
                            <input class="form-control" name=<?="quen".$i?> value="<?=$_POST["quen".$i]?? ""?>" name=<?="quen".$i?> type="number" />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="bill" class="btn btn-primary btn-lg btn-block mb-5">Get Bill</button>
        <?php } ?>

        <!------------------------------ Third part ------------------------->
        <?php if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST && isset($_POST["bill"]) ){
            $total=0;
            ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quentities</th>
                    <th scope="col">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0;$i<$_POST["num"];$i++) {
                     $total+= $_POST["price".$i] * $_POST["price".$i];
                    ?>
                    <tr>
                        <td> <?=$_POST["pname".$i]?? ""?> </td>
                        <td> <?=$_POST["price".$i]?? ""?> </td>
                        <td> <?=$_POST["quen".$i]?? ""?> </td>
                        <td> <?=$_POST["quen".$i]*$_POST["price".$i]?? ""?> </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="h6"> Client Name </td>
                    <td> <?=$_POST["username"]?? ""?>  </td>
                </tr>
                <tr>
                    <td class="h6"> City </td>
                    <td> <?=$_POST["city"]?? ""?>  </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="h6"> Total </td>
                    <td> <?=$total?>  </td>
                </tr>
                <?php
                $discount=0;
                if($total>4500){
                    $discount=$total*.2;
                }elseif($total>3000){
                    $discount=$total*.15;
                }
                elseif($total>1000){
                    $discount=$total*.1;
                }
                ?>
                <tr>
                    <td class="h6"> Discount </td>
                    <td> <?=$discount?>  </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="h6"> Total after Discount </td>
                    <td> <?=$total-$discount?>  </td>
                </tr>

                <tr>
                    <td class="h6"> Delivery </td>
                    <td> <?=$delivery[$_POST["city"]]?>  </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="h5 text-success">
                    <td> Nex Total </td>
                    <td> <?=$total-$discount+$delivery[$_POST["city"]] ?>  </td>
                </tr>

            </tbody>
        </table>
        <?php } ?>
    </form>
</div>

<?php include_once "layout/scripts.php" ?>