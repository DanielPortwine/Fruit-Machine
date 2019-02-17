<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('header.php');

$taken = false;
$rows = $conn->query("SELECT userID FROM users;")->num_rows;

// if there are users check if the username is taken
if ($rows > 0) {
	foreach ($conn->query("SELECT username FROM users;") as $user) {
		if ($_POST['username'] == $user['username']) {
			$taken = true;
			break;
		}
	}
}

// if the username is not taken generate password hash using salt
if (!$taken) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$salt = '';
	for ($i=0; $i<128; $i++) {
		$salt .= $characters[rand(0,35)];
	}
	$password = hash('sha512',$salt . $_POST['password']);
	if (isset($_POST['newsContent'])) {
		$consent = 1;
	}
	else {
		$consent = 0;
	}
	// create user's record in database
	$conn->query("INSERT INTO users (username,email,news,pass,salt) VALUES ('{$_POST['username']}','{$_POST['email']}',{$consent},'{$password}','{$salt}');");
	$userID = $conn->insert_id;
	// alert user that their account has been created
	$_SESSION['alert'] = 'Account created';
	$_SESSION['alert-type'] = 'success';
	// log the user in
	$_SESSION['username'] = $_POST['username'];
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = $config['email']['server'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['email']['user'];
        $mail->Password = $config['email']['pass'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $config['email']['port'];

        //Recipients
        $mail->setFrom($config['email']['user']);
        $mail->addBCC($_POST['email']);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome!';
        $body = '<h2>Welcome!</h2><br>Welcome, ' . $_POST['username'] . ', to the fruit machine! To confirm your account and get started, please click the link below:<br><a href="http://fruitmachine.danportwine.co.uk/verify?unique=' . $salt . '&user=' . $userID . '">Click here to start!</a>';
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
	// redirect to play
	//echo '<script>window.location = "play";</script>';
}

// if username is taken alert user that the username is taken and redirect to login
else {
	$_SESSION['alert'] = 'Username taken';
	$_SESSION['alert-type'] = 'danger';
	echo '<script>window.location = "index";</script>';
}