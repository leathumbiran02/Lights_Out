<?php
    session_start(); //Start the session:

    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    //If the connection fails display an error:
    if($connect->connect_error){
    die("Connection failed!" . $connect->connect_error);
    }
      
    //Check if the product id is provided in the URL:
    if(!isset($_GET['id'])){
        echo "<script>alert('No product id was found!')</script>";
        header('Refresh: 1; url=products.php');
        exit();
    }

    //Checking if the person logged in is a vendor:
    if(!isset($_SESSION['vendor_id'])){
        echo "<script>alert('You must be logged in as a vendor to access this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    //Using prepared statements with parameterized queries:
    //Prepare the statement to get the product details from the product table:
    $getProduct=$connect->prepare("
    SELECT 
    *
    FROM
    products
    WHERE product_id = ?
    ");

    $getProduct->bind_param("i", $_GET['id']); //Bind the parameter, i is used to specify that the parameter type is an integer:
    $getProduct->execute(); //Execute the statement:
    $result = $getProduct->get_result(); //Get the set of results:

    //If the product was not found in the products table, redirect the vendor back to the products page:
    if($result->num_rows==0){
        echo "<script>alert('The product was not found. Please try again.')</script>"; //Display an error message to the vendor:
        header('Refresh: 1; url=products.php');
        exit();
    }

    //After the vendor submits the product form, update the product details in the products table:
    if(isset($_POST['submit'])){
        //Post each item entered in the form to the database:
        $name= mysqli_real_escape_string($connect,$_POST['name']);
        $longDescription= mysqli_real_escape_string($connect,$_POST['long_description']);
        $price=mysqli_real_escape_string($connect, $_POST['price']);
        $image_link=mysqli_real_escape_string($connect, $_POST['image_link']);

        //Using prepared statements with parameterized queries:
        //Prepare the statement to update the product in the products table:
        $updateProduct=$connect->prepare("
        UPDATE
        products
        SET
        name=?,
        long_description=?,
        price=?,
        image_link=?
        WHERE product_id =?
        ");
        
        $updateProduct->bind_param("ssdsi",$name,$longDescription,$price,$image_link, $_GET['id']); //Bind the parameters:

        //Execute the statement:
        if($updateProduct->execute()){ //If the product is updated, then the vendor is redirected to the product's page:          
            echo "<script>alert('The product was updated successfully!')</script>"; //Display success message to the vendor:
            header('Refresh:1; url=products.php'); //Redirect to the products page:
            exit();
        }else{ //if the product fails to update, display an error message:
            echo "<script>alert('Product could not be updated. This could be due to: " . htmlspecialchars($connect->error, ENT_QUOTES) . "')</script>";
            header('Refresh:1; url=products.php'); //Redirect to the products page:
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
            h5{
                font-size:1.1em;
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
            /* Create an HTML form for the vendor to edit the product details in: */
                while($row=$result->fetch_assoc()){
                    header('Content-Type: text/html; charset=UTF-8');
                    echo            "<form class='update-form' name='updateform' method='POST' action='update_product.php?id=" . $_GET['id'] . "'>";
                    echo                "<div class='form-content'>";
                    echo                    "<!--Title of the Page: Update Products-->
                                            <h1 class='main-header'>Update Product:</h1>";

                                            /* Product Name: */
                    echo                    "<label for='name'>Product Name:</label>";
                    echo                    "<input type='text' id='name' name='name' value='" . $row['name'] . "'required/>";

                                            /* Long Description: */
                    echo                    "<label for='long_description'>Long Description:</label>";
                    echo                    "<textarea type = 'textarea'  id='long_description' name='long_description' required>" . $row['long_description'] . "</textarea>";

                                            /* Price: */
                    echo                    "<label for='price'>Price:</label>";
                    echo                    "<input type='number' step='0.01' min='0' id='price' name='price' value='" . $row['price'] . "'required/>";

                                            /* Image URL: */
                    echo                    "<label for = 'image_link'>Link To Image:</label>";
                    echo                    "<textarea type = 'textarea' id='image_link' name='image_link' required>" . $row['image_link'] . "</textarea>";

                                            /* Update Button: */
                    echo                    "<input type='submit' name='submit' value='Update Product' style='font-weight:bold; color:black;'>";
                    echo                "</div>";
                    echo            "</form>";
                }
            ?>
            <!-- An Extra button is added to navigate back to the products page: -->
            <div class="center-text">
            <a style="padding:15px; width:80%; color:white; font-size: 16px;" href="products.php">BACK TO PRODUCTS</a>
            </div>
        </div>
    </body>
</html>