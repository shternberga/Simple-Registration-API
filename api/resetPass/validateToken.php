<?php
//save redirect path to new password form
$redirectLocation = '/resetpass';

if (!empty($_GET["token"])) {
    // make database connection.
    $db = (new Database())->getConnection();

    //sanitize data
    $hash = htmlspecialchars(strip_tags(trim($_GET['token'])));

    $resetLinkManager = new ResetLinkManager($db);

    $hashEmail = $resetLinkManager->getEmailBy($hash);
    //check if hash exists and date is valid
    if ($hashEmail && $resetLinkManager->isValid($hash)) {

        $_SESSION['email'] = $hashEmail;

    } else {

        //redirect to home if link is not valid
        $redirectLocation = '/';

        // set response code
        http_response_code(400);
        $_SESSION['errorMessage'] = "Token is not Valid.";

        // json message: Token is not valid.
        echo json_encode(["message" => $_SESSION['errorMessage']]);
    }
}
header('Location: ..' . $redirectLocation);
exit();