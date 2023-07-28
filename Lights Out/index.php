<?php
    //Starting the session so we can check if the user is logged in:
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css">

        <style>
            p{ /* Styling for the notice on the home page: */
                padding: 30px;
                color:#ffffff;
                font-size: 2.5em;
                text-align: center;
                margin-bottom: 20px;
                background-color: #000000;
                font-weight: bold;
                font-family: 'Georgia', serif;
                border-radius: 15px;
                border: 2px solid rgb(57,161,180,1);
                line-height:80px;
            }
            .hero{ /* Centering the text: */
                text-align: center;
            }
            header{ /* Changing the colour of the shadow on the top menu: */
                box-shadow: 0 5px 10px rgb(57,161,180,1);
            }
            .addbutton { /* Shop Now Button */
                background: linear-gradient(to right, rgb(57,161,180,1), rgb(46,114,215,1));
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
            <h1 class="main-header">Notice</h1> <!--First Heading on Page:-->

            <p> <!--Paragraph about special on shipping for all products-->
                In celebration of launching our website enjoy up to 30% off on all shipping! <br>
                Valid only from 26 May 2023 to 26 June 2023<br>
                Don't miss out!
            </p>

            <!--Button that Navigates to the products page:-->
            <a href="products.php"><button class="addbutton">Shop Now</button></a>

            <h1 class="main-header">Latest Products</h1> 

            <!-- Include the php file to get the products to display on the home page: -->
            <?php
                include 'get_home_products.php';
            ?>

            <div class="scroll-menu snaps-inline">
                <!--Showing latest products in a scrollable menu:-->
                <?php
                    /* Define a counter so that we can specify how many products that we want to display on the home page: */
                    /* Initialise the counter to 0 */
                    $counter=0;

                    foreach($products as $product){ 
                       /* If the counter is less than 5, then display 5 products in a scrollable menu: */
                        if($counter < 5){
                            ?>
                                <!-- Display a product based on its product_id in the database. Fetch each product image and name and display it in the scrollable menu: -->
                                <div class="special-img">
                                    <a href="product_details.php?id=<?php echo $product['product_id']; ?>"><img src="<?php echo $product['image_link']; ?>" alt="<?php echo $product['name']; ?>"></a>
                                    <h3 class="product-title"><?php echo $product['name']; ?></h3>
                                </div>
                            <?php
                            /* Increment the counter: */
                            $counter++;
                        }
                    }
                ?>
            </div><br>
        </div>
    </body>
</html>