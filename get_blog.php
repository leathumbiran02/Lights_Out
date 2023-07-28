<?php
    /* Using the database configuration file: */
    require_once('db_config.php');

    /* Creating a connection to the database using the variables in the db_config.php file: */
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    /* If the connection fails, display an error: */
    if($connect->connect_error){
        die("Connection failed!" . $connect->connect_error);
    }

    /* Using prepared statements with parameterised queries: */
    /* Prepare the statement: */
    $getBlogs=$connect->prepare("
    SELECT
    *
    FROM
    blog_post
    ");

    $getBlogs->execute(); /* Execute the statement: */
    $result=$getBlogs->get_result(); /* Get the result set: */

    /* HTML code display the details about each blog post: */
    if($result->num_rows>0){ //If rows were found in the table:

        //Make an Add Blog Button that is only shown to vendors:
        if(isset($_SESSION['vendor'])&& $_SESSION['vendor']==true){
            echo "<center><a href='add_blog.php'><button class='addbutton' style='margin-top:0px; margin-bottom:30px; width:35%;'>Add</button></a></center>";
        }
        echo    "<div class='products-row'>";
        
            while($row = $result->fetch_assoc()){
                echo    "<div class='product'>";
                echo        "<a href='" . $row["blog_url"] . "' onclick=\"return confirm('You are now being redirected to the article...');\"><img class='product-img' src='" . $row["image_link"] . "' alt='" . $row['title'] . "'></a>"; /* Blog image: */
                echo        "<div class='product-info'>";
                echo            "<h3 class='product-title'>" . $row["title"] . "</h3>"; /* Blog post title: */
                
                //Check if the user is a vendor, if they are, show the view, update and delete buttons:
                if(isset($_SESSION['vendor']) && $_SESSION['vendor']==true){
                    echo        "<a href='" . $row["blog_url"] . "' onclick=\"return confirm('You are now being redirected to the article...');\"><button class='viewbutton' style='margin-top:10px;'>View</button></a>";
                    echo        "<a href='update_blog.php?id=" . $row['blog_id'] . "'><button class='updatebutton' style='margin-top:5px; '>Update</button></a>";
                    echo        "<a href='delete_blog.php?id=" . $row['blog_id'] . "' onclick=\"return confirm('Are you sure that you want to delete this blog post?');\"><button class='deletebutton' style='margin-top:5px; '>Delete</button></a>";
                }else{ //If the user is not a vendor, only show the view blog button:
                    echo        "<a href='" . $row["blog_url"] . "' onclick=\"return confirm('You are now being redirected to the article...');\"><button class='viewbutton' style='margin-top:10px;'>View More</button></a>";
                }
                echo        "</div>";
                echo    "</div>";
            }
        echo    "</div>";
    } else{ //There are no rows or the table is empty, display an error message on the page:
        echo "<div class='center-text'>";
        echo    "<h2 style='color:#80eeff;'>No Blog Posts Were Found.</h2>"; 
        echo "</div>";
        
        //If the user is a vendor and the table is empty, they can still add blog posts:
        if(isset($_SESSION['vendor'])&& $_SESSION['vendor']==true){
            echo "<div class='center-text'>";
            echo        "<a href='add_blog.php'><button class='addbutton' style='margin-top:20px; margin-bottom:30px; width:35%;'>Add</button></a>";
            echo "</div>";
        }
    }
    //Closing the database connection:
    $connect->close();
?>
