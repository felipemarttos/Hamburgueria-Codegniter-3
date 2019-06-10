<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }
	public function index()
	{
        $dados["title"] = "Dashboard - Painel de Controle";
		//$this->load->model('assinante');
        $dados["active"] = "dashboard";

		//$dados["list"] = Assinante::all()->toArray();

		$this->load->view('layout/app/header', $dados);
		$this->load->view('layout/app/menu', $dados);
        $this->load->view('app/home/index', $dados);
        $this->load->view('layout/app/footer');
	}
}

