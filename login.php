<?php
    session_start();
    $db_host = '127.0.0.1:3306';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'st_project';
    $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
    $errors = array('username'=>'','password'=>'');
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($conn){
            $sql = "SELECT * FROM USERS WHERE username='$username'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0) {
                $users=mysqli_fetch_all($result,MYSQLI_ASSOC);
                if(strcmp($users[0]['password'],$password)==0) {
                    $_SESSION['username'] = $users[0]['username'];
                    $_SESSION['password'] = $users[0]['password'];
                    header("location: index.php");
                }
                else{
                    $errors['password'] = "*Incorrect password";
                }
            }
            else{
                $errors['username'] = "*Username not found";
            }
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
    <title>Login</title>
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
    <div class="container mt-5">
        <div class="row text-center" id="login-form">
            <div class="col-4"></div>
            <div class="col-4 border border-bottom-0 border-success pt-2">
                <h3>Login</h3>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 border border-top-0 border-success pt-3">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" style="<?php echo strlen($errors['username'])?'border:1px solid #FF0000':'' ?>">
                        <div style="color:red"><?php echo $errors['username'] ?></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password (More than 8 characters)"  style="<?php echo strlen($errors['password'])?'border:1px solid #FF0000':'' ?>">
                        <div style="color:red"><?php echo $errors['password'] ?></div>
                    </div>
                    <input type="submit" class="btn btn-success mb-3" name="submit" value="Login"></input>
                </form>
                <div class="mb-2">
                    <small class="text-muted">
                        Need an account?  <a class="ml-2" href="signup.php">Sign Up</a>
                    </small>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>