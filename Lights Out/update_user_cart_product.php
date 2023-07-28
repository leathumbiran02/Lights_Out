<?php
    session_start(); //Start the session:
      
    //Check if the product id is provided in the URL:
    if(!isset($_GET['id'])){
        echo "<script>alert('No product id was found!')</script>";
        echo "<script>window.location.href='user_cart.php';</script>"; /* Using Javascript window.location to redirect the user after displaying the alert: */
        exit();
    }

    //Checking if the person is logged in as a user:
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in as a user to access this page.')</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    //If the connection fails display an error:
    if($connect->connect_error){
    die("Connection failed!" . $connect->connect_error);
    }

    //Using prepared statements with parameterized queries:
    //Prepare the statement to get the product details from the product table:
    $get_product_from_cart=$connect->prepare("
    SELECT p.name, p.long_description, p.price, p.image_link, cp.quantity
    FROM products p
    INNER JOIN cart_products cp ON p.product_id=cp.product_id
    WHERE p.product_id=?;
    ");

    $get_product_from_cart->bind_param("i", $_GET['id']); //Bind the parameter, i is used to specify that the parameter type is an integer:
    $get_product_from_cart->execute(); //Execute the statement:
    $result = $get_product_from_cart->get_result(); //Get the set of results:

    //If the product was not found in the cart_products table, redirect the user back to the user cart page:
    if($result->num_rows==0){
        echo "<script>alert('The product was not found in your cart. Please try again.')</script>"; //Display an error message to the user:
        echo "<script>window.location.href='user_cart.php';</script>";
        exit();
    }

    //After the user submits the update quantity form, update the quantity in the cart_products table:
    if(isset($_POST['submit'])){
        //Post the quantity entered to the database:
        $quantity=mysqli_real_escape_string($connect, $_POST['quantity']);

        //Using prepared statements with parameterized queries:
        //Prepare the statement to update the product in the products table:
        $update_product_in_cart=$connect->prepare("
        UPDATE
        cart_products
        SET
        quantity=?
        WHERE product_id =?
        ");
        
        $update_product_in_cart->bind_param("ii",$quantity, $_POST['product_id']); //Bind the parameters:

        //Execute the statement:
        if($update_product_in_cart->execute()){ //If the quantity is updated, then the user is redirected to the user cart page:          
            echo "<script>alert('The product in your cart was updated successfully!')</script>"; //Display success message to the vendor:
            echo "<script>window.location.href='user_cart.php';</script>";
            /* header('Refresh:1; url=user_cart.php'); */ //Redirect to the user_cart page:
            exit();
        }else{ //if the product quantity fails to update, display an error message:
            echo "<script>alert('The product quantity could not be updated. Please try again.')</script>";
            echo "<script>window.location.href='user_cart.php';</script>";
            /* header('Refresh:1; url=user_cart.php'); */ //Redirect to the user_cart page:
            exit();
        }
    }  
    /* Closing the database connection: */
    $connect->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page-->
        <title>Lights Out</title>
        <!--Using a CSS style sheet for the page-->
        <link rel='stylesheet' href='style.css'>
            
        <style>
            input[type="number"]{
                border: 2px solid rgb(46,114,215,1);
                color: #ffffff;
                padding: 10px 15px;
                background-color: transparent;
                width:35%;
                border-radius:5px;
                font-size: 2em;
            }
            header{
                box-shadow: 0 5px 10px rgb(46,114,215,1);
            }
            .hero h1{
                text-align: center;
            }
            .product_details_info ul{
                background: linear-gradient(to right, rgba(46, 114, 215, 0.3), rgba(101, 43, 252, 0.3));
                padding:10px;
                border: 2px solid rgb(46,114,215,1);
                border-radius: 5px;
            }
            .product_details_info ul li{
                list-style-type: none; /* Hide the bullet point symbols */
            }
            .addbutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgba(46, 114, 215, 0.3), rgba(101, 43, 252, 0.3));
                cursor: pointer;
                display: initial;
                padding: 20px;
                width:35%;
                color: #ffffff;
                font-size: 21px;
                font-weight: bold;
                text-align:center;
                transition: background-color 0.3s ease-in-out;
                text-decoration: none;
                margin:20px 0;
            }
            .back_to_products{
                margin-left:90px;
            }
            @media(max-width:1080px){ /* Media queries to center the back to products link under the add to cart button: */
                .back_to_products{
                    margin-left:-10px;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <?php
                /* Including the file that contains the menu: */
                include 'menu.php';
            ?>
        </header>
            
        <div class='hero'>
            <?php
            /* Create an HTML form for the user to edit the quantity of the product: */
                if($row=$result->fetch_assoc()){

                    echo    "<h1>" . $row["name"] . "</h1>"; /* Product Name: */
                    echo    "<div class='product_details_page'>";
                    echo        "<div class='product_details_image_box'>";
                    echo            "<img class='product_details_img' src='" . $row["image_link"] . "' />"; /* Product Image: */
                    echo        "</div>";
                    echo        "<div class='product_details_info'>";

                    /* Product Description: */
                    /* Splitting the long description from the database into sentences: */
                    $long_description =preg_split('/(?<=[.?!])\s+/',$row["long_description"]);

                    /* Displaying each sentence as a bullet point: */
                    echo            "<ul>";
                    foreach ($long_description as $description){
                        echo            "<li class='product_details_description'><i>{$description}</i></li>";
                    }
                    echo            "</ul>";

                    echo            "<span class='product_details_price'> R" . $row["price"] . "</span>"; /* Product Price: */

                    /* Create a form to add products to cart for the user: */
                    echo            "<form action='update_user_cart_product.php?id=" . $_GET['id'] . "' method='POST'>";
                    echo                "<input type='number' name='quantity' min='1' step='1' value=" . $row['quantity'] . ">"; /* Quantity Box: */
                    echo                "<input type='hidden' name='product_id' value='" . $_GET['id']. "'><br>"; /* Used to store the product id: */
                    echo                "<button class='addbutton' type='submit' name='submit'>Update Quantity</button>"; /* Add To Cart Button: */
                    echo                "<br><div><a  href='user_cart.php' class='back_to_products'>BACK TO CART</a></div>";
                    echo            "</form>";
                }
                echo        "</div>";
                echo    "</div>";
            ?>
        </div>
    </body>
</html>