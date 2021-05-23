<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

    //initialize API
    include_once('../core/initialize.php');

    $signUpUser = new SignUp($db);

    $data = json_decode(file_get_contents("php://input"));
    $signUpUser->first_name = $data->first_name;
    $signUpUser->last_name = $data->last_name;
    $signUpUser->email = $data->email;
    $signUpUser->password = $data->password;

if(!is_null($data->first_name) && !is_null($data->last_name) && !is_null($data->email) && !is_null($data->password)){
    if($signUpUser->createUser()){
        echo json_encode(
            array('message' => 'User Created')
        );
    }else{
         
        echo json_encode(
            array('message' => 'User Not Created')
        );
    }
}else{
        
    echo json_encode(
        array('message' => 'User Not Created')
    );
}