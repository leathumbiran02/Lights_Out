<?php
    //Starting the session so we can check if the user is logged in:
    session_start();
    
    //Using the database configuration file:
    require_once('db_config.php');

    //This code is executed when the user clicks the submit button in the contact us form:
    if(isset($_POST['submit'])){
        //Matching the columns in the form to the columns in the feedback table in the database:
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $comments = $_POST['comments'];

        //Creating a connection to the database using the variables in the dbconfig.php file:
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        //If the connection fails, display an error message:
        if(!$connect) 
        {
            die("Connection failed! " . mysqli_connect_error());
        }

        //Using prepared statements with parameterized queries:
        //Using SQL to create a query that inserts data into the feedback table:
        //Prepare the statement:
        $submit_feedback =$connect->prepare("
        INSERT IGNORE INTO feedback (
        first_name, 
        last_name, 
        email, 
        comment
        )
        VALUES (?,?,?,?)
        ");

        $submit_feedback->bind_param("ssss",$firstname,$lastname,$email,$comments); //Bind the parameters:
        $submit_feedback->execute(); //Execute the statement:

        if($submit_feedback->affected_rows > 0){ //If connection is successful and a row was affected, display a thank you message and redirect back to the contact us page:
            echo '<script>alert("Thank you. We have received your feedback!")</script>'; 
            header('Refresh: 1; url=contact_us.php'); 
        }
        else{ //If connection fails of a row was not affected, display an error message to the user and redirect to the contact_us page:
            echo '<script>alert("We have already received feedback from this email address. Please try again.")</script>';
            header('Refresh: 1; url=contact_us.php'); 
        }
        //Closing the statement and the database connection:
        $submit_feedback->close();
        $connect->close();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Title of Web Page: Lights Out-->
        <title>Lights Out</title>

        <!--Using a CSS style sheet for the page-->
        <link rel="stylesheet" href="style.css" />

        <style> /* Applying additional styling for this specific page: */
            label{
                font-size: 25px;
            }
            .main-header{
                padding: 20px;;
                font-size: 3vw;
                text-align: center;
            }
            header{
                box-shadow: 0 5px 10px rgb(57,161,180,1);
            }
            .contactus-form input, .contactus-form textarea{
                border: 2px solid rgb(57,161,180,1);
            }
            input[type=submit]{ 
                background: linear-gradient(to right, rgb(57,161,180,1), rgb(46,114,215,1));
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
            <!--Creating a contact us form that sends the information to the database so that it can be stored in the feedback table:-->
            <form class = "contactus-form" name = "contactus" action = "contact_us.php" method = "POST" onsubmit = "return(contactValidate());">
                <div class="form-content">
                    <!--Title of the Page: Contact Us-->
                    <h1 class="main-header">Contact Us</h1>

                    <label for = "FirstName">First Name:</label> <!--First Name:-->
                    <input type = "text" id = "FirstName" name = "firstname" placeholder = "Enter your first name"/>
            
                    <label for = "LastName">Last Name:</label> <!--Last Name:-->
                    <input type = "text" id = "LastName" name = "lastname" placeholder = "Enter your last name"/>

                    <label for = "UserEmail">Email:</label> <!--Email:-->
                    <input type = "email" id = "UserEmail" name = "email" placeholder = "Enter your email address"/>

                    <label for = "comments">Comments:</label> <!--Comments:-->
                    <textarea type = "textarea" id="comments" name="comments" placeholder="Enter any comments or suggestions that you may have"></textarea><br>

                    <!--Button to submit the form:-->
                    <input type = "submit" name = "submit" value = "submit"/>
                </div>
            </form>
        </div>
        <!--Use an external javascript file named validate.js to validate the form:-->
        <script src="validate.js"></script>
    </body>
</html>