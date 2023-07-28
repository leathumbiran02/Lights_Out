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

    //Checking if the blog_id is provided in the URL:
    if(isset($_GET['id'])){
        $blog_id=$_GET['id']; //Get the blog_id and store it in $blog_id:

        //Using prepared statements with parameterized queries:
        //Delete the blog post from the database based on its blog_id:
        $deleteBlog=$connect->prepare("
        DELETE 
        FROM 
        blog_post 
        WHERE blog_id=?
        "); 

        $deleteBlog->bind_param("i",$blog_id); //Bind the parameter:

        If($deleteBlog->execute()){   //If the query runs successfully, display a success message and redirect to the blog page:
            echo "<script>alert('The blog post has been deleted successfully!')</script>"; 
            header('Refresh: 1; url=blog.php');
            exit();
        } else{  //If there was an error when deleting the blog post, display an error message and redirect to the blog page: 
            echo "<script>alert('Failed to delete the blog post. Please try again.')</script>"; 
            header('Refresh: 1; url=blog.php');
            exit();
        }
    } else{  //If there was no blog_id found in the URL, display an error message:
        echo "<script>alert('No blog id was provided. Please try again.')</script>"; 
        header('Refresh: 1; url=blog.php');
        exit();
    }
?>