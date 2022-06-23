<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mail extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function send()
	{

		$this->load->library('email');

		$this->email->from('navidaziz98@gmail.com', 'Navid Aziz');
		$this->email->to('info@darewro.com');
		// $this->email->cc('another@another-example.com');
		// $this->email->bcc('them@their-example.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		if ($this->email->send()) {
			echo "mail send";
		} else {
			echo "error";
		}
	}
}
