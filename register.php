<?php 
require_once 'core/init.php';


if (input::exists()){
	if(token::check(input::get('token'))){
		$validate   = new validate();
		$validation = $validate->check($_POST, array(
			'username' 		 => array(
				'required' => true,
				'min' 	   => 2,
				'max'	   => 20,
				'unique'   => 'users',
			),
			'password'       => array(
				'required' => true,
				'min'	   => 6
			),
			'password-again' => array(
				'required' => true,
				'matches'  => 'password'
			),
			'name' 			 => array(
				'required' => true,
				'min'	   => 2,
				'max'	   => 50
			)
		));

		if($validation->passed()){

			$user = new user();

			$salt = hash::salt(32);


			try {
				$user->create(array(

					'username' => input::get('username'),
					'password' => hash::make(input::get('password'), $salt),
					'salt' 	   => $salt,
					'name' 	   => input::get('name'),
					'joined'   => date('Y-m-d H:i:s'),
					'groups'   => 1

				));

				session::flash('success', 'You have been registered successfully');
				redirect::to('index.php');
				
			} catch (Exception $e) {
				$die($e->getMessage());
			}
		}else {
			foreach ($validation->errors() as $error) {
				echo $error."<br>";
			}
		}
	}
}
?>


<form accept="" method="POST">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo htmlentities(input::get('username')) ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password">
	</div>

	<div class="field">
		<label for="password-again">Enter the password again</label>
		<input type="password" name="password-again" id="password-again">
	</div>

	<div class="field">
		<label for="name">Enter your name</label>
		<input type="text" name="name" value="<?php echo htmlentities(input::get('name')) ?>" id="name">
	</div>

	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">

	<input type="submit" value="Register">
</form>