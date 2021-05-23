<?php

class CryptoCoins
{
    public $coinID;
    public $coinRank;
    public $coinSymbol;
    public $coinName;
    public $coinSupply;
    public $coinMaxSupply;

    public function insertFavoriteCoins($db, $coinID, $userID)
    {
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
    public function removeFavoriteCoins($db, $coinID, $userID)
    {
        $query = 'DELETE FROM favorite_coins WHERE  coinID = :coinID AND userID = :userID';

        $stmt = $db->prepare($query);

        if (!is_null($coinID) && !is_null($userID)) {

            $stmt->bindParam(':coinID', $coinID);
            $stmt->bindParam(':userID', $userID);
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

        $cryptoCoin = new CryptoCoins();

        foreach ($allData as $data) {

            $coinID = $data['id'];
            $coinRank =  $data['rank'];
            $coinSymbol =  $data['symbol'];
            $coinName =  $data['name'];
            $coinSupply =  $data['supply'];
            $coinMaxSupply =  $data['maxSupply'];
            foreach($coins as $coin){
                if($coin == $coinID){
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

        $cryptoCoin = new CryptoCoins();

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
