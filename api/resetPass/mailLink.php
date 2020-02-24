<?php

$redirectLocation = '/mail';

if (isset($_POST['reset-password'])) {
    // make database connection./
    $db = (new Database())->getConnection();

    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $userManager = new UserManager($db);
    $resetLinkManager = new ResetLinkManager($db);

    // validate received values
    $validator = new FormValidator();
    $validator->validate([$email], [
        'email' => ['required', 'max:50']
    ]);

    if ($validator->passed()) {
        // check user if exists in database
        if ($userManager->emailExists($email)) {
            //delete old link from database
            $resetLinkManager->updateLinks($email);
            $_SESSION['email'] = $userManager->getUser()->email();
            // generate a unique random token of length 100
            $token = bin2hex(random_bytes(50));

            //save reset token to the database
            if ((new EmailManager())->send(
                    'lilija@info.lv',
                    $userManager->getUser()->email(),
                    'Reset your password link.',
                    "Hi there, click on this 
                <a href=\"http://localhost:8880/reset?token=" . $token . "\">link</a> 
                to reset your password on our site"
                )
                &&
                $resetLinkManager->save([
                    'email' => $userManager->getUser()->email(),
                    'hash' => $token])
            ) {
                // set response code
                http_response_code(200);

                // json message: user was created
                echo json_encode(["message" => "Reset link was sent and saved to database."]);

                //redirect to home.php
                $redirectLocation = '/confirm';
            } else {
                $_SESSION['errorMessage'] = "Something went wrong.";
                // set response code
                http_response_code(400);
                // json message: errors array from form validator or email exists case
                echo json_encode(["message" => $_SESSION['errorMessage']]);
            };
        } else {
            $_SESSION['errorMessage'] = "Email does not exist";

            // set response code
            http_response_code(400);

            // json message: Email or password are incorrect
            echo json_encode(["message" => "Email does not exist"]);
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