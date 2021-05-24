<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

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
        //user is authorized

        $cryptoCoins = new CryptoCoins();

        //Get Posted Data
        $data = json_decode(file_get_contents("php://input"));

        $url = 'https://api.coincap.io/v2/assets';

        $decoded = json_decode(file_get_contents($url), true);
        //Array of Decoded Data
        $allData = $decoded['data'];

        //Add CryptoCoins Here
        $all_crypto = array();
        $all_crypto['id'] = array();

        foreach ($allData as $singleData) {
            //Get Only CoinID of Crypto Coins
            $singleCoinID = $singleData['id'];

            array_push($all_crypto['id'], $singleCoinID);
        }
        //Set Posted Data
        $coinID = $data->coinID;
        $mode = $data->mode;

        //Check If The ID Of The Coin Exists
        if (in_array($coinID, $all_crypto['id'])) {
            //if Mode = 'add' -> Run Add Favorite Coin Function
            if ($mode == 'add') {

                $cryptoCoins->insertFavoriteCoins($db, $coinID, $email);
            }

            //if Mode = 'remove' -> Run Remove Favorite Coin Function
            elseif ($mode == 'remove') {

                $cryptoCoins->removeFavoriteCoins($db, $coinID, $email);
            }
        } else {
            //Coin ID Doesnt Exist
            echo json_encode(
                array('message' => 'Coin ID Doesnt Exist!')
            );
        }
    } else {
        //User Not Verified
        echo json_encode(
            array('message' => 'Sorry, you need to verify your account in order to access this page!')
        );
    }
}
