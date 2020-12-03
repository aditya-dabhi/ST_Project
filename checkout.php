<?php
    session_start();
    $db_host = '127.0.0.1:3306';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'st_project';
    $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
    if(isset($_COOKIE['cartproducts'])){
        $cookie = stripslashes($_COOKIE['cartproducts']);
        $cartitems = json_decode($cookie,true);
    }
    $sender_email = "aditest09@gmail.com";
    $sender_password = "adityadabhi";
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
    <title>Checkout</title>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <a href="index.php"><img src="images/logo.jpg" id="logo" height="150", width="350"></a>
                </div>
            </div>
        </div>
    </div>
    <?php
      if(isset($_GET["send"])) {
        $sql = 'SELECT * FROM users';
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)) { 
          if(strcmp($row['username'],$_SESSION['username'])==0){
            require_once('C:\xampp\Mailer\PHPMailer-5.2-stable\PHPMailerAutoload.php');
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML();
            $mail->Username = $sender_email;
            $mail->Password = $sender_password;
            $mail->Subject = "Order Details";
            $mail->Body = "The total amount of your order is : ".$_GET["send"]."\n Delivery address: ".$row['address']."\n Your order is expected to reach the destination by tomorrow.";
            $mail->AddAddress($row['email']);
            if($mail->Send()){
              echo "<script>alert('Subject: $sub \\nBody: $body');</script>";
              $cookie = stripslashes($_COOKIE['cartproducts']);
              $cartitems = json_decode($cookie,true);
              $cartitems['products'] = array();
              setcookie("cartproducts",json_encode($cartitems), time()+86400, "/");
              echo "<script>alert('Subject: $sub \\nBody: $body');</script>";
              header("location: index.php");
            }
          }
        }
      }
    ?>
    
    <div class="container mt-5">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total_amount=0;
                    for($i=0; $i<sizeof($cartitems['products']); $i++) {
                        $sql = 'SELECT * FROM product NATURAL JOIN subcategory NATURAL JOIN category';
                        $result = mysqli_query($conn,$sql);
                        while($row = mysqli_fetch_assoc($result)) { 
                            if (strcmp($cartitems['products'][$i][0],$row['name'])==0){?>
                                <tr>
                                    <th scope="row"><?php echo $i+1 ?></th>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $cartitems['products'][$i][1] ?></td>
                                    <td><?php echo $cartitems['products'][$i][1]*$row['price'] ?></td>
                                </tr>
                            <?php 
                            $total_amount = $total_amount+($cartitems['products'][$i][1]*$row['price']);
                            }
                        }
                    }
                ?>
                <tr>
                    <th scope="row" colspan="3" class="text-center">Total Amount</th>
                    <td><?php echo $total_amount ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container">
      <div class="text-center">
        <a href="checkout.php?send=<?php echo $total_amount ?>" class="btn btn-success mt-3">CONFIRM YOUR ORDER</a>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>