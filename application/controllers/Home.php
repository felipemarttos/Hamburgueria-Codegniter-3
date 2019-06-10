<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
    }
	public function index()
	{
        $dados["title"]  		= "Cardápio";
        $dados["active"] 		= "dashboard";
		$dados["configuracoes"] = Configuracao::first()->toArray();
		$dados["expedientes"] 	= Expediente::first()->toArray();
		$categorias         	= Categoria::orderBy("ordem", "ASC")->get()->toArray();

		foreach ($categorias as $key => $rows) {
			$produtos[$rows["id"]]["id"] 	    = $rows["id"];
			$produtos[$rows["id"]]["nome"] 	    = $rows["nome"];
			$produtos[$rows["id"]]["ordem"] 	    = $rows["ordem"];
			$produtos[$rows["id"]]["produtos"] 	= Produto::where("id_categoria", "=", $rows["id"])->get()->toArray();
		}
		$dados["categorias"] 	= Categoria::orderBy("ordem", "ASC")->get()->toArray();
		$dados["produtos"] 	    = $produtos;

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/home/index', $dados);
        $this->load->view('layout/site/footer');
	}
}
