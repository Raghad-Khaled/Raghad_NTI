<?php 
$title="Bank";
include_once "layout/header.php" ?>

<div class="container">
    <form style="width: 500px;" class="mx-auto mt-5" method="POST">
        <h1 class="text-primary text-center mb-5">Bank</h1>
        <!------------------------------ first part ------------------------->
        <div class="form-group">
            <label for="name">Your Name</label>
            <input id="name" class="form-control" name="username"  type="text" placeholder="ex: Raghad" value="<?=$_POST["username"]?? "" ?>" required/>    
        </div>
        <div class="form-group">
             <label for="name">Loan in EGP</label>
            <input id="name" class="form-control" name="loan"  type="number" placeholder="ex: 3000" value="<?=$_POST["loan"]?? "" ?>" required/>
        </div>
        <div class="form-group">
            <label for="products">Number of years to be paid in</label>
            <input id="products" class="form-control"  name="years" value="<?=$_POST["years"]?? "" ?>" type="number" placeholder="ex: 3" required />
        </div>
        <button type="submit" name="add" class="btn btn-primary btn-lg btn-block mb-5">Get monthly installment</button>
    </form>
    <?php if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST && isset($_POST["add"]) &&
     isset($_POST["loan"]) && isset($_POST["years"]) && isset($_POST["username"])){ 
        $total=0;
        if($_POST["years"]<=3){
            $total=$_POST["loan"] *.1 *$_POST["years"] + $_POST["loan"] ;
        }else{
            $total=$_POST["loan"] *.15 *$_POST["years"] + $_POST["loan"] ;
        }
        $permonth=$total/(12*$_POST["years"]);
        ?>
        <table class="table table-striped">
                <tbody>
                     <tr>
                        <th> Client Name </th>  
                        <th> <?=$_POST["username"]?> </th>        
                    </tr>
                    <tr>
                        <th> Total  installment </th>  
                        <th> <?=$total?> </th>        
                    </tr>
                    <tr class="h5 text-success">
                        <th> Monthly installment </th>  
                        <th> <?=$permonth?> </th>        
                    </tr>
                </tbody>
            </table>

    <?php }?>
</div>

<?php include_once "layout/scripts.php" ?>