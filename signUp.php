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
	$verification = '';
	for ($i=0; $i<128; $i++) {
		$salt .= $characters[rand(0,35)];
		if ($i % 2 == 0) {
		    $verification .= $characters[rand(0,35)];
        }
	}
	$password = hash('sha512',$salt . $_POST['password']);
	if (isset($_POST['newsContent'])) {
		$consent = 1;
	}
	else {
		$consent = 0;
	}
	// create user's record in database
	$conn->query("INSERT INTO users (username,email,news,pass,salt,verification) VALUES ('{$_POST['username']}','{$_POST['email']}',{$consent},'{$password}','{$salt}','{$verification}');");
	$userID = $conn->insert_id;
	$_SESSION['verified'] = false;
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = $config['email']['server'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['email']['user'];
        $mail->Password = $config['email']['pass'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $config['email']['port'];

        //Recipients
        $mail->setFrom($config['email']['user'], $config['email']['name']);
        $mail->addBCC($config['email']['user']);
        $mail->addBCC($_POST['email']);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome!';
        $body = '
            <h1 style="color:#fff;background-color:#343a40;text-align:center;padding:20px">Welcome</h1>
            <div style="color:#202428;background-color:#fff;padding:20px 20px">
                <p>Hi ' .  $_POST['username'] . ',</p>
                <p>Welcome to the fruit machine! I am so glad that you have chosen to play my fruit machine. To confirm your account and get started, please click the button below.</p>
                <a style="color:#fff;background-color:#27a545;width:250px;display:block;margin:0 auto;border:none;border-radius:5px;padding:10px;text-align:center;text-decoration:none;font-size:18px" href="' . $config['server']['baseDomain'] . 'verify?unique=' . $verification . '&user=' . $userID . '" target="_blank">Verify</a>
                <p><sub>Un-verified accounts are purged on a regular basis so verify as soon as you can to avoid having to sign up again.</sub></p>
            </div>
        ' . $config['email']['signature'];
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        $_SESSION['alert'] = 'Verification email sent!';
        $_SESSION['alert-type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['alert'] = 'Verification email failed to send!';
        $_SESSION['alert-type'] = 'danger';
    }
	header('Location: index');
}

// if username is taken alert user that the username is taken and redirect to login
else {
	$_SESSION['alert'] = 'Username taken';
	$_SESSION['alert-type'] = 'danger';
	header('Location: index');
}