<?php
//make global array variable $_SESSION available
session_start();
include_once 'layouts/header.php';
include_once 'layouts/navbar.php';
?>

    <h1>All we did was steal top secret information, <?php echo $_SESSION["user"]; ?>.
        <br> I knew that you <a href="https://www.google.com/">would find</a> your way.</h1>


<?php
include_once 'layouts/footer.php';
?>