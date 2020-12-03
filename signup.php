<?php
    $db_host = '127.0.0.1:3306';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'st_project';
    $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
    $errors = array('fname'=>'','lname'=>'','email'=>'','username'=>'','password'=>'','cpassword'=>'','address'=>'','phone'=>'');
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $valid = true;

        if(strlen($fname)==0)
        {
            $errors['fname']="*First Name can't be empty";
            $valid=false;
        }
        else
        {
            for($i=0;$i<strlen($fname);$i++)
            {
                if(!ctype_alpha($fname[$i]))
                {
                    $errors['fname']='*First Name contains characters other than alphabets';
                    $valid=false;
                    break;
                }
            }
        }
        if(strlen($lname)==0)
        {
            $errors['lname']="*Last Name can't be empty";
            $valid=false;
        }
        else
        {
            for($i=0;$i<strlen($lname);$i++)
            {
                if(!ctype_alpha($lname[$i]))
                {
                    $errors['lname']='*Last Name contains characters other than alphabets';
                    $valid=false;
                    break;
                }
            }
        }
        if(strlen($email)==0)
        {
            $errors['email']="*Email can't be empty";
            $valid=false;
        }
        else
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = '*Invalid email format';
            }
        }
        if(strlen($username)==0)
        {
            $errors['username']="*Username can't be empty";
            $valid=false;
        }
        else
        {
            $sql = "SELECT * FROM USERS";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)) {
                if($username == $row['username'])
                {
                    $errors['username'] = "*Username already taken.";
                    $valid = false;
                }
            }
        }
        if(strlen($password)<=8)
        {
            $errors['password']='*Length must be greater than 8';
            $valid=false;
        }
        if($password!=$cpassword)
        {
            $errors['cpassword']='*Match Error';
            $valid=false;
        }
        if(strlen($phone)==0)
        {
            $errors['phone']="*Mobile number can't be empty";
            $valid=false;
        }
        else
        {
            if(strlen($phone)!=10)
            {
                $errors['phone'] = "*Incorrect mobile number";
                $valid=false;
            }
        }
        if($valid)
        {
            if($conn)
            {
                $sql="INSERT INTO USERS VALUES('$username','$fname','$lname','$email','$phone','$password','$address')";
                if(mysqli_query($conn,$sql))
                {
                    header("location: login.php");
                }
            }
            mysqli_close($conn);
        }
        else
        {
            mysqli_close($conn);
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
    <title>Signup</title>
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
    <div class="container border border-success mt-3">
        <div class="row text-center mb-3">
            <div class="col border-bottom border-success">
                <h3>Sign Up</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="signup.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?php echo isset($_POST["fname"]) ? $_POST["fname"] : ''; ?>" style="<?php echo strlen($errors['fname'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['fname'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" value="<?php echo isset($_POST["lname"]) ? $_POST["lname"] : ''; ?>" style="<?php echo strlen($errors['lname'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['lname'] ?></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="emailaddress">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" style="<?php echo strlen($errors['email'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['email'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user-name">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" style="<?php echo strlen($errors['username'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['username'] ?></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password (More than 8 characters)" style="<?php echo strlen($errors['password'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['password'] ?></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cpass">Confirm Password</label>
                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" style="<?php echo strlen($errors['cpassword'])?'border:1px solid #FF0000':'' ?>">
                            <div style="color:red"><?php echo $errors['cpassword'] ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Address">Address</label>
                        <textarea class="form-control" rows="3" placeholder="Enter your address" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="mobile-number">Mobile Number</label>
                        <input type="tel" class="form-control" name="phone" placeholder="Mobile Number" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" style="<?php echo strlen($errors['phone'])?'border:1px solid #FF0000':'' ?>" pattern="[0-9]{10}">
                        <div style="color:red"><?php echo $errors['phone'] ?></div>
                    </div>
                    <input type="submit" class="btn btn-success mb-3" name="submit" value="Sign In"></input>
                </form>
                <div class="mb-2">
                    <small class="text-muted">
                        Already have an account?  <a class="ml-2" href="login.php">Log In</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>