<?php

$redirectLocation = '/login';
if (!empty($_POST["login"])) {

    // make database connection./
    $db = (new Database())->getConnection();

    // save posted data and sanitize it
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $password = htmlspecialchars(strip_tags(trim($_POST['password'])));

    // validate received values
    $validator = new FormValidator();
    $validator->validate([$email, $password], [
        'email' => ['required', 'max:50'],
        'password' => ['required', 'max:50', 'min:6']
    ]);

    if ($validator->passed()) {

        // check user if exists
        if ($user = (new UserManager($db))->getUser($email, $password)) {
            //save user name to session
            $_SESSION['user'] = $user->name();

            // set response code
            http_response_code(200);

            // json message: You are logged in
            echo json_encode(["message" => "You are logged in."]);

            $redirectLocation = '/';
        } 
        
        // message if user was not found in DB
        else {
            $_SESSION['errorMessage'] = "Email or password are incorrect";

            // set response code
            http_response_code(400);

            // json message: Email or password are incorrect
            echo json_encode(["message" => $_SESSION['errorMessage']]);
        }
        
        //if validator failed
    } else {
        $_SESSION['errorMessage'] = "The parameters passed were invalid.";

        // set response code
        http_response_code(400);

        // json message: errors array from form validator
        echo json_encode(["message" => $_SESSION['errorMessage'],
            "validator errors" => $validator->errors()]);
    }
}

header('Location: ..' . $redirectLocation);
exit();
