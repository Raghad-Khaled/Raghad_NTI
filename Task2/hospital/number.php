
<?php 
$title="Number";
include_once "layout/header.php" ?>
<div class="container-fluid">
    <form style="width: 500px;" class="mx-auto mt-5" action="review.php" method="POST">
        <h1 class="text-primary text-center mb-5">Hospital</h1>
        <div class="form-group">
            <label for="phone">Enter Your Phone Number</label>
            <input id="phone" class="form-control" name="phone" type="tel" placeholder="ex: 01110446420" required />
        </div>
        <button type="submit" name="add" class="btn btn-primary btn-lg btn-block">Submit</button>
    </form>
</div>

<?php include_once "layout/scripts.php" ?>

