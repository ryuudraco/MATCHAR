<?php

namespace Src\Services;

use Slim\Http\Request;
use Slim\Http\Response;
use Src\Utils\Crypt;
use Src\Utils\DB;
use Src\Utils\Mail;
use Src\Utils\Validator;

class RegisterService extends Service 
{
	/**
	 * Just render the register page
	 */
	public function viewPage()
	{
		return $this->render('reset-password.html');
	}

	/**
	 * try register the user with their details.
	 * if fail, render the registe page with the error
	 * if success, send mail with validate link and show success page
	 */
	public function handlePost() {
		$fields = $this->input([
			'password',
			'password_confirm',
		]);

		$validation_result = Validator::validate($fields, [
			'password' => 'required|password|confirm',
		]);

		if ($validation_result !== true) {
			$this->debug($validation_result);
			return $this->render('reset-password.html', ['validation_errors' => $validation_result]);
		}

		# @todo - do a DB::select and see if the username or email already exists?

		$password = Crypt::hash($fields['password']);

		DB::execute('
			INSERT INTO users (
				password, 
				updated_at, 
			) 
			VALUES (?, ?, ?)', 
			[
				$password,
				date('Y-m-d H:i:s'),
				date('Y-m-d H:i:s'),
			]
		);

		Mail::send(
			'Password has been changed',
			[
				'no-reply@dating-app.com' => 'Dating App - No Reply',
			],
			[
				$fields['email'] => $fields['first_name'] . ' ' . $fields['last_name'],
			],
			'Your password has been reset.'
		);

		return $this->render('login.html');
	}

	public function handleVerify() {
		$verification_token = $this->url_params['token'];

		DB::execute('UPDATE users SET verify_at = ? WHERE verify_token = ?', [date('Y-m-d H:i:s'), $verification_token]);

		return $this->redirect('/login');
	}
}
