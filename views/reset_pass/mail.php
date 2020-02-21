<?php
//make global array variable $_SESSION available
session_start();
include_once 'layouts/header.php';
include_once 'layouts/navbar.php';
?>
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
            <form action="/maillink" method="post" id="email_form" onSubmit="return validateEmail();">
                <h3>Enter your email</h3>
                <div class="form-group">
                        <span style="color: #2e0000; font-size: smaller" id="email_info"
                              class="error-info"></span>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="Your Email *" value=""/>
                </div>
                <div class="form-group">
                    <input type="submit" name="reset-password" value="Send reset link"
                           class="btnLogin">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validateEmail() {
        let valid = true;
        document.getElementById("email_info").innerHTML = "";
        let email = document.getElementById("email").value;
        if (email === "") {
            document.getElementById("email_info").innerHTML = " Email is required";
            valid = false;
        }
    }
</script>

<?php
include_once 'layouts/footer.php';
?>
