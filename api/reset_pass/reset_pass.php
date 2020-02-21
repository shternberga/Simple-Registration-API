<?php
$redirectLocation = '/reset_pass';

if (!empty($_POST["new_password"])) {

    // make database connection.
    $db = (new Database())->getConnection();

    // save posted data and sanitize it
    $password = htmlspecialchars(strip_tags(trim($_POST['password'])));
    $email = $_SESSION['email'];
    // validate received values
    $validator = new FormValidator();
    $validator->validate([$password], [
        'password' => ['required', 'max:50', 'min:6']
    ]);

    if ($validator->passed()) {

        // check email in database
        $userManager = new UserManager($db);
        if ($userManager->emailExists($email)) {

            // update password
            if ($userManager->resetPassword($password)) {

                //save user in session
                $_SESSION['user'] = $userManager->getUser()->name();

                //send confirmation email
                (new EmailManager())->send(
                    'lilija@info.lv',
                    $userManager->getUser()->email(),
                    'Password reset',
                    'Congratulations, ' . $_SESSION['user'] . ' ! 
                            Your new password is: ' . $password . '.');

                // set response code
                http_response_code(200);

                // json message: Password was updated.
                echo json_encode(["message" => "Password was updated."]);

                //redirect to home.php
                $redirectLocation = '/';
            }// message if unable to update
            else {
                $_SESSION['errorMessage'] = "Unable to update password.";
                // set response code
                http_response_code(400);
                // json message: errors array from validator
                echo json_encode(["message" => $_SESSION['errorMessage']]);
            }
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