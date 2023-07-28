<?php
    //Using the database configuration file:
    require_once('db_config.php');

    //This code is executed when the user/vendor clicks the submit button in the forgot password form:
    if(isset($_POST['submit'])) {
        //Retrieving the email and new password from the form and storing it:
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $confirm_pass = $_POST['confirm_pass'];
        
        /* Hash the password for security purposes: */
        $hash_password=password_hash($pass, PASSWORD_DEFAULT);

        //Creating a connection to the database:
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if(!$connect) {//If the connection fails display an error:
            die("Connection failed! " . mysqli_connect_error());
        }

        /* Check if the email exists in the users table: */
        $check_user=$connect->prepare("
        SELECT *
        FROM users
        WHERE email=?
        ");

        $check_user->bind_param("s", $email); /* Bind the parameters: */
        $check_user->execute(); /* Execute the statement: */
        $user_result=$check_user->get_result(); /* Get the set of results: */

        /* Check if the email exists in the vendor table: */
        $check_vendor=$connect->prepare("
        SELECT *
        FROM vendor
        WHERE email=?
        ");

        $check_vendor->bind_param("s", $email); /* Bind the parameters: */
        $check_vendor->execute(); /* Execute the statement: */
        $vendor_result=$check_vendor->get_result(); /* Get the set of results: */

        /* If the password was updated or a row was affected in the vendor or users table execute the following code:*/
        if($user_result->num_rows>0 || $vendor_result->num_rows>0){
            /* If the password and confirm password match: */
            if($pass===$confirm_pass){
                /* Update the user or vendors password based on the result: */
                if($user_result->num_rows>0){ /* Update the user password: */
                    $update_password=$connect->prepare("
                    UPDATE users 
                    SET password=?
                    WHERE email=?
                    ");
                }else{ /* Update the vendor password: */
                    $update_password=$connect->prepare("
                    UPDATE vendor 
                    SET password=?
                    WHERE email=?
                    ");
                }

                $update_password->bind_param("ss",$hash_password, $email); /* Bind the parameters: */
                $update_password->execute(); /* Execute the statement: */

                /* If the password was updated or a row was affected display a message to the user/vendor: */
                if($update_password->affected_rows > 0){
                    echo '<script>alert("Your password has been reset successfully!")</script>';
                    header("Refresh:1; url=login.php"); //Redirect user/vendor to the login page:
                    exit();
                }else{
                    echo '<script>alert("Failed to reset your password. Please try again.")</script>';
                    header("Refresh:1; url=reset_password.php"); //Redirect user/vendor to the reset password page:
                    exit();
                } 
            }else{
                /* Password and Confirm Password Do not Match: */
                echo '<script>alert("The passwords you entered do not match. Please try again.")</script>';
                header('Refresh: 1; url=reset_password.php'); //Redirect the user/vendor to the reset password page to try again:
            }
        }else{
            /* Email does not exist in the vendor or users table: */
            echo '<script>alert("The email address was not found. Please try again.")</script>';
            header('Refresh: 1; url=reset_password.php'); //Redirect the user/vendor to the reset password page to try again:
        }
        //Closing the prepared statement and the database connection:
        $connect->close();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Referencing a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css">
        
        <style>
        body{ /* Adding a background image to the page: */
            width: 100%;
            padding: 20px;
            background-image: url(images/pxfuel.jpg);
            background-position:center;
            background-size:cover;
            background-attachment: fixed;
        }
        #btn{ /* Styling of the heading on the page: */
            width: 230px;
        }
        .register_login_btn_box{ /* Styling of the heading on the page: */
            width: 230px;
        }
        .remember_password{
            bottom:280px;
            font-size:21px;
        }
        .login_input_group{
            top:150px;
            width: 440px;
        }
        .form-box{ /* For the form */
            width: 450px;
            height:500px;
            position: relative;
            margin: 6% auto;
            background-color: rgb(9,6,25,1);
            opacity: 95%;
            border-radius: 10px;
            padding: 5px;
        }
        .toggle_register_login_btn{
            display: none;
        }
        .register_login_btn_box{
            display:none;
        }
        #forgot{
            left:20px;
        }
        .forgot_password{
            color: #ffffff;
            font-size: 17px;
            bottom:-30px;
            position: relative;
        }
        </style>

    </head>
    <body>
        <header>
            <!-- Including the file that contains the menu: -->
            <?php 
                include 'menu.php';
            ?>
        </header>
        <div class="form_page"> <!-- The body of the page: -->
            <div class="form-box"> <!-- The reset password form: -->
                <div class="register_login_btn_box"> <!-- The buttons that switches between both forms: -->
                    <div id="btn"></div>
                    <button type="button" class="toggle_register_login_btn">Reset Password</button> 
                </div>
                <!--Create a login form for a user to enter their email and password:-->
                <form class="login_input_group" id="reset" name = "reset_password" action="reset_password.php" method="POST">
                    <!-- Label for the top of the page: -->
                    <h1 class="remember_password">Please enter your email address and a new password:</h1>

                    <!-- Email Address: -->
                    <input type = "email" class="input_field" name = "email" placeholder = "Email address" required/>

                    <!--Password:-->
                    <input type = "password" class="input_field" name = "pass" placeholder = "Password" required/>

                    <!-- Confirm Password: -->
                    <input type = "password" class="input_field" name = "confirm_pass" placeholder = "Confirm password" required/><br><br>

                    <!-- Button to submit the details to the database: -->
                    <button type="submit" name="submit" class="submit_btn">Save</button>
                    
                    <div class="center-text">
                        <!-- Go Back To Login:-->
                        <a href="login.php"><span class="forgot_password">Go Back</span></a>
                    </div>
                </form>
            </div>
        </div>     
    </body>
</html>
