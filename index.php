<?php 

require_once 'core/init.php';

if(session::exists('success')){
	echo session::flash('success');
}

$user = new user();

if($user->isLoggedIn()) {
?>
<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

<ul>
	<li><a href="logout.php">Log Out</a></li>
	<li><a href="update.php">Update Details</a></li>
	<li><a href="changepassword.php">Change Password</a></li>
</ul>
<?php 

	if ($user->hasPermission('admin')) {
		echo "You are an admin";
	}

} else {
	echo "<p>You Need To <a href='login.php'>Log In</a> Or <a href='register.php'>Register</a></p>";
}