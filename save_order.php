<?php
    /* Using the database configuration file: */
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if(isset($_SESSION['user_id']) && isset($_SESSION['reference_number'])){ /* If the user_id is stored in the session execute the following code: */
        
        $user_id=$_SESSION['user_id'];  /* Fetch the user_id and store it: */
      
        $reference_number=$_SESSION['reference_number']; /* Fetch the reference_number and store it: */

        /* Check if the order has been saved before: */
        $check_saved_order=$connect->prepare("
        SELECT order_id
        FROM orders
        WHERE reference_number = ?
        AND user_id = ?
        ");

        $check_saved_order->bind_param("si", $reference_number, $user_id); /* Bind the parameters: */
        $check_saved_order->execute(); /* Execute the statement: */
        $result=$check_saved_order->get_result(); /* Get the set of results and store it: */

        if($result->num_rows==0){ /* If the order was not found insert the new order into the database: */
            /* Insert the order details into the orders table: */
            /* Prepare the statement: */
            $insert_order=$connect->prepare("
            INSERT INTO orders (
            reference_number,
            total,
            shipping,
            order_date,
            user_id
            )
            VALUES (?,?,?, CURRENT_DATE(), ?)
            ");

            $insert_order->bind_param("sddi", $reference_number, $new_total, $shipping, $user_id); /* Bind the parameters: */
            $insert_order->execute(); /* Execute the statement: */

            /* Get the order_id from the order that was inserted: */
            $order_id=$insert_order->insert_id;

            /* Insert the product details into the order details table: */
            $insert_order_details=$connect->prepare("
            INSERT INTO order_details (
            order_id,
            product_name,
            quantity,
            price
            )
            VALUES (?,?,?,?)
            ");

            foreach($order_details as $product){ /* Iterate through the array defined in the checkout.php file: */
                $insert_order_details->bind_param("issd", $order_id, $product['name'], $product['quantity'], $product['price']);/* Bind the parameters: */
                $insert_order_details->execute();  /* Execute the statement: */
            }

            /* After saving the order, delete the products from the users cart: */
            $empty_cart=$connect->prepare("
            DELETE FROM cart
            WHERE user_id=?
            ");

            $empty_cart->bind_param("i",$user_id); /* Bind the parameter: */
            $empty_cart->execute(); /* Execute the statement: */

            echo '<script>alert("Thank you, your order has been saved!");</script>';  /* Display a thank you message to the user: */
            header('Refresh: 1; url=index.php'); /* Redirect to the home page: */
            unset($_SESSION['reference_number']); /* Unset the reference number so that the next time the user places an order, they get a new reference number: */
            exit(); 
        }else{ /* The order has already been saved, display an error message and redirect to the checkout page:*/
            echo '<script>alert("This order already exists. Please try again.");</script>';
            header('Refresh: 1; url=checkout.php'); 
            exit();
        }
    }else{ /* User id and reference number could not be retrieved, display an error message and redirect to the login page: */
        echo '<script>alert("You do not have permission to access this page.")</script>'; //Display an error message:
        header('Refresh: 1; url=login.php');
        exit();
    }
?>