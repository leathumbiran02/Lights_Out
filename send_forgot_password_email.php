<?php
    //Since Composer is being used, the autoload.php file must be included so that emails can be sent
    //The vendor folder must be copied into the same folder as the lights out website in order to work
    require 'vendor/autoload.php';

    //Using the database configuration file:
    require_once('db_config.php');

    //This code is executed when the user/vendor clicks the submit button in the forgot password form:
    if(isset($_POST['submit'])) {
        //Retrieving the email from the form and storing it:
        $email = $_POST['email'];
        
       //Configuring the SMTP server settings:
        $smtp_server = 'smtp.gmail.com'; //Using gmail
        $smtp_port = 587; //Using a specific port number
        $smtp_username = 'seansmith23lightsout@gmail.com'; //Email address that will be used to send the welcoming message emails
        $smtp_password = 'elgnklavadzuatze'; //App password that was generated for gmail so that the email address can be used by other programs.
        
        //Creating a connection to the database:
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if(!$connect) {//If the connection fails display an error:
            die("Connection failed! " . mysqli_connect_error());
        }

        /* Checking if the email entered already exists in the user table:: */
        /* Prepare the statement: */
        $user_exists=$connect->prepare("
        SELECT email 
        FROM users 
        WHERE email=?
        ");

        $user_exists->bind_param("s",$email); /* Bind the parameter: */
        $user_exists->execute(); /* Execute the statement: */
        $user_result=$user_exists->get_result(); /* Get the result: */

        /* Checking if the email entered already exists in the vendor table:: */
        $vendor_exists=$connect->prepare("
        SELECT email 
        FROM vendor 
        WHERE email=?
        ");

        $vendor_exists->bind_param("s",$email); /* Bind the parameter: */
        $vendor_exists->execute(); /* Execute the statement: */
        $vendor_result=$vendor_exists->get_result(); /* Get the result: */

        /* If the email already exists in the user table or vendor table, allow the user/vendor to reset their password:: */
        if($user_result->num_rows>0 ||$vendor_result->num_rows>0){
            //Send the email to the user:
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                
            try{ //Using try catch for error handling:

                //Configuring the mail server settings:
                $mail->isSMTP();
                $mail->Host= $smtp_server;
                $mail->SMTPAuth= true;
                $mail->Username= $smtp_username;
                $mail->Password= $smtp_password;
                $mail->SMTPSecure= 'tls';
                $mail->Port= $smtp_port;

                //Specifying the recipients of the email:
                $mail->setFrom($smtp_username, 'Lights Out');
                $mail->addAddress($email);

                //Specifying the content of the email:
                $mail->isHTML(true);
                $mail->Subject = 'Reset password';
                $mail->Body    = "
                Hey, 
                <br><br>We have received a request to reset your password.
                <br><br>If this was you, you can reset your password here: <a href='https://lights-out-south-africa.000webhostapp.com/reset_password.php'>Reset Password</a>
                <br><br>If you did not request this, please ignore this email.<br><br>
                Thanking you,
                <br>The Lights Out Team";

                //Sending the email to the user:
                $mail->send();

                //Generating a success message to the user:
                echo '<script>alert("Your password reset email was sent! Please check your mail or spam folder.")</script>';
                header("Refresh:1; url=login.php"); //Redirect to the login/registration page so that the user can login:
                exit;
            }
            catch(Exception $e){ //If the email fails for any reason:
                
                echo '<script>alert("Could not send your password reset email. Please try again later.")</script>'; 
                header("Refresh:1; url=forgot_password.php"); //Redirect to the forgot password page so that the user can try again:
                exit;
            }
        }else{
            /* Email address does not exist in the user or vendor table: */
            echo '<script>alert("Your email address was not found. Please try again.")</script>';
            header("Refresh:1; url=forgot_password.php"); //Redirect user to the forgot password page:
            exit();
        }
    }else{ /* The form was not submitted, display an error message and redirect to the login page: */
        echo '<script>alert("You do not have permission to access this page.")</script>'; //Display an error message:
        header('Refresh: 1; url=login.php');
        exit();
    }
?>
