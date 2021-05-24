<?php
include_once('../core/initialize.php');

//Check If User Sent Authorizations
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=Frakton Crypto Coins");
    header("HTTP/1.0 401 Unauthorized");
    print("Sorry, you need to verify your account in order to access this page!");
    exit;
} else {
    //Get Email To Verify That User
    $query = "SELECT * FROM users WHERE email=?";

    $stmt = $db->prepare($query);

    $email = htmlspecialchars(strip_tags($_SERVER['PHP_AUTH_USER']));

    $stmt->execute([$email]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        if (($_SERVER['PHP_AUTH_USER']) == $row['email']) {
            //User Has An Account

            //Change User Authorization Status In Database
            $query = "UPDATE Users SET isAuthed='1' WHERE email= "."'". $row['email']." '";

            $stmt = $db->prepare($query);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                print('User Is Now Verified');
            }else{
                print('User Is Already Verified');
            }
        } else {
            header("WWW-Authenticate: Basic realm=Frakton Crypto Coins");
            header("HTTP/1.0 401 Unauthorized");
            print("Sorry, you need to verify your credentials");
            exit;
        }
    } else {
        header("WWW-Authenticate: Basic realm=Frakton Crypto Coins");
        header("HTTP/1.0 401 Unauthorized");
        print("Sorry, you need to verify your credentials");
        exit;
    }
}
