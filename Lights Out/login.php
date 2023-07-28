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
            background-image: url(images/purple_and_gold.jpg);
            background-position:center;
            background-size:cover;
            background-attachment: fixed;
        }
        p{
            color: #fff;
            font-size: 25px;
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
            <div class="form-box"> <!-- The login and register form: -->
                <div class="register_login_btn_box"> <!-- The buttons that switches between both the login and register form: -->
                    <div id="btn"></div>
                    <button type="button" class="toggle_register_login_btn" onclick="login()">Login</button> <!-- When the Login button is clicked call the login() function: -->
                    <button type="button" class="toggle_register_login_btn" onclick="register()">Register</button> <!-- When the Register button is clicked call the register() function: -->
                </div>

                <!--Create a login form for a user to enter their email and password:-->
                <form class="login_input_group" id="login" name = "login_form" action="vendor_and_user_login.php" method="POST">
                    <!-- Email Address: -->
                    <input type = "email" class="input_field" name = "email" placeholder = "Email address" required/>

                    <!-- Password: -->
                    <input type = "password" class="input_field" name = "password" placeholder = "Password" required/><br><br><br>

                    <!-- Button to submit the details to the database: -->
                    <button type="submit" name="submit" class="submit_btn">Login</button>

                    <div class="center-text">
                        <!-- Forgot Password:-->
                        <a href="forgot_password.php"><span class="forgot_password">Forgot Password?</span></a>
                    </div>
                </form>

                <!--Create a registration form that sends the information to the database:-->
                <form class = "login_input_group" id="register" name = "register_form" action = "register.php" method = "POST" onsubmit = "return(validate_registration());">
                    <!-- First Name: -->
                    <input type = "text" class="input_field" name = "first_name" placeholder = "First name" required/>
                    
                    <!-- Last Name: -->
                    <input type = "text" class="input_field" name = "last_name" placeholder = "Last name" required/>

                    <!-- Email Address: -->
                    <input type = "email" class="input_field" name = "email" placeholder = "Email address" required/>

                    <!--Password:-->
                    <input type = "password" class="input_field" name = "pass" placeholder = "Password" required/>

                    <!-- Confirm Password: -->
                    <input type = "password" class="input_field" name = "confirm_pass" placeholder = "Confirm password" required/>

                    <!-- Agree to terms and conditions checkbox -->
                    <input type="checkbox" class="check_box" id="agree_checkbox"><span class="remember_password" required>I agree to the terms & conditions</span>

                    <!--Button to submit the form:-->
                    <button type="submit" name="submit" class="submit_btn">Register</button>       
                </form>
            </div>
            <footer> <!-- Have a terms and conditions appear at the bottom of the page: -->
                <div class="center-text">
                    <p><i>Terms & Conditions: By creating an account you agree to share your full name and email address with the Lights Out company.</i></p>
                </div>
            </footer>
        </div>     
        <!--Use an external javascript file named validate.js to validate the form:-->
        <script src="validate.js"></script>
    </body>
</html>