<?php
    //Starting the session:
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');

    //Checking if the email address is stored in the session:
    if(!isset($_SESSION['email'])){
        echo "<script>alert('You must be logged in to view this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    //Retrieve the user's email address from the session:
    $email = $_SESSION['email'];

    //Create a connection to the database:
    $connect=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    /* Using prepared statements with parameterized queries: */
    /* Check if the email retrieved matches any email in the vendor table: */
    /* Prepare the statement: */
    $vendor_query=$connect->prepare("
    SELECT
    *
    FROM
    vendor
    WHERE email=?
    ");

    $vendor_query->bind_param("s",$email); /* Bind the parameter: */
    $vendor_query->execute(); /* Execute the statement: */
    $result=$vendor_query->get_result(); /* Get the set of results: */
    $row=$result->fetch_assoc(); /* Fetch the associated row: */

    /* If the row was not found check in the users table for the email address: */
    if(!$row){
        /* Prepare the statement: */
        $user_query=$connect->prepare("
        SELECT
        *
        FROM
        users
        WHERE email=?
        ");

        $user_query->bind_param("s",$email); /* Bind the parameter: */
        $user_query->execute(); /* Execute the statement: */
        $result=$user_query->get_result(); /* Get the set of results: */
        $row=$result->fetch_assoc(); /* Fetch the associated row: */
    }

    /* Display the users'/admin's account information in the form: */
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
    $email=$row['email'];

    /* Closing the database connection: */
    $connect->close();

    /* If the update account details form is submitted, execute the following code: */
    if($_SERVER['REQUEST_METHOD']==='POST'){
        /* Fetch the updated details from the form: */
        $new_first_name=$_POST['first_name'];
        $new_last_name=$_POST['last_name'];
        $new_email=$_POST['email'];

        /* Create a connection to the database: */
        $connect=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        /* Check if the new email address exists in the vendor table or the users table: */
        /* Prepare the statement: */
        $check_email_query=$connect->prepare("
        SELECT email
        FROM vendor 
        WHERE email=?
        UNION ALL
        SELECT email
        FROM users 
        WHERE email=?
        ");

        $check_email_query->bind_param("ss", $new_email, $new_email); /* Bind the parameters: */
        $check_email_query->execute(); /* Execute the statement: */
        $result=$check_email_query->get_result(); /* Get the set of results: */
        $row=$result->fetch_assoc(); /* Fetch the associated row and store it: */

        if($row){/* If a row was found, display an error message and prevent the update: */
            echo '<script>alert("This email address is already being used. Please try again.")</script>';
            header('Refresh: 1; url=update_account.php');
            exit();
        }
        /* Update the account details in the vendor table if the email address is in that table: */
        /* Prepare the statement: */
        $update_vendor=$connect->prepare("
        UPDATE
        vendor
        SET
        first_name=?,
        last_name=?,
        email=?
        WHERE email=?
        ");

        $update_vendor->bind_param("ssss",$new_first_name,$new_last_name,$new_email,$email); /* Bind the parameters: */
        $update_vendor->execute(); /* Execute the statement: */

        /* Check if the details were updated successfully in the vendor table: */
        if($update_vendor->affected_rows >0){
            $_SESSION['email']=$new_email; /* Update the vendor's email in the session: */
            echo '<script>alert("Your account details were updated successfully!")</script>';
            header('Refresh: 1; url=account.php');
            exit();
        }

        /* Update the account details in the user table if the email address is in that table: */
        /* Prepare the statement: */
        $update_user=$connect->prepare("
        UPDATE
        users
        SET
        first_name=?,
        last_name=?,
        email=?
        WHERE email=?
        ");

        $update_user->bind_param("ssss",$new_first_name,$new_last_name,$new_email,$email); /* Bind the parameters: */
        $update_user->execute(); /* Execute the statement: */

        /* Check if the details were updated successfully in the user table: */
        if($update_user->affected_rows >0){
            $_SESSION['email']=$new_email; /* Update the user's email in the session: */
            echo '<script>alert("Your account details were updated successfully!")</script>';
            header('Refresh: 1; url=account.php');
            exit();
        }
        /* Closing the database connection: */
        $connect->close();
    }
?>

<!-- HTML for the page that the user/admin will see in their browser: -->
<!DOCTYPE html>
<html>
    <head>
        <!-- Title of Web Page: Lights Out -->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page:-->
        <link rel="stylesheet" href="style.css">

        <style> /* Applying additional styling for this specific page: */
            label{
                font-size: 25px;
            }
            .main-header{
                padding: 20px;;
                font-size: 3vw;
                text-align: center;
            }
            header{
                box-shadow: 0 5px 10px rgb(57,161,180,1);
            }
            .contactus-form input, .contactus-form textarea{
                border: 2px solid rgb(57,161,180,1);
            }
            input[type=submit]{ 
                background: linear-gradient(to right, rgb(57,161,180,1), rgb(46,114,215,1));
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
        <div class="hero">
            <!-- Create a form for users/admins to view and update their account details: -->
            <form class = "update-account-form" name = "update-account" action = "update_account.php" method = "POST">
                <!--Title of the Page: Edit Account-->
                <h1 class="main-header">Edit Account</h1>

                <label for="first_name">First Name:</label> <!-- First Name: -->
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">

                <label for="last_name">Last Name:</label> <!-- Last Name: -->
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">

                <label for="email">Email:</label> <!-- Email: -->
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">

                <!--Button to submit the form:-->
                <input type = "submit" name = "submit" value = "save"/>
            </form>

            <!-- An Extra button is added to navigate back to the account page: -->
            <div class="center-text">
                <br><a style="margin-top:0px; padding:15px; width:80%; color:white; font-size: 16px;" href="account.php">BACK TO ACCOUNT</a>
            </div>
        </div>
    </body>
</html>