<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Xml extends CI_Controller {

	function sitemap()
	{

		$this->load->model('App_model');

		$data = array(); // potom zmaž

		//  $data = new stdClass();

		//$data['menu'] = getMenu(true);

		header("Content-Type: text/xml;charset=UTF-8");
		$this->load->view("xml/sitemap",$data);
	}







}
