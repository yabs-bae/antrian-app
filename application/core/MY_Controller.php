<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller{

	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
	}

}