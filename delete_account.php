<?php
    //Starting the session so we can check if the user is logged in:
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    //If the connection fails display an error:
    if($connect->connect_error){
        die("Connection failed!" . $connect->connect_error);
    }

    //Checking if the user email is in the session:
    if(isset($_SESSION['email'])){
        $user_email=$_SESSION['email']; //Get the user email and store it in $user_email:

        //Check if the person logged in is a vendor:
        /* Prepare the statement: */
        $check_vendor=$connect->prepare("
        SELECT *
        FROM vendor
        WHERE email=?
        ");

        $check_vendor->bind_param("s",$user_email); /* Bind the parameter: */
        $check_vendor->execute(); /* Execute the statement: */
        $result=$check_vendor->get_result(); /* Get the set of results: */

        if($result->num_rows>0){/* If a result was found, display an error and redirect to the home page: */
            echo "<script>alert('Vendors do not have access to this feature.')</script>"; 
            header('Refresh: 1; url=index.php');
            exit();
        }

        //Using prepared statements with parameterized queries:
        //Delete the user from the database based on their email address:
        $deleteUser=$connect->prepare("
        DELETE 
        FROM 
        users 
        WHERE email=?
        "); 

        $deleteUser->bind_param("s",$user_email); //Bind the parameter:

        If($deleteUser->execute()){  //If the query runs successfully:
            session_destroy(); /* Destroy the user session: */
            
            //If the user is deleted, display a success message to the user and redirect to the home page:
            echo "<script>alert('Your account has been deleted. You will now be redirected to the home page...')</script>"; 
            header('Refresh: 1; url=index.php');
            exit();
        } else{  //If there was an error when deleting the user, display an error message and redirect to the account page: 
            echo "<script>alert('Failed to delete your account. Please try again.')</script>"; 
            header('Refresh: 1; url=account.php');
            exit();
        }
    }else{ /* Check if the email is stored in the session: */
        echo "<script>alert('You must be logged in to view this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }
?>