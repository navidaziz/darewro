<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mail extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function send()
	{
		error_reporting();
		// 	$this->load->library('email');

		// 	$this->email->from('navidaziz98@gmail.com', 'Navid Aziz');
		// 	$this->email->to('info@darewro.com');
		// 	// $this->email->cc('another@another-example.com');
		// 	// $this->email->bcc('them@their-example.com');

		// 	$this->email->subject('Email Test');
		// 	$this->email->message('Testing the email class.');

		// 	if ($this->email->send()) {
		// 		echo "mail send";
		// 	} else {
		// 		echo "error";
		// 	}
		$mail_to_send_to = "navidaziz98@gamil.com";
		$from_email = "navidaziz98@gmail.com";
		$sendflag = 'send';
		$name = 'navidaziz';
		if ($sendflag == "send") {
			$subject = "Message subject";
			$email = 'navidaziz98@gamil.com';
			$message = "\r\n" . "Name: $name" . "\r\n"; //get recipient name in contact form
			//$message = $message . $_REQUEST['message'] . "\r\n"; //add message from the contact form to existing message(name of the client)
			$headers = "From: $from_email" . "\r\n" . "Reply-To: $email";
			$a = mail($mail_to_send_to, $subject, $message, $headers);
			if ($a) {
				print("Message was sent, you can send another one");
			} else {
				print("Message wasn't sent, please check that you have changed emails in the bottom");
			}
		}
	}
}
