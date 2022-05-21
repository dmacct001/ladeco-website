<?php

	function sendEmail($r_email, $sbj, $msg) {
		$sender_name = "Project " . $_SESSION['system_code'];
		$smtp_server = getSMTPServer();
		$smtp_port = getSMTPPort();
		$use_ssl = getSMTPSSL();
		$email_username = getMailerUserName();
		$email_password = getMailerUserPassword();
		if ($use_ssl == 1) {
			$use_ssl = "ssl";
		} else {
			$use_ssl = "";
		}

		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		try {
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false, 'allow_self_signed' => true));
			$mail->SMTPSecure = $use_ssl;
			$mail->Host = $smtp_server;
			$mail->Port = $smtp_port;
			$mail->IsHTML(true);
			$mail->Username = $email_username;
			$mail->Password = $email_password;
			$mail->From = $email_username;
			$mail->FromName = $sender_name;
			$mail->AddAddress($r_email);
			$mail->Subject = $sbj;
			$mail->Body = composeHTMLmsg($msg);
			$mail->send();
			$mail->SmtpClose();
			return true;
		} catch (Exception $e) {
			$mail->SmtpClose();
			return $mail->ErrorInfo;
		}
	}

	function sendEmail_Attachment($r_email, $sbj, $msg, $target_file) {
		$sender_name = "Project " . $_SESSION['system_code'];
		$smtp_server = getSMTPServer();
		$smtp_port = getSMTPPort();
		$use_ssl = getSMTPSSL();
		$email_username = getMailerUserName();
		$email_password = getMailerUserPassword();
		if ($use_ssl == 1) {
			$use_ssl = "ssl";
		} else {
			$use_ssl = "";
		}

		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		try {
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false, 'allow_self_signed' => true));
			$mail->SMTPSecure = $use_ssl;
			$mail->Host = $smtp_server;
			$mail->Port = $smtp_port;
			$mail->IsHTML(true);
			$mail->Username = $email_username;
			$mail->Password = $email_password;
			$mail->From = $email_username;
			$mail->FromName = $sender_name;
			$mail->AddAddress($r_email);
			$mail->AddAttachment($target_file, 'bulk_personnel_data_processing_result.csv');
			$mail->Subject = $sbj;
			$mail->Body = composeHTMLmsg($msg);
			$mail->send();
			$mail->SmtpClose();
			return true;
		} catch (Exception $e) {
			$mail->SmtpClose();
			return $mail->ErrorInfo;
		}
	}

	function composeHTMLmsg($body) {
		$logo_link = cServerURL() . "/repository/" . getLogo();
		$html = '
		<body style="margin: 0; padding: 0;">
			<div style="margin: 0 auto; max-width: 600px; border-radius: 10px; border: 2px #0068ad solid; background-color: #e6e6e6">
				<center>
					<img src="'.$logo_link.'" style="margin-top: 15px; width: 25%; height: 25%;">
					<h4>'.getEndUser().'<br />'.getPlatformName().'</h4>
				</center>
				<div style="margin: 0 auto; max-width: 550px;">'.$body.'
				</div>
			</div>
		</body>';
		return $html;
	}

?>