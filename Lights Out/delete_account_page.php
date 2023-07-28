<?php
    //Starting the session so we can check if the user is logged in:
    session_start();

    //Checking if the user id is stored in the session:
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('You must be logged in as a user to view this page.')</script>";
        header('Refresh: 1; url=login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css">

        <!-- Applying additional styling for this specific page: -->
        <style> 
            header{
                box-shadow: 0 5px 10px rgb(57,161,180,1);
            }
            .hero{ /* Centering the text: */
                text-align:center;
            }
            .addbutton { /* Button when clicking on products */
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
            <h1 class='main-header' style='margin-top:50px; margin-bottom:50px; text-transform:none'>Are you sure that you want to delete your account?</h1>
            <?php
                echo    "<a href='delete_account.php'><button class='addbutton'>Yes</button></a><br>"; /* Delete account button: */
                echo    "<a href='account.php'><button class='addbutton'>No, go back</button></a>"; /* Go back to account page button: */
            ?>
        </div>
    </body>
</html>