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
            .product{
                background-color: black;
                opacity: 95%;
            }
            header{
                box-shadow: 0 5px 10px rgb(46,114,215,1);
            }
            .viewbutton, .addbutton, .updatebutton, .deletebutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgb(46,114,215,1), rgb(101,43,252,1));
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
            <!-- Title of the Page: Blog Posts -->
            <h1 class="main-header">Blog Posts</h1>

            <div id="products">
                <!-- Include the file that fetches all of the blog posts: -->
                <?php
                    include 'get_blog.php';
                ?>
            </div>
        </div>
    </body>
</html>