<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //initialize API
    include_once('../core/initialize.php');

    $signUpUser = new SignUp($db);

    $result = $signUpUser ->readAllUsers();

    $num = $result->rowCount();

    if($num >0){
        $user_data = array();
        $user_data['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $single_user = array(
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'isAuthed' => $isAuthed,
                
            );
            array_push($user_data['data'], $single_user);
        }
        echo json_encode($user_data);
        
    }else{

        echo json_encode(array('message' => 'No Users Found!'));

    }


