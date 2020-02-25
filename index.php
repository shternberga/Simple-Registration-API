<?php
//make global variable $_SESSION available
session_start();
include_once 'views/layouts/header.php';
include_once 'views/layouts/navbar.php';
include('Route.php');
include './config/database.php';
include 'api/managers/UserManager.php';
include 'api/managers/EmailManager.php';
include 'api/managers/ResetLinkManager.php';
include 'api/validators/FormValidator.php';
require 'vendor/autoload.php';
include __DIR__ . '/api/model/User.php';

// Start page
Route::add('/', function () {
    require 'views/home.php';
}, 'get');
// Login form
Route::add('/login', function () {
    if (!isset($_SESSION["user"]))
        require 'views/auth/login.php';
    else require 'views/home.php';
}, 'get');
// Login post request
Route::add('/login', function () {
    require 'api/auth/login.php';
}, 'post');
// Logout
Route::add('/logout', function () {
    require 'api/auth/logout.php';
}, 'get');
// Sign up form
Route::add('/signup', function () {
    if (!isset($_SESSION["user"]))
        require 'views/auth/signUp.php';
    else require 'views/home.php';
}, 'get');
// Sign up post request
Route::add('/signup', function () {
    require 'api/auth/signUp.php';
}, 'post');
// Only for registered users
Route::add('/notforall', function () {
    if (isset($_SESSION["user"]))
        require 'views/notForAll.php';
    else require 'views/home.php';
}, 'get');
// Show email for reset form
Route::add('/mail', function () {
    if (!isset($_SESSION["user"]))
        require 'views/resetPass/mail.php';
    else require 'views/home.php';
}, 'get');
// Mail link to user
Route::add('/maillink', function () {
    require 'api/resetPass/mailLink.php';
}, 'post');
// Check token before reset form
Route::add('/reset', function () {
    require 'api/resetPass/validateToken.php';
}, 'get');
// Reset mail sent confirm page
Route::add('/confirm', function () {
    require 'views/resetPass/confirm.php';
}, 'get');
// New password form
Route::add('/resetpass', function () {
    require 'views/resetPass/resetPass.php';
}, 'get');
// New password post
Route::add('/resetpass', function () {
    require 'api/resetPass/resetPass.php';
}, 'post');

Route::run('/');


include_once 'views/layouts/footer.php';
