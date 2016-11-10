<?php

defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Tools extends CI_Controller {
	
	public function index(){
		phpinfo();
	}

	public function message($to = 'World')
	{
		echo "Hello {$to}!".PHP_EOL;
	}
}