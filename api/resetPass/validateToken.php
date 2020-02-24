<?php
//save redirect path to new password form
$redirectLocation = '/resetPass';

if (!empty($_GET["token"])) {
    // make database connection./
    $db = (new Database())->getConnection();

    //sanitize data
    $hash = htmlspecialchars(strip_tags(trim($_GET['token'])));

    // check if reset link valid
    $resetLinkManager = new ResetLinkManager($db);

    //validHash() return string with email address
    $hashEmail = $resetLinkManager->validHash($hash);
    if ($hashEmail) {
        $_SESSION['email'] = $hashEmail;

    } else {

        //redirect to home if link is not valid
        $redirectLocation = '/';

        // set response code
        http_response_code(400);
        $_SESSION['errorMessage'] = "Token is not Valid.";

        // json message: Token is not valid.
        echo json_encode(["message" => "Token is not Valid."]);
    }
}
header('Location: ..' . $redirectLocation);
exit();