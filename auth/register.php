<?php

require "../db/connection.php";
$pdo = pdo_connect_mysql();

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please fill username.";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Wrong username pattern!";
    } 
    else{
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Username already exists!";
                } 
                else{
                    $username = trim($_POST["username"]);
                }
            } 
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Pelase fill password.";     
    } 
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password need to be at least 6 chareters.";
    } 
    else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please fill confirm password.";     
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords missmatch!";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            if($stmt->execute()){
                header("location: login.php");
            } 
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }
    
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <title>Register</title>    
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>

    <section class="vh-100" style="background-color: #000;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create new account</h5>
                                    
                                        <!-- username input -->
                                        <div class="form-outline mb-4">
                                            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                            <label class="form-label" for="form3Example3">Email address</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                            <label class="form-label" for="form3Example4">Password</label>
                                        </div>

                                        <!-- Password repeat input -->
                                        <div class="form-outline mb-3">
                                            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                            <label class="form-label" for="form3Example4">Password repeat</label>
                                        </div>
                                        
                                        <div class="text-center text-lg-start mt-4 pt-2">
                                            <input type="submit" class="btn btn-primary" value="Register">
                                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                                            <p class="small fw-bold mt-2 pt-1 mb-0">
                                                <a href="login.php">New account</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
</body>
</html>