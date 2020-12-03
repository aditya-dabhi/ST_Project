<?php 
    session_start();
    $db_host = '127.0.0.1:3306';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'st_project';
    $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
    if(isset($_GET['removeproduct'])){
      if(isset($_COOKIE['cartproducts'])){
        $cookie = stripslashes($_COOKIE['cartproducts']);
        $cartitems = json_decode($cookie,true);
        $modifiedcartitems = array(
          'username'=> $_SESSION['username'],
          'products'=> array()
        );
        foreach($cartitems['products'] as $product){
          if(strcmp($_GET['removeproduct'],$product[0])!=0){
            array_push($modifiedcartitems['products'],$product);
          }
        }
        setcookie("cartproducts",json_encode($modifiedcartitems), time()+86400, "/");
        header("location: cart.php");
      }
    }
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
    <title>Cart</title>
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
          <a class="btn btn-warning" href="#"><div class="text-center">My Cart</div> <ion-icon name="cart-outline" size="large"></ion-icon></a>
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
        <div class="col">
          <?php
            if(isset($_SESSION['username'])){
              $cookie = stripslashes($_COOKIE['cartproducts']);
              $cartitems = json_decode($cookie,true);
              if(sizeof($cartitems['products'])!=0){?>
                <a href="checkout.php" class="btn btn-warning">PROCEED TO CHECKOUT</a>
              <?php }
            }
          ?>
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
    <div class="container">
      <?php
        if(!isset($_SESSION['username'])){ ?>
          <div class="alert alert-danger mt-3" role="alert">
            Login to continue
          </div>
        <?php }
      ?>
    </div>
    <div class="container mt-5">
        <div class="row">
        <?php 
                if(isset($_SESSION['username'])){
                if(isset($_COOKIE['cartproducts'])){
                  $cookie = stripslashes($_COOKIE['cartproducts']);
                  $cartitems = json_decode($cookie,true);
                }
                if(sizeof($cartitems['products'])!=0){
                  for($i=0; $i<sizeof($cartitems['products']); $i++) {
                    $sql = 'SELECT * FROM product NATURAL JOIN subcategory NATURAL JOIN category';
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result)) { 
                      if (strcmp($cartitems['products'][$i][0],$row['name'])==0){?>
                          <div class="col-3">
                              <div class="card mb-5">
                                  <img class="card-img-top" src="images/product/<?php echo $row['name'];?>.jpg" height="200">
                                  <div class="card-body">
                                      <p class="card-subtitle text-muted"><?php echo $row['brand'] ?></p>
                                      <a href="product.php?productname=<?php echo $row['name']; ?>" class="text-success"><h5 class="card-title"><?php echo $row['name'] ?></h5></a>
                                      <p class="card-text">Quantity : <?php echo $row['quantity'] ?><br> Price: Rs <?php echo $row['price'] ?><br></p>
                                      <p class="card-text">Quantity bought : <?php echo $cartitems['products'][$i][1] ?><br> Total price : Rs <?php echo $row['price']*$cartitems['products'][$i][1] ?></p>
                                      <form class="form-group" action="cart.php?removeproduct=<?php echo $cartitems['products'][$i][0] ?>" method="post">
                                        <input class="btn btn-danger" type="submit" name="remove" value="Remove">
                                    </form>
                                  </div>
                              </div>
                          </div>
                      <?php }
                    } 
                  }
                  }
                  else { ?>
                    <div class="container">
                      <div class="alert alert-warning mt-3" role="alert">
                        Cart is empty.
                      </div>
                    </div>
                  <?php }
                } ?>
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