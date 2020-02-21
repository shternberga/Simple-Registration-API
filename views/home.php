<!-- form error messages -->
<?php if ($_SESSION["errorMessage"]): ?>
    <p class="alert alert-warning" role="alert">
        <?php echo $_SESSION["errorMessage"] ?>
        Try again!</p>
<?php endif;
unset($_SESSION["errorMessage"]); ?>

<?php if (isset($_SESSION["user"])): ?>
    <h1>Welcome <?php echo $_SESSION["user"]; ?>!</h1>

<?php else: ?><h1> Please <a href="/login">login</a> or <a href="/signup">sign-up</a> first.</h1>
<?php endif ?>

