<?php

$redirectLocation = '/signup';
if (!empty($_POST["sign_up"])) {

    // make database connection.
    $db = (new Database())->getConnection();

    // save posted data and sanitize it
    $data['name'] = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $data['email'] = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $data['password'] = htmlspecialchars(strip_tags(trim($_POST['password'])));

    // get posted data
    $userManager = new UserManager($db);

    // validate received values
    $validator = new FormValidator();
    $validator->validate($data, [
        'name' => ['required', 'min:5', 'max:15'],
        'email' => ['required', 'max:50'],
        'password' => ['required', 'max:50', 'min:6']
    ]);
    if ($validator->passed()) {

        // check email in database
        if (!$userManager->emailExists($data['email'])) {

            // create the user
            if ($userManager->create($data)) {

                //save user in session
                $_SESSION['user'] = $userManager->getUser()->name();

                //send confirmation email
                (new EmailManager())->send(
                    'lilija@info.lv',
                    $userManager->getUser()->email(),
                    'Successful registration',
                    'Welcome, ' . $_SESSION['user'] . ' !');

                // set response code
                http_response_code(200);

                // json message: user was created
                echo json_encode(["message" => "User was created."]);

                //redirect to home.php
                $redirectLocation = '/';
            }// message if unable to create user
            else {
                $_SESSION['errorMessage'] = "Unable to create user.";
                // set response code
                http_response_code(400);
                // json message: errors array from form validator or email exists case
                echo json_encode(["message" => $_SESSION['errorMessage']]);
            }
        } // message if email is already in use
        else {
            $_SESSION['errorMessage'] = "Email is already taken.";
            // set response code
            http_response_code(400);
            // json message: errors array from form validator or email exists case
            echo json_encode(["message" => $_SESSION['errorMessage']]);
        }
    } else {
        $_SESSION['errorMessage'] = "The parameters passed were invalid.";
        // set response code
        http_response_code(400);
        // json message: errors array from form validator or email exists case
        echo json_encode(["message" => $_SESSION['errorMessage'],
            "validator errors" => $validator->errors()]);
    }
}

header('Location: ..' . $redirectLocation);
exit();