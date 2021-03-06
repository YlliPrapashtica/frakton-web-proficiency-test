<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//initialize API
include_once('../core/initialize.php');
include_once('../core/cryptoCoins.php');


if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=Frakton Crypto Coins");
    header("HTTP/1.0 401 Unauthorized");
    print("Sorry, you need to verify your account in order to access this page!");
    exit;
} else {

    //Check If User Is Authorized
    $query = "SELECT * FROM users WHERE email=? AND isAuthed = '1'";

    $stmt = $db->prepare($query);


    $email = htmlspecialchars(strip_tags($_SERVER['PHP_AUTH_USER']));

    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        //User Is AUthorized
        $cryptoCoins = new CryptoCoins();

        //Print All CryptoCoins As JSON
        echo $cryptoCoins->printCoins();
       
    }else {
        //User Not Authorized
        header("WWW-Authenticate: Basic realm=Frakton Crypto Coins");
        header("HTTP/1.0 401 Unauthorized");
        print("Sorry, you need to verify your account in order to access this page!");
        exit;
    }
}
