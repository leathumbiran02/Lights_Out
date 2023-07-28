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
            h5{
                font-size:1.1em;
            } 
            .product{
                background-color: black;
                opacity: 95%;
            }
            header{
                box-shadow: 0 5px 10px rgb(46,114,215,1);
            }
            .addbutton, .updatebutton, .deletebutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgb(46,114,215,1), rgb(101,43,252,1));
            }
            .hero .cart{
                font-weight: bolder;
                font-size: 25px;
                color: #000000;
                width:50px;
                height:auto;
                border-radius: 10px;
            }
            .addbutton{
                cursor: pointer;
                display: initial;
                padding: 15px;
                width:30%;
                color: #ffffff;
                font-size: 21px;
                font-weight: bold;
                text-align:center;
                transition: background-color 0.3s ease-in-out;
                text-decoration: none;
                margin:20px;
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
            <!--Title of the Page: All Products-->
            <h1 class="main-header"><image class="cart" src="images/cart.png" alt="My Cart">Cart</h1>

            <div id="products">
                <!-- All the products from the database will be displayed here: -->
                <?php 
                    include 'get_user_cart_products.php'; 
                ?>
            </div>
        </div>

        <!-- Provide the link for the JQuery Library: -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Preventing the user from clicking outside of the buttons using Javascript: -->
        <script>
            $(document).ready(function(){
                /* Ensuring that the user cannot click outside of the add button, view button, update button, as well as making sure that the menu (which is located in the header) and the product-img remain responsive: */
                $(document).on('click', function(event){
                    if(!$(event.target).closest('.addbutton, .viewbutton, .updatebutton, .deletebutton, header, .product-img').length && !$(event.target).is('.deletebutton')){
                        event.preventDefault();
                    }
                });
            });
        </script>
    </body>
</html>