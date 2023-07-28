<?php
    /* Using the database configuration file: */
    require_once('db_config.php');

   //Creating a connection to the database using the variables in the db_config.php file:
   $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

   if(isset($_SESSION['user_id'])){ /* Checking if the user is logged in: */
        $user_id=$_SESSION['user_id']; /* Fetch the user_id from the session and store it: */

        /* Retrieve the user's products in cart (the quantity they selected, name of product, price of product and product image) from the database: */
        /* Prepare the statement: */
        $get_products_in_cart=$connect->prepare("
        SELECT cp.quantity, p.name, p.price, p.image_link, p.product_id
        FROM cart_products cp
        INNER JOIN products p ON cp.product_id = p.product_id
        WHERE cp.cart_id = (
            SELECT cart_id
            FROM cart
            WHERE user_id = ?
        )
        ");

        $get_products_in_cart->bind_param("i",$user_id); /* Bind the parameter: */
        $get_products_in_cart->execute(); /* Execute the statement: */
        $result=$get_products_in_cart->get_result(); /* Get the set of results: */

        if($result->num_rows > 0){ /* If products were found in the users' cart, display the products using HTML: */
            /* Add product button: */
            echo    "<center><a href='products.php'><button class='addbutton' style='margin-top:0px; margin-bottom:30px; width:35%;'>Add Products</button></a></center>";

            /* Proceed to checkout button: */
            echo    "<center><a href='checkout.php'><button class='addbutton' style='margin-top:0px; margin-bottom:30px; width:35%; background-color: rgb(176,20,252,1);'>Proceed To Checkout</button></a></center>";

            echo    "<div class='products-row'>";
            while($row=$result->fetch_assoc()){
                echo        "<div class='product'>";
                echo            "<a href='update_user_cart_product.php?id=" . $row["product_id"] . "'><img class='product-img' src='" . $row["image_link"] . "' alt='" . $row['name'] . "'></a>"; /* Product image: */
                echo            "<div class='product-info'>";
                echo                "<h3 class='product-title'>" . $row["name"] . "</h3>"; /* Product Name: */
                echo                "<span class='product-price-discount'>R" . $row["price"] . "</span>"; /* Product Price: */
                echo                "<span class='product-price-discount'>Quantity: " . $row["quantity"] . "</span>"; /* Quantity that the user has selected: */
                echo                "<a href='update_user_cart_product.php?id=" . $row['product_id'] . "'><button class='updatebutton' style='margin-top:5px; '>Edit</button></a>"; /* Edit quantity button: */
                echo                "<a href='delete_user_cart_product.php?id=" . $row['product_id'] . "' onclick=\"return confirm('Are you sure that you want to delete this product from your cart?');\"><button class='deletebutton' style='margin-top:5px; '>Delete</button></a>"; /* Delete product button: */
                echo            "</div>";
                echo        "</div>";
            }
            echo    "</div>";
        }else{  /* If no products were found in the cart, display an error message: */
            /* Even if the user's cart is empty, they can still add products: */
            echo    "<div class='center-text'>";
            echo        "<h2 style='color:#80eeff;'>Your Cart Is Empty.</h2>"; 
            echo        "<center><a href='products.php'><button class='addbutton' style='margin-top:20px; margin-bottom:30px; width:35%;'>Add Product</button></a></center>";
            echo    "</div>";
        }
    }else{  /* If the user_id could not be retrieved (the user is not logged in) or the code fails for any other reason, display an error message directly on the page: */
        echo        "<div class='center-text'>";
        echo            "<h2 style='color:#80eeff;'>Please log in to view your cart.</h2>"; 
        echo        "</div>";
    }
?>