<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset PHP</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form">
            <form class="login-form" action="/resetPass" method="post" onSubmit="return validatePasswords();">
                <h2 class="form-title">New password</h2>
                <!-- form error messages -->
                <?php if ($_SESSION["errorMessage"]): ?>
                    <p class="alert alert-warning" role="alert">
                        <?php echo $_SESSION["errorMessage"] ?>
                        Try again!</p>
                <?php endif;
                unset($_SESSION["errorMessage"]); ?>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="password_info"
                              class="error-info"></span>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Your Password *" value=""/>
                </div>
                <div class="form-group">
                     <span style="color: #2e0000; font-size: smaller" id="confirm_password_info"
                           class="error-info"></span>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                           placeholder="Confirm Password *" value=""/>
                </div>
                <div class="form-group">
                    <input type="submit" name="new_password" value="Submit"
                           class="btnSignup"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validatePasswords() {
        let valid = true;
        let passRegExp = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{6,16}$/;
        document.getElementById("password_info").innerHTML = "";
        document.getElementById("confirm_password_info").innerHTML = "";
        let password = document.getElementById("password").value;
        let confirm_password = document.getElementById("confirm_password").value;

        if (password === "") {
            document.getElementById("password_info").innerHTML = " Password is required";
            valid = false;}
        else if (confirm_password === "") {
            document.getElementById("confirm_password_info").innerHTML = " Confirmation is required";
            valid = false;
        } else if (password !== confirm_password) {
            document.getElementById("password_info").innerHTML = " Passwords do not match";
            valid = false;
        } else if (password.length < 6) {
            document.getElementById("password_info").innerHTML = " Password length should be at least 6 symbols";
            valid = false;
        } else if (!passRegExp.test(password)) {
            document.getElementById("password_info").innerHTML = " Password should contain at least 1 uppercase letter and a special sign (i.e. !@#$%^&*()_)";
            valid = false;
        }
        return valid;
    }
</script>
