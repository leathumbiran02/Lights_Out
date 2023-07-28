<?php
        //Starting the session:
        session_start();

        //Checking that the person logged in is a user:
        if(isset($_SESSION['users']) && $_SESSION['users'] == true){
                //Unset all of the session variables:
                session_unset();

                //Destroy the session:
                session_destroy();

                //Redirect the user to the home page:
                echo '<script>alert("You have been logged out.")</script>'; //Display an error message:
                header('Refresh: 1; url=index.php');
                exit(); 
        }else if(isset($_SESSION['vendor']) && $_SESSION['vendor'] == true){ //Checking that the person logged in is a vendor:
                //Unset all of the session variables:
                session_unset();

                //Destroy the session:
                session_destroy();

                //Redirect the user to the home page:
                echo '<script>alert("You have been logged out.")</script>'; //Display an error message:
                header('Refresh: 1; url=index.php');
                exit(); 
        }else{ /* The person is not logged in at all, so display an error message and redirect to the login page: */
                echo '<script>alert("You must be logged in to use this feature.")</script>'; //Display an error message:
                header('Refresh: 1; url=login.php');
                exit();
        }
?>