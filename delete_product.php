<?php
    //Starting the session to check that the user is logged in:
    session_start();
    
    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the db_config.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    //If the connection fails display an error:
    if($connect->connect_error){
        die("Connection failed!" . $connect->connect_error);
    }

    //Checking if the person logged in is a vendor:
    if(!isset($_SESSION['vendor_id'])){
        echo "<script>alert('You must be logged in as a vendor to access this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    //Checking if the product id is provided in the URL:
    if(isset($_GET['id'])){
        $product_id=$_GET['id']; //Get the product_id and store it in $product_id:

        //Using prepared statements with parameterized queries:
        //Delete the product from the database based on its product_id:
        $deleteProduct=$connect->prepare("
        DELETE 
        FROM 
        products 
        WHERE product_id=?
        "); 

        $deleteProduct->bind_param("i",$product_id); //Bind the parameter:

        If($deleteProduct->execute()){ //If the query runs successfully, display a success message and redirect to the products page:
            echo "<script>alert('The product has been deleted successfully!')</script>";
            header('Refresh: 1; url=products.php');
            exit();
        } else{ //If there was an error when deleting the product, display an error message and redirect to the products page: 
            echo "<script>alert('Failed to delete the product. Please try again.')</script>"; 
            header('Refresh: 1; url=products.php');
            exit();
        }
    } else{  //If there was no product id found in the URL, display an error message:
        echo "<script>alert('No product id was provided. Please try again.')</script>";
        header('Refresh: 1; url=products.php');
        exit();
    }
?>