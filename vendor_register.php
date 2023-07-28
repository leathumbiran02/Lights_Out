<?php
    //Using the database configuration file:
    require_once('db_config.php');

    if(isset($_POST['submit'])) //This code is executed when the user clicks the submit button in the registration form:
    {
        //Matching the columns in the form to the columns in the users table:
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number=$_POST['phone_number'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        //Hash the password for security purposes:
        $hash_password=password_hash($pass, PASSWORD_DEFAULT); 
        
        //Creating a connection to the database:
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if(!$connect) //If the connection fails display an error:
        {
            die("Connection failed! " . mysqli_connect_error());
        }

        //Check if the email entered already exists in the vendors table:
        /* Prepare the statement: */
        $check_email=$connect->prepare("
        SELECT *
        FROM vendor
        WHERE email=?
        ");

        $check_email->bind_param("s", $email); /* Bind the parameter: */
        $check_email->execute(); /* Execute the statement: */
        $result=$check_email->get_result(); /* Get the set of results: */

        if($result->num_rows>0){/* If a result was found display an error message and redirect to the registration page for the vendor to try again: */
            echo '<script>alert("This email address has already being used. Please use a different one.")</script>'; //Display an error message to the user:
            header('Refresh: 1; url=vendor_register.html'); //Redirect the user to the registration page after failing to register:
            exit();
        }

        //Using prepared statements with parameterized queries:
        //Prepare the statement for the vendor table:
        $statement=$connect->prepare("
        INSERT INTO vendor (
        first_name, 
        last_name, 
        phone_number,
        email, 
        password
        )
        VALUES (?,?,?,?,?)
        ");

        $statement->bind_param("sssss",$first_name,$last_name,$phone_number,$email,$hash_password); //Bind the parameters:

        //Execute the statement:
        if($statement->execute()){
            if(mysqli_affected_rows($connect)>0){//If connection is successful and a row was affected, registration is successful:
                echo '<script>alert("Thank you for registering with us!")</script>';
                header('Refresh: 1; url=login.php'); //Redirect the user to the login page after registering
            }else{/* Failed to insert into the database: */
                echo '<script>alert("Failed to register an account. Please try again.")</script>'; //Display an error message to the user:
                header('Refresh: 1; url=vendor_register.html'); //Redirect the user to the registration page after failing to register:
            } 
        }
      	else{//If executing the statement fails:
            echo '<script>alert("Failed to register an account. Please try again.")</script>'; //Display an error message to the user:
            header('Refresh: 1; url=vendor_register.html'); //Redirect the user to the registration page after failing to register:
        }
        //Closing the prepared statement and the database connection:
        $statement->close();
        $connect->close();
    }else{ /* Form was not submitted, display an error message and redirect to the login page: */
        echo '<script>alert("You do not have permission to access this page.")</script>'; //Display an error message:
        header('Refresh: 1; url=login.php');
        exit();
    }
?>
