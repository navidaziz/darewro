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
		error_reporting(-1);
		ini_set('display_errors', 'On');
		set_error_handler("var_dump");
		// The message

		// $message = "Line 1\r\nLine 2\r\nLine 3";

		// // In case any of our lines are larger than 70 characters, we should use wordwrap()

		// $message = wordwrap($message, 70, "\r\n");

		// // Send

		// if (mail('navidaziz98@gmail.com', 'My Subject', $message)) {
		// 	echo "email send";
		// } else {
		// 	echo "error";
		// }

		$to = "navidaziz98@gamil.com";
		$subject = "My subject";
		$txt = "Hello world!";
		$headers = "From: info@darewro.com" . "\r\n" .
			"CC: somebodyelse@example.com";

		mail($to, $subject, $txt, $headers);
	}
}
