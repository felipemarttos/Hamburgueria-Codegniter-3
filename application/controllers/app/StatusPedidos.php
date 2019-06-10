<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatusPedidos extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
        $this->load->model('statusPedido');
    }
    /*
    ** METODO RESPONSAVEL POR LISTAR STATUS PEDIDOS
    **
    */
    public function index()
    {
        $dados["active"] = "statusPedidos";
        $dados["title"]  = "Listagem de Status de Pedidos";
        $dados["list"]   = StatusPedido::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/status_pedidos/index', $dados);
        $this->load->view('layout/app/footer');
    }
}
