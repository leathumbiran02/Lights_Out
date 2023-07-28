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

        <style> /* Applying additional styling for this specific page: */
            header{
                box-shadow: 0 5px 10px rgb(46,114,215,1);
            }
            .addbutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgb(46,114,215,1), rgb(101,43,252,1));
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
            .hero{ /* Centering the text: */
                text-align:center;
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
            <!--Button that Navigates to the update account and delete account page:-->
            <h1 class='main-header' style='margin-bottom:30px;'>Manage Account:</h1>
            <?php
                //Check if the user is a vendor, if they are, show the update account button only:
                if(isset($_SESSION['vendor']) && $_SESSION['vendor']==true){
                    echo        "<a href='update_account.php'><button class='addbutton'>Edit Account</button></a><br>";
                }else if (isset($_SESSION['users']) && $_SESSION['users']==true){ 
                    //If the user is not a vendor, show the edit account and delete account button:
                    echo        "<a href='update_account.php'><button class='addbutton'>Edit Account</button></a><br>";
                    echo        "<a href='delete_account_page.php'><button class='addbutton'>Delete Account</button></a>";
                }else{
                    echo        "<h2 style='color:#80eeff;'>Please log in to view this page.</h2>"; //Display an error message directly on the page:
                }
            ?>
        </div>
    </body>
</html>