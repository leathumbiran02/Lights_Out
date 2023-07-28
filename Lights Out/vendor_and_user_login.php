<?php
    //Using the database configuration file:
    require_once('db_config.php');

    //This code is executed when the user clicks the submit button in the login form:
    if(isset($_POST['submit'])){
        //Creating a connection to the database:
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        //Retrieve the user's email and password from POST request:
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Using prepared statements with parameterized queries:
        //Prepare the statement for the users table:
        $login_user=$connect->prepare("
        SELECT 
        * 
        FROM users 
        WHERE email=?
        ");

        $login_user->bind_param("s",$email); //Bind the parameter:
        $login_user->execute(); //Execute the statement:
        $result=$login_user->get_result(); //Get the set of results:
        $row=$result->fetch_assoc(); //Fetch the associated row and store it in $row:

        //Check if the record exists (a row was found) and then redirect to the user's account, otherwise display an error message:
        if($row){
            //If the user exists in the users table:
            $hash_password=$row['password']; //Retrieve the hashed password from the database:

            //Use the password_verify function to verify the password:
            if(password_verify($password,$hash_password)){ 
                //Successful login, redirect to account page:
                session_start(); //Start a session to store the user's information:
                
                /* Session variables: */
                $_SESSION['email']=$row['email']; //Store the users email in a session variable:
                $_SESSION['user_id']=$row['user_id']; //Store the users id in a session variable:
                $_SESSION['users']='true'; //Set the user key to true:

                $firstname = $row['first_name']; //Get the user's first name from the database:

                echo "<script>alert('Welcome back $firstname!')</script>"; //Display a successful login message to the user:
                header('Refresh: 1; url=index.php'); //Redirect to the account page:
                exit();
            }else{ 
                //If the user was not found in the users table, display an error message:
                echo '<script>alert("Invalid Login. Please Try Again.")</script>'; //Failed login, displays an error message:
                header('Refresh: 1; url=login.php'); //Redirect the user to the login page after failure to login:
                exit();
            }
        }
        else{ 
            //If the user is not found in the users table, check the vendor table:
            //Prepare the statement for the vendor table:
            $login_vendor=$connect->prepare("
            SELECT 
            * 
            FROM 
            vendor 
            WHERE email=?
            ");
            
            $login_vendor->bind_param("s",$email); //Bind the parameters:
            $login_vendor->execute(); //Exectute the statement:
            $result=$login_vendor->get_result(); //Get the set of results:
            $row = $result->fetch_assoc(); //Fetch the associated row and store it in $row:

            if($row){ 
                //If the user is found (a row was found) in the vendor table, execute the following code:
                $hash_password=$row['password']; //Retrieve the hashed password from the database:

                //Use the password_verify function to verify the password:
                if(password_verify($password,$hash_password)){
                    //Successful login, redirect to account page
                    session_start(); //Start a session to store the user's information:
                
                    /* Session variables: */
                    $_SESSION['email']=$row['email']; //Store the vendors's email in a session variable:
                    $_SESSION['vendor_id']=$row['vendor_id']; //Store the vendors id in a session variable:
                    $_SESSION['vendor']='true'; //Set the vendor key to true in the session:

                    $firstname = $row['first_name']; //Get the user's first name from the database:
                    $lastname = $row['last_name']; //Get the user's last name from the database:

                    echo "<script>alert('Welcome back administrator $firstname $lastname!')</script>"; //Display a successful login message to the vendor:
                    header('Refresh: 1; url=index.php'); //Redirect to the account page:
                    exit();
                }else{ 
                    //If the vendor is not found in the vendor table, display an error message:
                    echo '<script>alert("Invalid Login. Please Try Again.")</script>'; //Failed login, displays an error message:
                    header('Refresh: 1; url=login.php'); //Redirect the user to the login page after failure to login:
                    exit();
                }
            }else {
                //If for any reason the database fails or the user is not found, display an error message:  
                echo '<script>alert("The user was not found. Please Try Again.")</script>'; //Failed login, displays an error message:
                header('Refresh: 1; url=login.php'); //Redirect the user to the login page after failure to login:
            }
        }
        //Closing the prepared statements and database connection:
        $login_user->close();
        $login_vendor->close();
        $connect->close();
    }else{ /* Form was not submitted, display an error message and redirect to the login page: */
        echo '<script>alert("You do not have permission to access this page.")</script>'; //Display an error message:
        header('Refresh: 1; url=login.php');
        exit();
    }
?>