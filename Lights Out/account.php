<?php
    //Starting the session:
    session_start();

    //Using the database configuration file:
    require_once('db_config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page:-->
        <link rel="stylesheet" href="style.css">

        <style>
            .hero{ /* Centering the text on the page: */
                text-align: center;
            }
            .user-info{ /* Container for the user's account details: */
                background-color: rgb(0, 0, 0);
                border: 2px solid rgb(101,43,252,1);
                border-radius: 10px;
            }
            header{ /* Changing the shadow colour for the menu on the top of the page: */
                box-shadow: 0 5px 10px rgb(176,20,252,1);
            }
            .addbutton { /* Button when clicking on products */
                background: linear-gradient(to right, rgb(101,43,252,1), rgb(176,20,252,1));
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
            <!--Container for the users' information:-->
            <?php
                /* Redirect the user/vendor to the login page if they are not logged in: */
                if(!isset($_SESSION['email'])){
                    header('Location: login.php');
                    exit();
                }

                //Creating a connection to the database:
                $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        
                //Store the email entered in this session in $email:
                $email = $_SESSION['email']; 

                //Check the vendor table if the email entered matches the email in the table:
                //Prepare the statement:
                $check_vendor = $connect->prepare("
                SELECT 
                * 
                FROM vendor 
                WHERE email=?
                "); 

                $check_vendor->bind_param("s",$email); //Bind the parameter:
                $check_vendor->execute(); //Execute the statement:
                $result=$check_vendor->get_result(); //Get the set of results:
                $row=$result->fetch_assoc(); //Fetch the associated row and store it:
        
                //If the vendor is not found in the vendor table, check the users table:
                if(!$row){
                    /* Prepare the statement: */
                    $check_user =$connect->prepare("
                    SELECT 
                    * 
                    FROM users 
                    WHERE email=?
                    ");
                        
                    $check_user->bind_param("s",$email); //Bind the parameter:
                    $check_user->execute(); //Execute the statement:
                    $result=$check_user->get_result(); //Get the set of results:
                    $row=$result->fetch_assoc(); //Fetch the associated row and store it:
                }

                //If the user/vendor is not found in any table, display an error message and redirect to the login page:
                if(!$row){
                    echo '<script>alert("The user could not be found. Please try again.")</script>';
                    header('Refresh: 1; url=login.php');
                    exit();
                }

                //Display the user's account information:
                if(isset($row['first_name']) && isset($row['last_name'])){
                    /* Fetch the user/vendor details: */
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $email = $row['email'];

                    /* Displaying the user's account details, a manage account button and a logout button on the page: */
                    echo "<h1 class='main-header'>Account Details:</h1>";
                    echo "<a href='manage_account.php'><button class='addbutton'>Manage Account</button></a>";
                    echo "<div class='user-info'>";
                    echo    "<table>";
                    echo        "<tbody>";
                    echo            "<tr>";
                    echo                "<td>";
                    echo                    "<th>Name:</th>";
                    echo                "</td>";
                    echo                "<td>";
                    echo                    "$first_name";
                    echo                "</td>";
                    echo            "</tr>";
                    echo            "<tr>";
                    echo                "<td>";
                    echo                    "<th>Surname:</th>";
                    echo                "</td>";
                    echo                "<td>";
                    echo                    "$last_name";
                    echo                "</td>";
                    echo            "</tr>";
                    echo            "<tr>";
                    echo                "<td>";
                    echo                    "<th>Email:</th>";
                    echo                "</td>";
                    echo                "<td>";
                    echo                    "$email";
                    echo                "</td>";
                    echo            "</tr>";
                    echo        "</tbody>";
                    echo    "</table>";
                    echo "</div>";
                    echo "<a href='logout.php' onclick=\"return confirm('Are you sure that you want to logout?')\"><button class='addbutton'>Logout</button></a>";
                }
                //Closing the database connection:
                $connect->close();
            ?>
        </div>
    </body>
</html>