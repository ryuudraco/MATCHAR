<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Src\Services\Service;

// $app->get('/test', function (Request $request, Response $response, $params) use ($app) {
// 	$service = new \Src\Services\TestService($app->getContainer(), $request, $response, $params);
// 	return $service->handle();
// });

$app->get('/', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\HomeService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});

# LOGIN
$app->get('/login', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\LoginService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});
$app->post('/login', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\LoginService($app->getContainer(), $request, $response, $params);
	return $service->handlePost();
});

# LOGOUT
$app->get('/logout', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\LoginService($app->getContainer(), $request, $response, $params);
	return $service->logout();
});

# REGISTER
$app->get('/register', function (Request $request, Response $response) use ($app) {
	$service = new \Src\Services\RegisterService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});
$app->post('/register', function (Request $request, Response $response) use ($app) {
	$service = new \Src\Services\RegisterService($app->getContainer(), $request, $response, $params);
	return $service->handlePost();
});
$app->get('/verify/{token}', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\RegisterService($app->getContainer(), $request, $response, $params);
	return $service->handleVerify();
});

########################### MILESTONE 1 #######################################################

# MY PROFILE ROUTES
$app->get('/profile', function (Request $request, Response $response, $params) use ($app) {
	$service = new \Src\Services\ProfileService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});
$app->post('/profile', function (Request $request, Response $response) {
	echo '@todo - update my profile';die();
});

########################### MILESTONE 2 ##########################################################

# MEMBER PROFILES
$app->get('/profile/{username}', function (Request $request, Response $response, $params) {
	echo '@todo - view this user profile';
});
$app->post('/profile/{username}/like', function (Request $request, Response $response, $params) {
	echo '@todo - view this user profile';
});

########################### MILESTONE 3 ##########################################################

# MESSAGES
$app->get('/messages', function (Request $request, Response $response) use ($app) {
	$service = new \Src\Services\MessagesService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});

$app->get('/messages/{username}', function (Request $request, Response $response, $params) {
	echo '@todo - view my messages with another member';
});

############################# MILESTONE 4 ##########################################################

# MEMBER LIST
$app->get('/browse', function (Request $request, Response $response) use ($app) {
	$service = new \Src\Services\BrowseService($app->getContainer(), $request, $response, $params);
	return $service->viewPage();
});

############################ MILESTONE 5 ##############################################################

# RESET PASSWORD FEATURES
$app->get('/reset-password', function (Request $request, Response $response) {
	echo '@todo - view the page to request a password reset';
});
$app->post('/reset-password', function (Request $request, Response $response) {
	echo '@todo - submit the form to request a password and show thank you message';
});
$app->get('/reset-password/{hash}', function (Request $request, Response $response) {
	echo '@todo - view the reset password page';
});
$app->post('/reset-password/{hash}', function (Request $request, Response $response) {
	echo '@todo - reset the password and redirect to login page';
});
