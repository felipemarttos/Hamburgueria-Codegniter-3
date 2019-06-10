<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormasPagamentos extends CI_Controller {
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
        $this->load->view('site/formas_pagamentos/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
