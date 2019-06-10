<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormasPagamentos extends CI_Controller {
	function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('formaPagamento');
    }
	public function index()
	{
        $dados["title"] = "Formas  de Pagamentos";
        $dados["active"] = "formas";

		$dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados["formas"]        = FormaPagamento::all()->toArray();

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/formas_pagamentos/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
