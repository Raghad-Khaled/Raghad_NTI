
<?php 
$title="Subscribe";
include_once "layout/header.php" ?>
<div class="container-fluid">
    <form style="width: 500px;" class="mx-auto mt-5" action="games.php" method="POST">
        <h1 class="text-primary text-center mb-5">Club</h1>
        <div class="form-group">
            <label for="name">Member Nane</label>
            <input id="name" class="form-control" name="name" type="text" placeholder="ex: Raghad" required />
            <small> Club subsscription start with 10.000EL </small>
        </div>
        <div class="form-group">
            <label for="num">Count of Family member</label>
            <input id="num" class="form-control" name="familynum" type="number" placeholder="ex: 4" required />
            <small> Cost of each member is 2.500EL  </small>
        </div>
        <button type="submit" name="add" class="btn btn-primary btn-lg btn-block">Submit</button>
    </form>
</div>

<?php include_once "layout/scripts.php" ?>