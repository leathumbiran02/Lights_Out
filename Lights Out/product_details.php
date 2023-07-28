<?php
    //Starting the session so we can check if the user is logged in:
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page:-->
        <link rel="stylesheet" href="style.css">

        <style> /* Applying additional styling for this specific page: */
            input[type="number"]{
                border: 2px solid rgb(46,114,215,1);
                color: #ffffff;
                padding: 10px 15px;
                background-color: transparent;
                width:35%;
                border-radius:5px;
                font-size: 2em;
            }
            .hero h1{
                text-align: center;
            }
            header{
                box-shadow: 0 5px 10px rgb(46,114,215,1);
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
            @media(max-width:1080px){ /* Media queries to center the back to products link under the add to cart button: */
                .back_to_products{
                    margin-left:-10px;
                }
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
            <?php
                //Using the database configuration file:
                require_once('db_config.php');

                //Creating a connection to the database using the variables in the dbconfig.php file:
                $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

                //If the connection fails display an error:
                if($connect->connect_error){
                    die("Connection failed!" . $connect->connect_error);
                }

                if(isset($_GET['id'])){
                    /* Get the id and store it in $id: */
                    $id = $_GET['id'];

                    //Using prepared statements with parameterized queries:
                    //Prepare the statement for the products table:
                    $statement=$connect->prepare("
                    SELECT
                    *
                    FROM
                    products
                    WHERE
                    product_id = ?
                    ");

                    $statement->bind_param("i",$id); //Bind the parameter:
                    $statement->execute(); //Execute the statement:
                    $result=$statement->get_result(); //Get the set of results:

                    if($result->num_rows>0){ //If a row was found execute the following code:
                            $row=$result->fetch_assoc();
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

                        /* If the person logged in is a user display the Add To Cart button: */
                        if(isset($_SESSION['users']) && $_SESSION['users']==true){ 
                            /* Create a form to add products to cart for the user: */
                            echo            "<form action='add_to_cart.php' method='POST'>";
                            echo                "<input type='number' name='quantity' value='1' min='1' step='1'>"; /* Quantity Box: */
                            echo                "<input type='hidden' name='product_id' value='" . $id . "'><br>"; /* Used to store the product id: */
                            echo                "<button class='addbutton'>Add To Cart</button>"; /* Add To Cart Button: */
                            echo                "<br><div><a  href='products.php' class='back_to_products'>BACK TO PRODUCTS</a></div>";
                            echo            "</form>";
                        }else if(isset($_SESSION['vendor']) && $_SESSION['vendor']==true){
                            /* If the person is logged in is a vendor display the rest of the page without the add to cart button: */
                            echo            "<br><div><a  href='products.php' class='back_to_products' style='margin:10px -10px;'>BACK TO PRODUCTS</a></div>";
                            echo        "</div>";
                            echo    "</div>";
                        }
                        else{
                            /* If the person is not logged in (guest user) display a message and the back to products button: */
                            echo            "<h2 style='color:rgb(46,114,215,1);'>Please log in to add this product to cart.</h2>";
                            echo            "<br><div><a  href='products.php' class='back_to_products' style='margin:10px -10px;'>BACK TO PRODUCTS</a></div>";
                            echo        "</div>";
                            echo    "</div>";
                        }
                    } else{ /* If the product id does not exist in the table: */
                        echo        "<div class='center-text'>";
                        echo            "<h2 style='color:#80eeff;'>0 Products Found.</h2>";
                        echo        "</div>";
                    }

                    //Close the prepared statement:
                    $statement->close();
                } else{ 
                    /* If the id could not be retrieved for any other reason:*/
                    echo "<div class='center-text'>";
                    echo    "<h2 style='color:#80eeff;'>Invalid request</h2>";
                    echo "</div>";
                }
                //Closing the database connection:
                $connect->close();
            ?>
        </div>
    </body>
</html>