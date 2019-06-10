<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {
	function __construct() {
        parent::__construct();
    }
	public function index()
	{
        $dados["title"] = "Cardápio";
        $dados["active"] = "dashboard";

		$dados["configuracoes"] = Configuracao::first()->toArray();

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/contato/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
