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

    //Check if the blog_id is provided in the URL:
    if(!isset($_GET['id'])){
        echo "<script>alert('No blog id was found!')</script>";
        header('Refresh: 1; url=blog.php');
        exit();
    }

    //Checking if the person logged in is a vendor:
    if(!isset($_SESSION['vendor_id'])){
        echo "<script>alert('You must be logged in as a vendor to access this page')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }

    //Using prepared statements with parameterized queries:
    //Prepare the statement to get the blog post details from the blog_post table:
    $getProduct=$connect->prepare("
    SELECT 
    *
    FROM
    blog_post
    WHERE blog_id = ?
    ");

    $getProduct->bind_param("i", $_GET['id']); //Bind the parameter, i is used to specify that the parameter type is an integer:
    $getProduct->execute(); //Execute the statement:
    $result = $getProduct->get_result(); //Get the set of results:

    //If the blog post was not found in the blog_post table, redirect the vendor back to the blog page:
    if($result->num_rows==0){
        echo "<script>alert('The blog post was not found. Please try again.')</script>"; //Display an error message to the vendor:
        header('Refresh: 1; url=blog.php');
        exit();
    }

    //After the vendor submits the blog form, update the blog post details in the blog_post table:
    if(isset($_POST['submit'])){
        //Post each item entered in each column to the database:
        $title= mysqli_real_escape_string($connect,$_POST['title']);
        $blog_url= mysqli_real_escape_string($connect,$_POST['blog_url']);
        $image_link=mysqli_real_escape_string($connect, $_POST['image_link']);

        //Using prepared statements with parameterized queries:
        //Prepare the statement to update the product in the products table:
        $update_blog=$connect->prepare("
        UPDATE
        blog_post
        SET
        title=?,
        blog_url=?,
        image_link=?
        WHERE blog_id =?
        ");
        
        $update_blog->bind_param("sssi",$title,$blog_url,$image_link, $_GET['id']); //Bind the parameters:

        //Execute the statement:
        if($update_blog->execute()){ //If the blog post is updated, then the vendor is redirected to the blog page:          
            echo "<script>alert('The blog post was updated successfully!')</script>"; //Display success message to the vendor:
            header('Refresh:1; url=blog.php'); //Redirect to the blog page:
            exit();
        }else{ 
            //if the blog post fails to update, display an error message:
            echo "<script>alert('The blog post could not be updated. Please try again.')</script>";
            header('Refresh:1; url=blog.php'); //Redirect to the blog page:
            exit();
        }
    }   
    //Closing the database connection:
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
            <!-- Including the file that contains the menu: -->
            <?php 
            include 'menu.php';
            ?>
        </header>
            
        <div class='hero'>
            <?php
                /* Create an HTML form for the vendor to edit the product details in: */
                    while($row=$result->fetch_assoc()){
                        header('Content-Type: text/html; charset=UTF-8');
                        echo            "<form class='update-blog-form' name='update-blog-form' method='POST' action='update_blog.php?id=" . $_GET['id'] . "'>";
                        echo                "<div class='form-content'>";
                        echo                    "<!--Title of the Page: Update Blog Post-->
                                                <h1 class='main-header'>Update Blog Post:</h1>";

                                                /* Blog Title: */
                        echo                    "<label for='title'>Title:</label>";
                        echo                    "<input type='text' id='title' name='title' value='" . $row['title'] . "'required/>";
                                
                                                /* Blog URL: */
                        echo                    "<label for='blog_url'>Short Description:</label>";
                        echo                    "<textarea type = 'textarea' id='blog_url' name='blog_url' required>" . $row['blog_url'] . "</textarea>";

                                                /* Image URL: */
                        echo                    "<label for = 'image_link'>Link To Image:</label>";
                        echo                    "<textarea type = 'textarea' id='image_link' name='image_link' required>" . $row['image_link'] . "</textarea>";

                                                /* Update Button: */
                        echo                    "<input type='submit' name='submit' value='Update' style='font-weight:bold; color:black;'>";

                        echo                "</div>";
                        echo            "</form>";     
                    }
            ?>
            </br>
            <!-- An Extra button is added to navigate back to the products page: -->
            <div class="center-text">
                <a style="padding:15px; width:80%; color:white; font-size: 16px;" href="blog.php">BACK TO BLOG POSTS</a>
            </div>
        </div>
    </body>
</html>



