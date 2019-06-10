<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sobre extends CI_Controller {
	function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('pagina');
    }
	public function index()
	{
        $dados["title"] = "Sobre a Hamburgueria";
        $dados["active"] = "sobre";

		$dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados["sobre"]         = Pagina::where([["codigo", "=", "sobre"], ["status", "=", "A"]])->first()->toArray();

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/sobre/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
