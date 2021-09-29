<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert extends CI_Controller  {

	protected $CI;

	public function __construct()
	{	
		$this->CI =& get_instance();
	}
	public function alertsuccess($status=null)
	{
		# code...
		echo '<div class="alert alert-success ks-solid ks-active-border" role="alert">';
		echo '	<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '		<span aria-hidden="true" class="fa fa-close"></span>';
		echo '	</button>';
		echo '	<h5 class="alert-heading">Alert</h5>';
		echo '		<ul>';
		echo "			<li>$status</li>";
		echo '		</ul>';
		echo '</div>';

	}

	public function alertdanger($error=null)
	{
		
		echo '<div class="alert icon-custom-alert alert-outline-pink b-round fade show" role="alert">  ';                                          
		echo '	<i class="mdi mdi-alert-outline alert-icon"></i>';
		echo '	<div class="alert-text">';
		// echo '		<strong>Oh snap!</strong> Change a few things up and try submitting again.';
		echo '		<ul>';
		if($error==null){
        	echo "<li><strong>Oh snap!</strong> Something Error</li>";
		}else{
        	echo "$error";
		}
		echo '		</ul>';
		echo '	</div>';
		echo '	';
		echo '	<div class="alert-close">';
		echo '		<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '			<span aria-hidden="true"><i class="mdi mdi-close text-danger"></i></span>';
		echo '		</button>';
		echo '	</div>';
		echo '</div>';
	}

}
