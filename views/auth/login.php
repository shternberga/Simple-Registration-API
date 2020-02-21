<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form">
            <!-- form error messages -->
            <?php if ($_SESSION["errorMessage"]): ?>
                <p class="alert alert-warning" role="alert">
                    <?php echo $_SESSION["errorMessage"] ?>
                    Try again!</p>
            <?php endif;
            unset($_SESSION["errorMessage"]); ?>
            <div class="login-logo">
                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            </div>
            <form action="/login" method="post" id="login" onSubmit="return validateLogin();">
                <h3>Please login</h3>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="login_email_info"
                              class="error-info"></span>
                    <input type="email" name="email" id="login_email" class="form-control"
                           placeholder="Your Email *" value=""/>
                </div>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="login_password_info"
                              class="error-info"></span>
                    <input type="password" name="password" id="login_password" class="form-control"
                           placeholder="Your Password *" value=""/>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login"
                           class="btnLogin">
                </div>
                <div class="form-group">
                    <a href="/mail" class="btnForgetPwd" value="Login">Forget Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function returnFalse() {
        return false;
    }

    function returnTrue() {
        return true;
    }

    function validateLogin() {
        let valid = true;
        document.getElementById("login_email_info").innerHTML = "";
        document.getElementById("login_password_info").innerHTML = "";
        let email = document.getElementById("login_email").value;
        let password = document.getElementById("login_password").value;

        if (email === "") {
            document.getElementById("login_email_info").innerHTML = " Email is required";
            valid = false;
        }
        if (password === "") {
            document.getElementById("login_password_info").innerHTML = " Password is required";
            valid = false;
        }
        return valid;
    }
</script>
