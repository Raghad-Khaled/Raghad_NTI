<!-- header start -->
<?php

use App\Database\Models\Category;
use App\Database\Models\Subcategory;

$categoryObject = new Category;
$categories = $categoryObject->read()->fetch_all(MYSQLI_ASSOC);

$subcategoryObject = new Subcategory;

?>
<header class="header-area gray-bg clearfix">
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="logo">
                        <a href="index.html">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-6">
                    <div class="header-bottom-right">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="top-hover"><a href="index.php">home</a></li>
                                    <li><a href="about-us.html">about</a></li>
                                    <li class="mega-menu-position top-hover"><a href="shop.php">shop</a>
                                        <ul class="mega-menu">
                                            <?php foreach ($categories as $category) {
                                                $subcategoryObject->setCategory_id($category['id']);
                                                $subcategories = $subcategoryObject->getSubByCat()->fetch_all(MYSQLI_ASSOC);
                                            ?>
                                                <li>
                                                    <ul>
                                                        <li><a href="shop.php?category=<?= $category['id'] ?>" class="font-weight-bold"><?= $category['name_en'] ?></a></li>
                                                        <?php foreach ($subcategories as $subcategory) { ?>
                                                            <li><a href="shop.php?subcategory=<?= $subcategory['id'] ?>"><?= $subcategory['name_en'] ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>

                                    <li><a href="contact.html">contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <div class="header-currency">
                                <span class="digit"> <?= $_SESSION['user']->first_name ?> <i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="my-account.php"> My Acount</a></li>
                                        <li><a href="logout.php">Logout</a></li>

                                    </ul>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="header-currency">
                                <span class="digit"> Welcome <i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="login.php"> Log In</a></li>
                                        <li><a href="register.php">Register </a></li>

                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="header-cart">
                            <a href="#">
                                <div class="cart-icon">
                                    <i class="ti-shopping-cart"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow">
                            <li><a href="index.php">HOME</a></li>
                            <li class="mega-menu-position top-hover"><a href="shop.php">shop</a>
                                <ul class="mega-menu">
                                    <?php foreach ($categories as $category) {
                                        $subcategoryObject->setCategory_id($category['id']);
                                        $subcategories = $subcategoryObject->getSubByCat()->fetch_all(MYSQLI_ASSOC);
                                    ?>
                                        <li>
                                            <ul>
                                                <li><a href="shop.php?category=<?= $category['id'] ?>" class="font-weight-bold"><?= $category['name_en'] ?></a></li>
                                                <?php foreach ($subcategories as $subcategory) { ?>
                                                    <li><a href="shop.php?subcategory=<?= $subcategory['id'] ?>"><?= $subcategory['name_en'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li><a href="contact.html"> Contact us </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>