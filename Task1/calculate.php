<?php if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST){ 
                if(isset($_POST["add"])){
                    $result=$_POST["number1"]." + ".$_POST["number2"]. " = " .$_POST["number1"]+$_POST["number2"];
                }elseif(isset($_POST["sub"])){
                    $result=$_POST["number1"]." - ".$_POST["number2"]. " = " .$_POST["number1"]-$_POST["number2"];
                }elseif(isset($_POST["div"])){
                    $result=$_POST["number1"]." / ".$_POST["number2"]. " = " .$_POST["number1"]/$_POST["number2"];
                }elseif(isset($_POST["mul"])){
                    $result=$_POST["number1"]." * ".$_POST["number2"]. " = " .$_POST["number1"]*$_POST["number2"];
                }elseif(isset($_POST["power"])){
                    $result=$_POST["number1"]." ** ".$_POST["number2"]. " = " .pow($_POST["number1"],$_POST["number2"]);
                }
            }
        ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid" >
    <form  style="width: 500px;" class="mx-auto mt-5"  method="POST">
        <h1 class="text-primary">Your Calculator</h1>
        <div class="form-group">
          <label for="exampleInputEmail1">Enter first number</label>
          <input id="number1" class="form-control" name="number1" type="number"  placeholder="ex: 4" required/>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Enter secoend number</label>
          <input id="number2" class="form-control" name="number2" type="number" placeholder="ex: 2" required/>
        </div>
        <button type="submit" name="add" class="btn btn-primary">+</button>
        <button type="submit" name="sub" class="btn btn-primary">-</button>
        <button type="submit" name="div" class="btn btn-primary">/</button>
        <button type="submit" name="mul" class="btn btn-primary">*</button>
        <button type="submit" name="power" class="btn btn-primary">**</button>
    </form>
    <div style="width: 500px;" class="mx-auto mt-5">

    <div class="mx-auto" style="width: 500px;" >
        <div class="alert alert-primary" role="alert">
             <?= $result?? "" ?>
        </div>
                
    </div>

    </div>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>