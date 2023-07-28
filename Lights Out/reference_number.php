<?php
    /* Using the database configuration file: */
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if(isset($_SESSION['user_id'])){ /* If the user id is found in the session execute the following code: */

        $user_id=$_SESSION['user_id']; /* Fetch the user_id and store it: */

        $existing_reference_number = true;  /* Set existing_reference_number to true: */

        while($existing_reference_number){ /* While existing reference number is true execute the following code:*/
            $reference_number="LIGHTSOUT" . rand(1000,9999); /* Generate a reference number starting with LIGHTSOUT and the last 4 digits being randomised for each order: */

            /* Check if the reference number already exists in the table: */
            /* Prepare the statement: */
            $check_reference_number=$connect->prepare("
            SELECT reference_number 
            FROM reference_numbers
            WHERE reference_number=?
            ");

            $check_reference_number->bind_param("s",$reference_number); /* Bind the parameter: */
            $check_reference_number->execute(); /* Execute the statement: */
            $check_reference_number->store_result(); /* Get the set of results and store it: */

            if($check_reference_number->num_rows==0){ /* If the reference number is not found, return existing_reference_number as false, exit the while loop and then execute the next section of code: */
                $existing_reference_number = false;
            }
        }
            /* The reference number is new so insert the reference number into the reference numbers table: */
            //Prepare the statement:
            $insert_reference_number=$connect->prepare("
            INSERT INTO reference_numbers (
            user_id,
            reference_number
            )
            VALUES (?,?)
            ");

            $insert_reference_number->bind_param("is",$user_id, $reference_number); /* Bind the parameter: */
            $insert_reference_number->execute(); /* Execute the statement: */
    }else{ /* User id could not be retrieved, display an error message and redirect to the login page: */
        echo '<script>alert("You do not have permission to access this page.")</script>'; //Display an error message:
        header('Refresh: 1; url=login.php');
        exit();
    }
    /* Store the reference number that was generated in a session variable: */
    $_SESSION['reference_number']=$reference_number;
?>