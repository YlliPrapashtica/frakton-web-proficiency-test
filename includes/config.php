<?php

$db_user = "root";
$db_password ="";
$db_name = 'frakton_web';

   
    $db = new PDO('mysql:host=127.0.0.1; dbname='.$db_name.';charset=utf8',$db_user,$db_password);


    $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        
//     try {
//         $sql_users_table = "CREATE TABLE Users (
//             ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//             first_name VARCHAR(255) NOT NULL,
//             last_name VARCHAR(255) NOT NULL,
//             email VARCHAR(255),
//             password VARCHAR(255),
//             isAuthed BOOLEAN DEFAULT false
//             )";
//         // use exec() because no results are returned
//         $db->exec($sql_users_table);
//         echo "Table Users created successfully<br>";
//     } catch(PDOException $e) {
       
//     }


//     try {
//         $sql_fav_coins_table = "CREATE TABLE Favorite_Coins (
//             coinID VARCHAR(255) PRIMARY KEY,
//             userID INT(6)
//             )";
//         // use exec() because no results are returned
//         $db->exec($sql_fav_coins_table);
//         echo "Table Favorite_Coins created successfully<br>";
//     } catch(PDOException $e) {
        
//     }

//   $db = null;
