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
            <form action="/signup" method="post" id="sign_up" onSubmit="return validateSignUp();">
                <h3>Sign Up</h3>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="name_info"
                              class="error-info"></span>
                    <input type="text" name="name" id="name" class="form-control"
                           placeholder="Your Name *" value=""/>
                </div>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="email_info"
                              class="error-info"></span>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="Your Email *" value=""/>
                </div>
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
                    <input type="submit" name="sign_up" value="Sign-Up"
                           class="btnSignup"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validateSignUp() {
        let valid = true;
        let passRegExp = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{6,16}$/;
        let mailRegExp = /[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,64}/;
        document.getElementById("name_info").innerHTML = "";
        document.getElementById("email_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        document.getElementById("confirm_password_info").innerHTML = "";
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let confirm_password = document.getElementById("confirm_password").value;

        if (name === "") {
            document.getElementById("name_info").innerHTML = " Name is required";
            valid = false;
        }
        if (email === "") {
            document.getElementById("email_info").innerHTML = " Email is required";
            valid = false;
        } else if (mailRegExp.test(String(email).toLowerCase())) {
            document.getElementById("email_info").innerHTML = " Email is not valid";
            valid = false;
        }
        if (password === "") {
            document.getElementById("password_info").innerHTML = " Password is required";
            valid = false;
        }
        if (confirm_password === "") {
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
