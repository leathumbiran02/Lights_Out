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
                border: 2px solid rgb(101,43,252,1);
            }
            .viewbutton, .addbutton, .updatebutton, .deletebutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgb(101,43,252,1), rgb(176,20,252,1));
            }
            a.viewbutton, a.addbutton, a.updatebutton, a.deletebutton{
                display: inline-block;
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
        <div class="hero">
            <!--Title of the Page: All Products-->
            <h1 class="main-header">All Products</h1>

            <div id="products">
                <!-- All the products from the database will be displayed here: -->
                <?php 
                include 'get_products.php'; 
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