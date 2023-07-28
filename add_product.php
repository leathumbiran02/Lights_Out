<?php
    //Starting the session so we can check if the user is logged in:
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');

    //Checking if the person logged in is a vendor:
    if(!isset($_SESSION['vendor_id'])){
        echo "<script>alert('You must be logged in as a vendor to access this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    if(isset($_POST['submit'])){
        //Creating a connection to the database using the variables in the db_config.php file:
        $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        
        //Get the information about the product from the form and sanitise it:
        $name=mysqli_real_escape_string($connect, $_POST['name']);
        $long_description=mysqli_real_escape_string($connect, $_POST['long_description']);
        $price=mysqli_real_escape_string($connect, $_POST['price']);
        $image_link=mysqli_real_escape_string($connect, $_POST['image_link']);

        //If the connection fails display an error:
        if(!$connect){
            die("Connection failed! " . mysqli_connect_error());
        }

        //Validate the values entered in the form:
        if(empty($name)||empty($long_description)||empty($price)||empty($image_link)){
            die("All fields are required.");
        }

        //Check that price is numeric, if it is not display an error message:
        if(!is_numeric($price)){
            die("Price entered must be a number. Please try again.");
        }

        //Using prepared statements with parameterized queries:
        //Prepare the statement for the products table:
        $statement=$connect->prepare("
        INSERT INTO products (
        vendor_id,
        name,
        long_description,
        price,
        image_link)
        VALUES (1,?,?,?,?)
        ");

        $statement->bind_param("ssds",$name,$long_description,$price,$image_link); //Bind the parameters:

        //Execute the statement:
        if($statement->execute()){ /* Statement executes, display a success message and redirect to the products page: */
            echo "<script>alert('The product was added successfully!')</script>"; 
            header('Refresh:1; url=products.php'); 
            exit();
        }else{ /* Statement fails, display an error message and redirect to the products page: */
            echo "<script>alert('Product could not be added. Please try again.')</script>";
            header('Refresh:1; url=products.php');
        }
        //Closing the database connection:
        $connect->close();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <!-- Including the file that contains the menu: -->
            <?php 
                include 'menu.php';
            ?>
        </header>

        <div class="hero">
            <!--Creating an add product form that sends the information to the database so that it can be stored in the products table:-->
            <form class = "addproduct-form" name = "addproduct" action = "add_product.php" method = "POST">
                <div class="form-content">
                    <h1 class="main-header">Add Product:</h1> <!--First Heading on Page-->

                    <label for = "name">Product Name:</label> <!--Product Name:-->
                    <input type = "text" id = "name" name = "name" placeholder = "Enter the name of the product" required/>

                    <label for = "long_description">Long Description:</label> <!--Long Description:-->
                    <textarea id = "long_description" name = "long_description" placeholder = "Write a long description about the product" required></textarea>
                    
                    <label for="price">Price:</label> <!-- Price: -->
                    <input type="number" step="0.01" min="0" name="price" placeholder="Enter the price of the product" required>

                    <label for = "image_link">Link To Image:</label> <!--Link To Image:-->
                    <textarea type = "url" id="image_link" name="image_link" placeholder="Enter the URL for the product image" required></textarea><br>

                    <!--Button to submit the form:-->
                    <input type = "submit" name = "submit" value = "Add Product" style="font-weight:bold; color:black;"/> <!-- Adding additional styling to the button: -->
                </div>
            </form>

            <!-- An Extra button is added to navigate back to the products page: -->
            <div class="center-text">
                <br><a style="margin-top:0px; padding:15px; width:80%; color:white; font-size: 16px;" href="products.php">BACK TO PRODUCTS</a>
            </div>
        </div>
    </body>
</html>