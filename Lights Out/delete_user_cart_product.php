<?php
    /* Get the user_id from the session: */
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

     //Checking if the person logged in is a user:
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in as a user to access this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    //If the connection fails display an error:
    if($connect->connect_error){
        die("Connection failed!" . $connect->connect_error);
    }

    //Checking if the product id is provided in the URL:
    if(isset($_GET['id'])){

        $product_id=$_GET['id']; //Get the product_id and store it in $product_id:

        $user_id=$_SESSION['user_id']; //Store the user id from the session:

        //Check if the users' cart is empty before deleting products:
        /* Prepare the statement: */    
        $check_empty_cart=$connect->prepare("
        SELECT *
        FROM cart
        WHERE user_id=?
        ");

        $check_empty_cart->bind_param("i", $user_id);/* Bind the parameters: */
        $check_empty_cart->execute(); /* Execute the statement: */
        $result=$check_empty_cart->get_result(); /* Get the set of results: */

        if($result->num_rows){ /* If a result is found, delete the product from cart: */
            //Using prepared statements with parameterized queries:
            //Delete the product from the users cart based on its product_id:
            $delete_product_in_cart=$connect->prepare("
            DELETE 
            FROM cart_products
            WHERE cart_id IN (
                SELECT cart_id
                FROM cart
                WHERE user_id=?
            )
            AND product_id=?
            "); 
            
            $delete_product_in_cart->bind_param("ii",$user_id, $product_id); //Bind the parameters:

            If($delete_product_in_cart->execute()){  //If the query runs successfully, display a success message and redirect to the user cart page:
                echo "<script>alert('The product has been deleted successfully!')</script>"; 
                header('Refresh: 1; url=user_cart.php');
                exit();
            } else{ //If there was an error when deleting the product, display an error message and redirect to the user cart page: 
                echo "<script>alert('Failed to delete the product from your cart. Please try again.')</script>"; 
                header('Refresh: 1; url=user_cart.php');
                exit();
            }
        }else{ /* The user's cart is empty, display an error message and redirect to the cart page: */
            echo "<script>alert('Your cart is empty. Please try again.')</script>"; 
            header('Refresh: 1; url=user_cart.php');
            exit();
        }  
    } else{ //If there was no product id found in the URL, display an error message:
        echo "<script>alert('No product id was provided. Please try again.')</script>"; 
    }
    //Closing the database connection:
    $connect->close();
?>