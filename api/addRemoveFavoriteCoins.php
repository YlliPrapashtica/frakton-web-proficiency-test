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


    $query = "SELECT * FROM users WHERE email=? AND isAuthed = '1'";

    $stmt = $db->prepare($query);


    $email = htmlspecialchars(strip_tags($_SERVER['PHP_AUTH_USER']));

    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        //user is authorized
        
        $cryptoCoins = new CryptoCoins();

        $data = json_decode(file_get_contents("php://input"));

        $url = 'https://api.coincap.io/v2/assets';

        $decoded = json_decode(file_get_contents($url), true);
        $allData = $decoded['data'];

        $all_crypto = array();
        $all_crypto['id'] = array();

        foreach ($allData as $singleData) {

            $singleCoinID = $singleData['id'];

            array_push($all_crypto['id'], $singleCoinID);
        }

        $coinID = $data->coinID;
        $userID = $data->userID;
        $mode = $data->mode;
        if (in_array($coinID, $all_crypto['id'])) {
            if($mode == 'add'){

                $cryptoCoins->insertFavoriteCoins($db,$coinID,$userID);
            }
            elseif($mode == 'remove'){

                $cryptoCoins->removeFavoriteCoins($db,$coinID,$userID);
            }
    }else {
        echo json_encode(
            array('message' => 'Coin ID Doesnt Exist!')
        );
    }
} else{
    echo json_encode(
        array('message' => 'Sorry, you need to verify your account in order to access this page!')
    );
    
}

}