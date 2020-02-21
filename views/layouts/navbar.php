<div class="content">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top flex-row justify-content-between">
        <a class="navbar-brand" href="/">CODELEX</a>
        <div class="float-right" id="navbarNavAltMarkup">
            <div class="navbar-nav flex-row justify-content-between">
                <?php if (isset($_SESSION["user"])): ?>
                    <a class="nav-item nav-link px-3" href="/logout" id='nav_logout'>Logout</a>
                    <a class="nav-item nav-link px-3" href="/notforall" id='nav_go'>GO</a>
                <?php else: ?>
                    <a class="nav-item nav-link px-3" href="/login" id='nav_login'>Login</a>
                    <a class="nav-item nav-link" href="/signup" id='nav_sign_up'>Sign Up</a>
                <?php endif ?>
            </div>
        </div>
    </nav>