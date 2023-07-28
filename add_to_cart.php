<?php
    //Starting the session:
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');

    //Checking if the person logged in is a user:
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in as a user to access this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }
    
    //Creating a connection to the database using the variables in the dbconfig.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    /* Execute this code if the product_id and quantity are posted: */
    if(isset($_POST['product_id']) && isset($_POST['quantity'])){
        /* Retrieve the product id and quantity from the form: */
        $product_id=$_POST['product_id']; 
        $quantity=$_POST['quantity'];

        /* Retrieve the user's id from the session: */
        $user_id=$_SESSION['user_id'];

        /* If the user does not have a cart, create a cart: */
        $cart_id=null;

        /* Store the date the cart was created in the database: */
        $created_date=date('Y-m-d');

        /* Check if the user has a cart: */
        /* Using prepared statements with parameterised queries: */
        /* Prepare the statement: */
        $check_cart=$connect->prepare("
        SELECT cart_id
        FROM cart
        WHERE user_id =?");

        $check_cart->bind_param("i",$user_id); /* Bind the parameter: */
        $check_cart->execute();/* Execute the statement: */
        $result=$check_cart->get_result(); /* Store the result set: */

        /* If an entry was found (the user has a cart) fetch their cart_id: */
        if($result->num_rows>0){
            $cart_id_row=$result->fetch_assoc();
            $cart_id=$cart_id_row['cart_id'];
        }else{
            /* If an entry was not found, create a cart for the user: */
            /* Prepare the statement: */
            $create_cart=$connect->prepare("
            INSERT INTO cart (
            user_id, 
            created_date
            )
            VALUES (?,?)");

            /* Using prepared statements with parameterised queries: */
            $create_cart->bind_param("is",$user_id,$created_date); /* Bind the parameters: */
            $create_cart->execute(); /* Execute the statement: */
            $cart_id=$connect->insert_id;
        }

        /* Check if the product selected already exists in the user's cart: */
        /* Prepare the statement: */
        $check_product_in_cart=$connect->prepare("
        SELECT *
        FROM cart_products
        WHERE cart_id=?
        AND product_id=?
        ");

        $check_product_in_cart->bind_param("ii",$cart_id,$product_id); /* Bind the parameters: */
        $check_product_in_cart->execute(); /* Execute the statement: */
        $result=$check_product_in_cart->get_result(); /* Get the set of results: */

        /* If the product already exists in the cart, update the quantity of the product: */
        if($result->num_rows > 0){
            $existing_product = $result->fetch_assoc(); /* If the user already has a product in their cart fetch the associated product: */
            $existing_quantity = $existing_product['quantity']; /* Store the quantity of that product in a variable called $existing_quantity: */
            $new_quantity = $existing_quantity + $quantity; /* Add $existing_quantity and the quantity selected by the user, store the result in a new variable called $new_quantity: */

            /* Update the quantity of the product in the user's cart: */
            /* Prepare the statement: */
            $update_quantity=$connect->prepare("
            UPDATE cart_products
            SET quantity=?
            WHERE cart_id=? AND product_id=?
            ");

            $update_quantity->bind_param("iii",$new_quantity,$cart_id,$product_id); /* Bind the parameters: */
            $update_quantity->execute(); /* Execute the statement: */
            $result=$update_quantity->get_result(); /* Get the set of results: */
        }else{ /* The product is not in the users' cart, so insert the product that the user selected into the cart_products table: */
            $insert_product="
            INSERT INTO cart_products (
            cart_id,
            product_id,
            quantity
            )
            VALUES (?,?,?)";

            /* Using prepared statements with parameterised queries: */
            $insert_product_statement=$connect->prepare($insert_product); /* Prepare the statement: */
            $insert_product_statement->bind_param("iii",$cart_id,$product_id,$quantity); /* Bind the parameters: */
            $insert_product_statement->execute(); /* Execute the statement: */
        }
        /* After inserting the products successfully, display a message to the user and redirect the user back to the page that they were viewing: */
        echo "<script>alert('This product has been added to your cart!')</script>";
        header("Refresh: 1; url=".$_SERVER['HTTP_REFERER']); 
        exit();
    }else{  /* If the code fails, display an error message and redirect the user back to the products page:*/
        echo "<script>alert('Could not add product to cart. Please try again.')</script>";
        header('Refresh:1; url=products.php');
        exit();
    }
?>