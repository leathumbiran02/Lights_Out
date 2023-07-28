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
            bottom:160px;
            font-size:21px;
        }
        .login_input_group{
            top:150px;
            width: 450px;
        }
        .form-box{ 
            width: 500px;
            height:400px;
        }
        .toggle_register_login_btn{ /* Hiding the heading on the page: */
            display: none;
        }
        .register_login_btn_box{ /* Hiding the heading on the page: */
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
            <div class="form-box"> <!-- The forgot password page: -->
                <div class="register_login_btn_box"> <!-- Div used for the heading on the page: -->
                        <div id="btn"></div>
                        <button type="button" class="toggle_register_login_btn">Forgot Password</button> 
                </div>
                <!--Create a login form for a user to enter their email and password:-->
                <form class="login_input_group" id="forgot" name = "forgot_password" action="send_forgot_password_email.php" method="POST">
                    <!-- Label for the top of the page: -->
                    <h1 class="remember_password">Please enter the email address associated with your account:</h1>

                    <!-- Email Address: -->
                    <input type = "email" class="input_field" name = "email" placeholder = "Email address" required/><br><br>

                    <!-- Button to submit the details to the database: -->
                    <button type="submit" name="submit" class="submit_btn">Send password reset email</button>
                    
                    <div class="center-text">
                        <!-- Go Back To Login hyperlink:-->
                        <a href="login.php"><span class="forgot_password">Go Back</span></a>
                    </div>
                </form>
            </div>
        </div>     
    </body>
</html>