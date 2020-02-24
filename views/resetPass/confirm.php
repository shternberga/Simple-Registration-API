<h1> Resent link was sent to <strong><?php echo $_SESSION['email']?></strong>, please check your inbox!</h1>

<?php
unset($_SESSION['email']);
?>