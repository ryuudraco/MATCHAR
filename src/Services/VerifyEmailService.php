<?php

namespace Src\Services;

use Slim\Http\Request;
use Slim\Http\Response;
use Src\Utils\Crypt;
use Src\Utils\DB;
use Src\Utils\Mail;
use Src\Utils\Validator;

class VerifyEmailService extends Service 
{
	/**
	 * Just render the register page
	 */
	public function viewPage()
	{
		return $this->render('verify-email.html');
	}

	/**
	 * try register the user with their details.
	 * if fail, render the registe page with the error
	 * if success, send mail with validate link and show success page
	 */
	public function handlePost() {
		$fields = $this->input([
			'username',
			'email',
		]);

		$validation_result = Validator::validate($fields, [
			'email' => 'required',
		]);

		if ($validation_result !== true) {
			$this->debug($validation_result);
			return $this->render('verify-email.html', ['validation_errors' => $validation_result]);
		}

		# @todo - do a DB::select and see if the username or email already exists?
		$verify_token = md5($fields['username'] . time() . rand());

		$password = Crypt::hash($fields['password']);

		DB::execute('
			INSERT INTO users (
				email, 
				updated_at, 
				verify_token, 
			) 
			VALUES (?, ?, ?, ?)', 
			[
				$fields['email'],
				date('Y-m-d H:i:s'),
				date('Y-m-d H:i:s'),
				$verify_token,
			]
		);

		if ($fields.email == DB::select('users'.'email') {
			Mail::send(
				'Verify your registration',
				[
					'no-reply@dating-app.com' => 'Dating App - No Reply',
				],
				[
					$fields['email'] => $fields['first_name'] . ' ' . $fields['last_name'],
				],
				'Please click this link to reset your password: http://' . $_SERVER['HTTP_HOST'] . '/verify/' . $verify_token
			);
	
			return $this->render('home.html');
		}

	}

	public function handleVerify() {
		$verification_token = $this->url_params['token'];

		DB::execute('UPDATE users SET verify_at = ? WHERE verify_token = ?', [date('Y-m-d H:i:s'), $verification_token]);

		return $this->redirect('/home');
	}
}