<?php

class CryptoCoins
{
    public $coinID;
    public $coinRank;
    public $coinSymbol;
    public $coinName;
    public $coinSupply;
    public $coinMaxSupply;

    public function insertFavoriteCoins($db, $coinID, $email)
    {

        // Get UserID From Authorized Email
        $query = "SELECT ID FROM users WHERE email=:email";

        $stmt = $db->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $row) {
            $userID = $row[0];
        }


        //Insert favorite Coin which requires the CryptoCoin ID And The Authorized Email 
        $query = 'INSERT INTO favorite_coins SET coinID = :coinID, userID = :userID ';

        $stmt = $db->prepare($query);

        if (!is_null($coinID) && !is_null($userID)) {

            $stmt->bindParam(':coinID', $coinID);
            $stmt->bindParam(':userID', $userID);

            try {
                if ($stmt->execute()) {
                    echo json_encode(
                        array('message' => 'Coin Added!')
                    );
                }
            } catch (PDOException $e) {

                echo json_encode(
                    array('message' => 'Coin Already Added')
                );
            }
        }
    }
    public function removeFavoriteCoins($db, $coinID, $email)
    {


        //Remove favorite Coin which requires the CryptoCoin ID And The Authorized Email 
        $query = 'DELETE f FROM favorite_coins as f LEFT JOIN  users u ON  u.ID = f.userID WHERE u.email=:email AND f.coinID=:coinID    ';

        $stmt = $db->prepare($query);

        if (!is_null($coinID) && !is_null($email)) {

            $stmt->bindParam(':coinID', $coinID);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(
                    array('message' => 'Coin Removed')
                );
            } else {
                echo json_encode(
                    array('message' => 'Coin Doesnt Exist')
                );
            }
        }
    }
    public function printFavoriteCoins($db, $email)
    {
        //Select The CryptoCoin CoinID To Get All Favorite CryptoCoins Based On The CoinID
        $query = "SELECT f.coinID FROM favorite_coins f LEFT JOIN  users u ON f.userID = u.ID  WHERE u.email='" . $email . "'";

        $stmt = $db->prepare($query);

        $stmt->execute();
        $data = $stmt->fetchAll();
        $coins = array();

        foreach ($data as $row) {
            $coinID = $row['coinID'];
            array_push($coins, $coinID);
        }

        $url = 'https://api.coincap.io/v2/assets';

        $decoded = json_decode(file_get_contents($url), true);
        $allData = $decoded['data'];

        $user_crypto = array();
        $user_crypto['data'] = array();


        //New CryptoCoin
        $cryptoCoin = new CryptoCoins();

        foreach ($allData as $data) {

            $coinID = $data['id'];
            $coinRank =  $data['rank'];
            $coinSymbol =  $data['symbol'];
            $coinName =  $data['name'];
            $coinSupply =  $data['supply'];
            $coinMaxSupply =  $data['maxSupply'];
            foreach ($coins as $coin) {
                //Only Create Coins Based On User's Favorite Coin IDs
                if ($coin == $coinID) {
                    $cryptoCoin = array(
                        'id' => $coinID,
                        'rank' => $coinRank,
                        'symbol' => $coinSymbol,
                        'name' => $coinName,
                        'supply' => $coinSupply,
                        'maxSupply' => $coinMaxSupply,

                    );
                    //Collect All Favorite CryptoCoins
                    array_push($user_crypto['data'], $cryptoCoin);
                }
            }
        }
        return json_encode($user_crypto, JSON_PRETTY_PRINT);
    }

    public function printCoins()
    {

        $url = 'https://api.coincap.io/v2/assets';

        $decoded = json_decode(file_get_contents($url), true);
        $allData = $decoded['data'];

        $user_crypto = array();
        $user_crypto['data'] = array();

        //New Crypto Coin
        $cryptoCoin = new CryptoCoins();

        //Collect Required Coin Data
        foreach ($allData as $data) {

            $coinID = $data['id'];
            $coinRank =  $data['rank'];
            $coinSymbol =  $data['symbol'];
            $coinName =  $data['name'];
            $coinSupply =  $data['supply'];
            $coinMaxSupply =  $data['maxSupply'];

            $cryptoCoin = array(
                'id' => $coinID,
                'rank' => $coinRank,
                'symbol' => $coinSymbol,
                'name' => $coinName,
                'supply' => $coinSupply,
                'maxSupply' => $coinMaxSupply,

            );

            array_push($user_crypto['data'], $cryptoCoin);
        }
        return json_encode($user_crypto, JSON_PRETTY_PRINT);
    }
}
