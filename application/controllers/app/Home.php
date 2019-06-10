<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
        $this->load->model('configuracao');
        $this->load->model('expediente');
        $this->load->model('cliente');
        $this->load->model('pedido');
        $this->load->model('pedidoItem');
        $this->load->model('clienteEndereco');
        $this->load->model('statusPedido');
    }

    /*
    ** METODO RESPONSAVEL PELO ACOMPANHAMENTO DE PEDIDOS
    **
    */
    public function index()
    {
        $dados["title"]         = "Acompanhamento de Pedidos";
        $dados["active"]        = "home";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $data_ini = date('Y-m-d')." 00:00:00";
        $data_fim = date('Y-m-d')." 23:59:59";
        $condBusca[]   = ["tb_pedidos.status", "!=", "E"];
        $dados_pedidos = Pedido::join('tb_formas_pagamentos', 'tb_formas_pagamentos.id', '=', 'tb_pedidos.id_forma_pagamento')
                               ->join('tb_status_pedidos', 'tb_status_pedidos.id', '=', 'tb_pedidos.id_status_pedido')
                               ->orderBy("tb_pedidos.data", "DESC")
                               ->where($condBusca)
                               ->whereBetween('tb_pedidos.data', [$data_ini, $data_fim])
                               ->whereNotIn('tb_status_pedidos.codigo', ['CANCELADO','FINALIZADO'])
                               ->get([
                                    "tb_pedidos.*", 
                                    "tb_formas_pagamentos.nome AS nome_forma", 
                                    "tb_formas_pagamentos.imagem AS imagem_forma",
                                    "tb_status_pedidos.nome AS nome_status", 
                                    "tb_status_pedidos.codigo AS codigo_status",
                                    "tb_status_pedidos.cor AS cor_status", 
                                ]);
                                

        if (!empty($dados_pedidos)) {
            $dados_pedidos = $dados_pedidos->toArray();
            foreach ($dados_pedidos as $key => $rows) {
                $dados_pedidos_cliente   = [];
                $dados_pedidos_itens   = [];
                $dados_pedidos_entrega = [];
                $responsePedidoItens   = PedidoItem::join('tb_produtos', 'tb_produtos.id', '=', 'tb_pedidos_itens.id_produto')
                                                 ->where("tb_pedidos_itens.id_pedido", "=",$rows["id"])
                                                 ->get(["tb_pedidos_itens.*","tb_produtos.nome AS nome_produto"]);

                if (!empty($responsePedidoItens)) {
                    $dados_pedidos_itens = $responsePedidoItens->toArray();
                }

                $responseCliente   = Cliente::where("id", "=", $rows["id_cliente"])
                                                 ->first();

                if (!empty($responseCliente)) {
                    $dados_pedidos_cliente = $responseCliente->toArray();
                }

               
                $responseClienteEndereco = ClienteEndereco::where("id", "=",$rows["id_cliente_endereco"])
                                                 ->first();

                if (!empty($responseClienteEndereco)) {
                    $dados_pedidos_entrega = $responseClienteEndereco->toArray();
                }

                $dados_pedidos[$key]["dados_pedidos_cliente"]  = $dados_pedidos_cliente;
                $dados_pedidos[$key]["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
                $dados_pedidos[$key]["dados_pedidos_itens"]    = $dados_pedidos_itens;
            }
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }

        $dados["status_pedidos"]   = StatusPedido::orderBy("id", "ASC")->get()->toArray();


        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/home/index', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL POR ABRIR E FECHAR LOJA
    **
    */
    public function abre_fecha_loja()
    {
        
        $dados_post = $this->input->post();
        if ($dados_post["status"] == "S") {
            $text_status = "Aberta";
            $text_status_err = "abrir";
        } else {
            $text_status = "Fechada";
            $text_status_err = "fechar";
        }
        if (strlen($dados_post["status"]) > 0) {
            $update           = Expediente::find(1);
            $update->aberto   = $dados_post["status"];
            $response         = $update->save();

            if ($response) {
                exit(json_encode(["erro" => false, "msg" => "Loja {$text_status} com sucesso"]));
            } else {
                exit(json_encode(["erro" => true, "msg" => "Erro ao $text_status_err a loja"]));
            }
        } else {
            exit(json_encode(["erro" => true, "msg" => "Erro ao $text_status_err a loja"]));
        }
    }

}

