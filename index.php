<?php
  session_start();
  $db_host = '127.0.0.1:3306';
  $db_username = 'root';
  $db_password = '';
  $db_name = 'st_project';
  $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet", href="index.css">
    <title>Online Grocery Ordering System</title>
  </head>
  <body>

    <div class="container mt-3">
      <div class="row">
        <div class = "col-4">
          <a href="index.php"><img src="images/logo.jpg" height="120", width="300"></a>
        </div>
        <div class = "col">
          <div id="searchbox">
            <form class="form-inline my-2 my-lg-0" action="items.php" method="post">
              <input name="search-value" class="form-control" type="search" placeholder="Search" aria-label="Search" size="60">
              <button name="search" class="btn btn-outline-success my-2 my-sm-0" type="submit"><ion-icon name="search-outline" style="padding-top:3px"></ion-icon></button>
            </form>
          </div>
        </div>
        <div class = "col-2" id="my-cart">
          <a class="btn btn-warning" href="cart.php"><div class="text-center">My Cart</div> <ion-icon name="cart-outline" size="large"></ion-icon></a>
        </div>
      </div>
    </div>
    <div class="container mt-2">
      <div class="row">
        <div class="col">
          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              SHOP BY CATEGORY
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <?php
                if($conn){
                  $sql = "SELECT DISTINCT main FROM category";
                  $result = mysqli_query($conn,$sql);
                  while($row = mysqli_fetch_assoc($result)) { ?>
                    <a class="dropdown-item" href="items.php?category=<?php echo $row['main']; ?>"><?php echo $row['main']; ?></a>
                  <?php }
                }
              ?>
            </div>
          </div>
        </div>
        <div class="col text-right">
        <?php 
          if (isset($_SESSION['username'])) {
            $url1 = "#";
            $name1 = $_SESSION['username'];
            $url2 = "logout.php";
            $name2 = "Logout";
          }
          else {
            $url1 = "login.php";
            $name1 = "Login";
            $url2 = "signup.php";
            $name2 = "Signup";
          }
        ?>
        <a href="<?php echo $url1 ?>", class="mr-3"><?php echo $name1 ?></a>|
        <a href="<?php echo $url2 ?>", class="ml-3"><?php echo $name2 ?></a>
        </div>
      </div>
    </div>
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="container-fluid">
          <div id="discountcarousel" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#discountcarousel" data-slide-to="0" class="active"></li>
                <li data-target="#discountcarousel" data-slide-to="1"></li>
                <li data-target="#discountcarousel" data-slide-to="2"></li>
                <li data-target="#discountcarousel" data-slide-to="3"></li>
              </ol>
              <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img src="images/discount1.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                      <img src="images/discount2.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                      <img src="images/discount3.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                      <img src="images/discount4.png" class="d-block w-100" alt="...">
                    </div>
              </div>
                <a class="carousel-control-prev" href="#discountcarousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#discountcarousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
          </div>
        </div>
      </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>Fruits and Vegetables</h3>
            </div>
          </div>
          <div class="row mt-3 border">
            <div class="col-6 border-right">
              <a href="items.php?category=Organic Store"><img src="images/fv1.png" width="540"></a>
            </div>
            <div class="col-3 border-right">
              <div class="border-bottom pb-3"><a href="items.php?category=Fresh Fruits"><img src="images/fv2.png" width="260"></a></div>
              <a href="items.php?category=Herbs and Seasoning"><img src="images/fv4.png" width="260"></a>
            </div>
            <div class="col-3" >
              <div class="border-bottom pb-3"><a href="items.php?category=Fresh Vegetables"><img src="images/fv3.png" width="260"></a></div>
              <a href="items.php?category=Exotic Fruits and Veggies"><img src="images/fv5.png" width="260"></a>
            </div>
          </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>Your Daily Staples</h3>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-3">
              <div class="border"><a href="items.php?category=Atta and Flour"><img src="images/ds1.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Rice and Rice Products"><img src="images/ds2.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Edible Oils and Ghee"><img src="images/ds3.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Salt, Sugar and Jaggery"><img src="images/ds4.png" width="250"></a></div>
            </div>
          </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>T20 Snack Store - up to 40% off</h3>
            </div>
          </div>
          <div class="row mt-3 border">
            <div class="col-6 border-right">
              <a href="items.php?category=Snacks and Namkeens"><img src="images/t201.png" width="540"></a>
            </div>
            <div class="col-3 border-right">
              <div class="border-bottom pb-3"><a href="items.php?category=Biscuits and Cookies"><img src="images/t202.png" width="260"></a></div>
              <a href="items.php?category=Chocolates and Candies"><img src="images/t204.png" width="260"></a>
            </div>
            <div class="col-3" >
              <div class="border-bottom pb-3"><a href="items.php?category=Frozen Veggies and Snacks"><img src="images/t203.png" width="260"></a></div>
              <a href="items.php?category=Indian Mithai"><img src="images/t205.png" width="260"></a>
            </div>
          </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>Drinks & Beverages</h3>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-3">
              <div class="border"><a href="items.php?category=Tea"><img src="images/db1.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Coffee"><img src="images/db2.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Fruit Juices and Drinks"><img src="images/db3.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Health Drink, Supplement"><img src="images/db4.png" width="250"></a></div>
            </div>
          </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>Cleaning & Household</h3>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-3">
              <div class="border"><a href="items.php?category=Detergents and Dishwash"><img src="images/ch1.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=All Purpose Cleaners"><img src="images/ch2.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=All Purpose Cleaners"><img src="images/ch3.png" width="250"></a></div>
            </div>
            <div class="col-3">
              <div class="border"><a href="items.php?category=Fresheners and Repellents"><img src="images/ch4.png" width="250"></a></div>
            </div>
          </div>
    </div>
    <div class="container mt-5">
          <div class="row">
            <div class="col text-center border-bottom">
              <h3>Beauty and Hygiene</h3>
            </div>
          </div>
          <div class="row mt-3 border">
            <div class="col-6 border-right">
              <a href="items.php?category=Skin Care"><img src="images/bh1.png" width="540"></a>
            </div>
            <div class="col-3 border-right">
              <div class="border-bottom pb-3"><a href="items.php?category=Makeup"><img src="images/bh2.png" width="260"></a></div>
              <a href="items.php?category=Bath and Hand Wash"><img src="images/bh4.png" width="260"></a>
            </div>
            <div class="col-3" >
              <div class="border-bottom pb-3"><a href="items.php?category=Fragrances and Deos"><img src="images/bh3.png" width="260"></a></div>
              <a href="items.php?category=Feminine Hygiene"><img src="images/bh5.png" width="260"></a>
            </div>
          </div>
    </div>
    <div class="jumbotron jumbotron-fluid mt-5">
      <div class="container">
        <h1 class="display-4">Software Tools - III Project</h1>
        <p class="lead">Made by :<br>U18CO003 - Aditya Dabhi<br>U18CO004 - Kashyap Soni</p>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>