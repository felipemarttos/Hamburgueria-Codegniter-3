<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termos extends CI_Controller {
	function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('pagina');
    }
	public function index()
	{
        $dados["title"] = "Termos de Uso";
        $dados["active"] = "termos";

		$dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados["termos"]        = Pagina::where([["codigo", "=", "termos"], ["status", "=", "A"]])->first()->toArray();

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/termos/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
