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
    <title>Hello, world!</title>
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
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div>
        </div>
        <div class="col text-right">
        <?php 
          if (isset($_SESSION['username'])) {
            $url1 = "profile.php";
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
        <div class="row">
        <?php
            if($conn) {
              if(isset($_POST['search'])){
                $search_param = $_POST['search-value'];
              }
              if(isset($_GET['category'])){
                $search_param = $_GET['category'];
              } 
                $sql = 'SELECT * FROM product NATURAL JOIN subcategory NATURAL JOIN category';
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)) { 
                    if (strcmp($row['sub'],$search_param)==0 || strcmp($row['main'],$search_param)==0 || strcmp($row['head'],$search_param)==0 || strcmp($row['brand'],$search_param)==0 || strcmp($row['name'],$search_param)==0){?>
                        <div class="col-3">
                            <div class="card mt-3">
                                <img class="card-img-top" src="images/product/<?php echo $row['name'];?>.jpg" height="160">
                                <div class="card-body">
                                    <p class="card-subtitle text-muted"><?php echo $row['brand'] ?></p>
                                    <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                    <p class="card-text">Quantity : <?php echo $row['quantity'] ?><br> Price: Rs <?php echo $row['price'] ?><br></p>
                                    <form class="form-group">
                                        <input type="number" name="quantity" min="1" class="form-control" placeholder="Order Quantity"><br>
                                        <input class = "btn btn-success" type="submit" name="submit" value="Add">
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
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