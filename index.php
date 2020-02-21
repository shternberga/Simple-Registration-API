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
        require 'views/auth/sign_up.php';
    else require 'views/home.php';
}, 'get');
// Sign up post request
Route::add('/signup', function () {
    require 'api/auth/signup.php';
}, 'post');
// Only for registered users
Route::add('/notforall', function () {
    if (isset($_SESSION["user"]))
        require 'views/not_for_all.php';
    else require 'views/home.php';
}, 'get');
// Show email for reset form
Route::add('/mail', function () {
    if (!isset($_SESSION["user"]))
        require 'views/reset_pass/mail.php';
    else require 'views/home.php';
}, 'get');
// Mail link to user
Route::add('/maillink', function () {
    require 'api/reset_pass/mailLink.php';
}, 'post');
// Check token before reset form
Route::add('/reset', function () {
    require 'api/reset_pass/validateToken.php';
}, 'get');
// Reset mail sent confirm page
Route::add('/confirm', function () {
    require 'views/reset_pass/confirm.php';
}, 'get');
// New password form
Route::add('/reset_pass', function () {
    require 'views/reset_pass/reset_pass.php';
}, 'get');
// New password post
Route::add('/reset_pass', function () {
    require 'api/reset_pass/reset_pass.php';
}, 'post');

Route::run('/');


include_once 'views/layouts/footer.php';
