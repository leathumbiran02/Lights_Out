<?php
    /* Starting the session to check if the user is logged in: */
    session_start();

    /* Using the database configuration file: */
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    $total = 0; /* Initialise a variable to store the total amount that will be displayed to the user: */
    $order_details=array(); /* Create an array to store the product details as well as the quantity for the order:*/

    /* If the user_id is stored in the session execute the following code: */
    if(isset($_SESSION['user_id'])){

        $user_id=$_SESSION['user_id']; /* Fetch the user_id and store it: */

        /* Retrieve the user's products from their cart: */
        /* Prepare the statement: */
        $get_cart_products=$connect->prepare("
        SELECT cp.quantity, p.name, p.price
        FROM cart_products cp
        INNER JOIN products p ON cp.product_id=p.product_id
        WHERE cp.cart_id=(
            SELECT cart_id
            FROM cart
            WHERE user_id=?
            )
        ");

        $get_cart_products->bind_param("i",$user_id); /* Bind the parameter: */
        $get_cart_products->execute(); /* Execute the statement: */
        $result=$get_cart_products->get_result(); /* Get the set of results: */

        if($result->num_rows>0){ /* If a row was found: */
            while($row=$result->fetch_assoc()){  /* Iterate through the product in th users cart and calculate the total amount: */
                $quantity=$row['quantity']; /* Fetch the quantity and store it: */
                $price=$row['price']; /* Fetch the price and store it: */
                $subtotal = $quantity * $price; /* Multiply the quantity of the product by its price: */
                $total += $subtotal; /* Add all the subtotals together to make the final total of the order: */

                //When going through the products in the cart, store it in an array called product_details:
                //Store the product name, quantity and price:
                $product_details=array(
                    'name'=>$row['name'],
                    'quantity'=>$quantity,
                    'price'=>$price
                );

                $order_details[]=$product_details; /* Set the product_details array equal to the order_details array defined above: */
            }
        }

        $shipping=75; /* Shipping amount to 75 */
        $new_total=$total+$shipping; /* Add the shipping amount to the total: */

        if(isset($_POST['save_order'])){ /* If the save order button is pressed execute the following code: */
            /* Call the save order file that is used to save the order, order details and empty the users' cart: */
            require_once('save_order.php');
        }

        if(!isset($_SESSION['reference_number'])){ /* If the reference_number is not found in the session execute the following code: */
            /* Call the reference_number.php file to generate a randomised reference number: */
            require_once('reference_number.php');
            $_SESSION['reference_number']=$reference_number;/* Store the reference number that was generated: */
        }
    }
    /* Close the database connection: */
    $connect->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Referencing a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css">
        
        <style>
            body{ /* Adding a background image to the page: */
                width: 100%;
                padding: 20px;
                background-image: url(images/pxfuel.jpg);
                background-position:center;
                background-size:cover;
                background-attachment: fixed;
            }
            #btn{ /* Styling of the heading on the page: */
                width: 250px;
            }
            .register_login_btn_box{ /* Styling of the heading on the page: */
                width: 250px;
                box-shadow: none;
            }
            .remember_password{
                bottom:320px;
                font-size:21px;
            }
            .total{ /* Used to display the total cost of the order: */
                font-size:21px;
            }
            .login_input_group{ /* Used to display the order details, error messages when a user is not logged in and if their cart is empty: */
                top:270px;
                width: 550px;
            }
            .form-box{ /* To display the Order Summary: */
                width: 550px;
                height: 600px;
                position: relative;
                margin: 6% auto;
                background-color: rgb(9,6,25,1);
                opacity: 95%;
                border-radius: 10px;
                padding: 5px;
            }
            #forgot{
                left:20px;
            }
            .forgot_password{
                color: #ffffff;
                font-size: 17px;
                bottom:-10px;
                position: relative;
            }
            .user-info{ /* Used to display the payment details: */
                width: 90%;
            }
            table{ /* Used to adjust the text size for the payment details: */
                font-size: 1.1em;
            }
            .save_order{ /* Button when saving order and emptying the cart */
                cursor: pointer;
                display: block;
                margin: 10px auto; /* Centers the button: */
                padding: 3px;
                width:25%;
                background-color: rgb(101,43,252,1);
                color: #ffffff;
                opacity: 100%;
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                border: 2px solid rgb(0, 0, 0);
                border-radius: 10px;
                transition: background-color 0.3s ease-in-out;
                text-decoration: none;
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
        <div class="form_page"> <!-- The body of the page: -->
            <div class="form-box"> <!-- Div used to display the Order Summary: -->
                <div class="register_login_btn_box"> <!-- Used to dislay the heading on the page: -->
                    <div id="btn"></div>
                    <button type="button" class="toggle_register_login_btn">ORDER SUMMARY</button> 
                </div>

                <?php
                    if(isset($_SESSION['user_id'])){ /* If the user is logged in: */
                        if($result->num_rows>0){ /* If a row or multiple rows were found: */
                            while ($row=$result->fetch_assoc()){ /* while fetching the rows display the following: */
                                echo "<p>" . $row['name'] . " - R" . $row['price'] . "</p>";
                            }
    
                            /* Display the total: */
                            echo "<div class='center-text'>";
                            echo    "<h1 class='total'>Total: R" . $total . " + R75 shipping = R" . $new_total . "</h1>"; /* Show the total plus shipping: */
                            echo "</div>";

                        } else{ /* The users cart is empty: */
                            echo "<div class='login_input_group'>";
                            echo    "<div class='center-text'>";
                            echo        "<h2 style='color:#80eeff;'>No products were found in your cart.</h2>"; //Display an error message directly on the page:
                            echo    "</div>";
                            echo "</div>";

                            exit();
                        }
                    }else{ /* The user is not logged in: */
                        echo "<div class='login_input_group'>";
                        echo    "<div class='center-text'>";
                        echo        "<h2 style='color:#80eeff;'>Please log in to view your order.</h2>"; //Display an error message directly on the page:
                        echo    "</div>";
                        echo "</div>";

                    }
                ?>

                <div class="login_input_group"> <!-- Div used to display the subheading, bank details and a Go back button on the page: -->

                    <?php
                        if (isset($_SESSION['user_id'])){
                            echo    "<div class='center-text'>
                                        <h1 class='remember_password'>For your order to be processed, please make the following payment into the account below:</h1>
                                    </div>
                                    <div class='user-info'>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <th>
                                                            Bank Name:
                                                        </th>
                                                    </td>
                                                    <td>
                                                        <th>
                                                            First National Bank
                                                        </th>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <th>
                                                            Account Number:
                                                        </th>
                                                    </td>
                                                    <td>
                                                        <th>
                                                            1234567890
                                                        </th>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <th>
                                                            Reference:
                                                        </th>
                                                    </td>
                                                    <td>
                                                        <th>
                                                            ".$_SESSION['reference_number']."
                                                        </th>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class='center-text'>
                                        <!-- Save Order Button:-->
                                        <form method='POST' action='checkout.php'>
                                            <button type='submit' name='save_order' class='save_order'>Save Order</button>
                                        </form>
                                    </div>

                                    <div class='center-text'>
                                        <!-- Go Back To Cart Page:-->
                                        <a href='user_cart.php'><span class='forgot_password'>Go Back</span></a>
                                    </div>";
                        }
                    ?>
                </div>
            </div>
        </div>     
    </body>
</html>
    