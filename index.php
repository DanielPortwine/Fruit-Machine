<?php
require_once('header.php');
$_SESSION['page'] = 'index';
if (isset($_SESSION['username'])) {
	echo '<script>window.location = "play.php";</script>';
}
?>
<div class="mx-auto mt-5 card">
	<h5 class="card-header text-center" id="loginStateTitle">Login</h5>
	<div class="card-body">
		<!-- Login form -->
		<form action="login.php" method="post" id="loginForm">
			<div class="form-group">
				<input type="text" class="form-control" name="username" placeholder="Username" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password" required>
			</div>
			<button type="submit" class="btn btn-success btn-block">Login</button>
		</form>
		<!-- Sign up form -->
		<form action="signUp.php" method="post" id="signUpForm">
			<div class="form-group">
				<input type="text" class="form-control" name="username" placeholder="Username" required>
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Email" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password" required>
			</div>
			<div class="form-group">
				<input type="checkbox" name="newsConsent" value="Yes"><p id="newsText"> I want to receive news about the site</p>
			</div>
			<button type="submit" class="btn btn-success btn-block">Sign up</button>
		</form>
		<button class="btn btn-default btn-sm float-right" id="loginStateButton">Sign up</button>
	</div>
</div>
<?php
require_once('footer.html');
?>