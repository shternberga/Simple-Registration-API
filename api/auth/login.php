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

        $userManager = new UserManager($db);

        // check user if exists and if exists verify password
        if ($userManager->emailExists($email) &&
            password_verify(strip_tags($password), $userManager->getUser()->password())) {

            //save user email and name to session
            $_SESSION['user'] = $userManager->getUser()->name();

            // set response code
            http_response_code(200);

            // json message: You are logged in
            echo json_encode(["message" => "You are logged in."]);

            $redirectLocation = '/';
        } // message if unable to login
        else {
            $_SESSION['errorMessage'] = "Email or password are incorrect";

            // set response code
            http_response_code(400);

            // json message: Email or password are incorrect
            echo json_encode(["message" => $_SESSION['errorMessage']]);
        }
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
