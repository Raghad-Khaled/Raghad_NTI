<?php if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST){ 
              $totalgrade=$_POST["physics"]+$_POST["chemistry"]+$_POST["biology"]+$_POST["mathematics"]+$_POST["computer"];
              $presentage=  ($totalgrade/500) *100;
              if($presentage>=90){
                $grade="A";
              }elseif($presentage>=80){
                $grade="B";
              }elseif($presentage>=70){
                $grade="C";
              }elseif($presentage>=60){
                $grade="D";
              }elseif($presentage>=40){
                $grade="E";
              }else{
                $grade="F";
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
        <h1 class="text-primary">   YOUR GRADE CALCULATOR </h1>
        <div class="form-group">
          <label for="physics">Physics grade</label>
          <input id="physics" class="form-control" name="physics" type="number"  step=any placeholder="out of 100" required/>
        </div>
        <div class="form-group">
          <label for="chemistry">Chemistry grade</label>
          <input id="chemistry" class="form-control" name="chemistry" type="number" step=any placeholder="out of 100" required/>
        </div>
        <div class="form-group">
          <label for="biology"> Biology grade</label>
          <input id="biology" class="form-control" name="biology" type="number" step=any placeholder="out of 100" required/>
        </div>
        <div class="form-group">
          <label for="mathematics">Mathematics grade</label>
          <input id="mathematics" class="form-control" name="mathematics" type="number" step=any placeholder="out of 100" required/>
        </div>
        <div class="form-group">
          <label for="computer">Computer grade</label>
          <input id="computer" class="form-control" name="computer" type="number" step=any placeholder="out of 100" required/>
        </div>
        <button type="submit" class="btn btn-primary">get my grades</button>
    </form>
    <div style="width: 500px;" class="mx-auto mt-5">

    <div class="mx-auto" style="width: 500px;" >

        <div class="alert alert-primary" role="alert">
            YOUR TOTAL GREAD= 
             <?= $totalgrade?? "your total grade" ?>
             /500
             <br>
             YOUR PRESENTAGE= 
             <?= $presentage?? "your presentage" ?>
             %
             <br>
             ==>>
             <?= $grade?? "" ?>
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