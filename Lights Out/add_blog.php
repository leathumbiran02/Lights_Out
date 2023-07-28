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

    /* If the submit button is clicked execute the following code: */
    if(isset($_POST['submit'])){
        //Creating a connection to the database using the variables in the db_config.php file:
        $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        
        //Get the information about the blog post from the form and sanitise it:
        $title=mysqli_real_escape_string($connect, $_POST['title']);
        $blog_url=mysqli_real_escape_string($connect, $_POST['blog_url']);
        $image_link=mysqli_real_escape_string($connect, $_POST['image_link']);

        //If the connection fails display an error:
        if(!$connect){
            die("Connection failed! " . mysqli_connect_error());
        }

        //Validate the values entered in the form:
        if(empty($title)||empty($blog_url)||empty($image_link)){
            die("All fields are required.");
        }

        //Check that blog post has a valid URL entered:
        if(!filter_var($blog_url, FILTER_VALIDATE_URL)){
            die("An Invalid URL was provided for the blog post. Please try again.");
        }

        //Using prepared statements with parameterized queries:
        //Prepare the statement for the blog post table:
        $statement=$connect->prepare("
        INSERT INTO blog_post (
        vendor_id,
        title,
        blog_url,
        image_link
        )
        VALUES (1,?,?,?)
        ");

        $statement->bind_param("sss",$title,$blog_url,$image_link); //Bind the parameters:

        //Execute the statement:
        if($statement->execute()){ /* Statement executes, display a success message and redirect to the blog page: */
            echo "<script>alert('The blog post was added successfully!')</script>"; 
            header('Refresh:1; url=blog.php'); 
            exit();
        }else{ /* Statement fails, display an error message and redirect to the blog page: */
            echo "<script>alert('Blog post could not be added. Please try again.')</script>";
            header('Refresh:1; url=blog.php'); 
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
            <form class = "addproduct-form" name = "addproduct" action = "add_blog.php" method = "POST">
                <div class="form-content">
                    <h1 class="main-header">Add Blog Post:</h1> <!--First Heading on Page-->

                    <label for = "title">Title:</label> <!--Title:-->
                    <input type = "text" id = "title" name = "title" placeholder = "Enter the title of the blog post." required/>

                    <label for = "blog_url">Blog URL:</label> <!--Blog URL:-->
                    <textarea id = "blog_url" name = "blog_url" placeholder = "Enter the URL for the blog post." required></textarea>

                    <label for = "image_link">Link To Image:</label> <!--Link To Image:-->
                    <textarea type = "url" id="image_link" name="image_link" placeholder="Enter the URL for the blog post image." required></textarea><br>

                    <!--Button to submit the form:-->
                    <input type = "submit" name = "submit" value = "Add Product" style="font-weight:bold; color:black;"/> <!-- Adding additional styling to the button: -->
                </div>
            </form>

            <!-- An Extra button is added to navigate back to the blog post page: -->
            <div class="center-text">
                <br><a style="margin-top:0px; padding:15px; width:80%; color:white; font-size: 16px;" href="blog.php">BACK TO BLOG POSTS</a>
            </div>
        </div>
    </body>
</html>