<?php
include_once('../core/initialize.php');

//Create Tables & Dummy Info If Tables Dont Exist
try {
    //Create Users Table
    $sql_users_table = "CREATE TABLE Users (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255),
        password VARCHAR(255),
        isAuthed BOOLEAN DEFAULT false
        )";

    $db->exec($sql_users_table);

    //Add Dummy Values To Users Table
    $sql_users_table_data = "INSERT INTO users (ID, first_name, last_name, email, password, isAuthed) VALUES('1', 'Ylli-1', 'Prapashtica-1', 'Ylliemail1', 'Ylli-password-1', '1'),('2', 'Ylli-2', 'Prapashtica-2', 'Ylli-email-2', 'Ylli-password-2', '1'),('3', 'Ylli-3', 'Prapashtica-3', 'Ylli-email-3', 'Ylli-password-3', '0'),('4', 'Ylli-4', 'Prapashtica-4', 'Ylli-email-4', 'Ylli-password-4', '1'),('5', 'Ylli-5', 'Prapashtica-5', 'Ylli-email-5', 'Ylli-password-5', '0');";

    $db->exec($sql_users_table_data);

    echo "Table Users created successfully<br>";
    echo "Table Users populated successfully<br>";

    //Create Favorite Coin Table
    $sql_fav_coins_table = "CREATE TABLE favorite_coins (
            coinID VARCHAR(255),
            userID INT(6),
    PRIMARY KEY(coinID,userID)
            )";

    $db->exec($sql_fav_coins_table);
    echo "Table Favorite_Coins created successfully<br>";
    
} catch (PDOException $e) {
    echo "Tables already exist!<br>";
}
