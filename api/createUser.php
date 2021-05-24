<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

//initialize API
include_once('../core/initialize.php');

$signUpUser = new SignUp($db);

//Collect Data From Posted JSON
$data = json_decode(file_get_contents("php://input"));
$signUpUser->first_name = $data->first_name;
$signUpUser->last_name = $data->last_name;
$signUpUser->email = $data->email;
$signUpUser->password = $data->password;

//Check If No Inputs Are Empty
if (!is_null($data->first_name) && !is_null($data->last_name) && !is_null($data->email) && !is_null($data->password)) {
    //Run Create User Function
    try{
        if ($signUpUser->createUser()) {
            echo json_encode(
                array('message' => 'User Created')
            );
    }else{
        echo json_encode(
            array('message' => 'User Failed To Create')
        );
    }
    
    } catch (PDOException $e){
        //Incorrect Data Passed
        echo json_encode(
            array('message' => 'User Failed To Create')
        );
    }
} else {
    //Empty Fields
    echo json_encode(
        array('message' => 'User Not Created, Input Fields Are Empty!')
    );
}
