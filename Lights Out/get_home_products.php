<?php
    //Using the database configuration file:
    require_once('db_config.php');

    //Creating a connection to the database using the variables in the dbconfig.php file:
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
    //If the connection fails display an error:
    if($connect->connect_error){
        die("Connection failed!" . $connect->connect_error);
    }

    //Using prepared statements with parameterized queries:
    //Prepare the statement:
    $sql_query=$connect->prepare("
    SELECT 
    * 
    FROM 
    products
    ");

    $sql_query->execute(); //Execute the statement:
    $result=$sql_query->get_result(); //Get the result set:
    $products=$result->fetch_all((MYSQLI_ASSOC)); //Get the result set and store it in an array:

    //Exception handling for if the database table is empty, display an error message directly on the home page:
    if($result->num_rows===0){
        echo "<div class='center-text'>";
        echo    "<h2 style='color:#80eeff;'>No Products Were Found.</h2>"; 
        echo "</div>";
    } 
?>