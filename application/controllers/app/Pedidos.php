<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {
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
    }
     /*
    ** METODO RESPONSAVEL PELA LISTAGEM
    **
    */
    public function index()
    {
        $dados["active"] = "pedidos";
        $dados["title"]  = "Listagem de Pedidos";

        if ($this->input->post()) {
            $dadosBusca = $this->input->post();

            if (isset($dadosBusca["busca_n_pedido"]) && strlen($dadosBusca["busca_n_pedido"]) > 0) {

                $condBusca[] = ["tb_pedidos.id", "=", $dadosBusca["busca_n_pedido"]];

            } else {

                if (isset($dadosBusca["busca_cliente"]) && strlen($dadosBusca["busca_cliente"]) > 0) {

                    $condBusca[] = ["tb_pedidos.id_cliente", "=", $dadosBusca["busca_cliente"]];

                }

            }
        
        } else {
            $condBusca[] = ["tb_pedidos.status", "!=", "E"];
        }
        $dados_pedidos = Pedido::join('tb_formas_pagamentos', 'tb_formas_pagamentos.id', '=', 'tb_pedidos.id_forma_pagamento')
                               ->join('tb_status_pedidos', 'tb_status_pedidos.id', '=', 'tb_pedidos.id_status_pedido')
                               ->where($condBusca)
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
                $dados_pedidos_itens   = [];
                $dados_pedidos_cliente  = [];
                $dados_pedidos_entrega = [];
                $responsePedidoItens   = PedidoItem::join('tb_produtos', 'tb_produtos.id', '=', 'tb_pedidos_itens.id_produto')

                                                 ->where("tb_pedidos_itens.id_pedido", "=",$rows["id"])
                                                 ->get(["tb_pedidos_itens.*","tb_produtos.nome AS nome_produto"]);

                if (!empty($responsePedidoItens)) {
                    $dados_pedidos_itens = $responsePedidoItens->toArray();
                }


                $responseClienteEndereco = ClienteEndereco::where("id", "=",$rows["id_cliente_endereco"])
                                                 ->first();

                if (!empty($responseClienteEndereco)) {
                    $dados_pedidos_entrega = $responseClienteEndereco->toArray();
                }
                $responseCliente   = Cliente::where("id", "=", $rows["id_cliente"])
                                                 ->first();

                if (!empty($responseCliente)) {
                    $dados_pedidos_cliente = $responseCliente->toArray();
                }

                $dados_pedidos[$key]["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
                $dados_pedidos[$key]["dados_pedidos_itens"]    = $dados_pedidos_itens;
                $dados_pedidos[$key]["dados_pedidos_cliente"]   = $dados_pedidos_cliente;
            }
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }


        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();

        $responseCliente = Cliente::where("status", "!=", "E")->get();
        $dados_pedidos_cliente = [];
        if (!empty($responseCliente)) {
            $dados_pedidos_cliente = $responseCliente->toArray();
        }


        $dados["clientes"] = $dados_pedidos_cliente;

        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/pedidos/index', $dados);
        $this->load->view('layout/app/footer');
    }

     /*
    ** METODO RESPONSAVEL PELA IMPRESSAO
    **
    */
    public function print()
    {
        
        $id_pedido = $this->uri->segment(4);

        $dados["title"]         = "Meus Pedidos";
        $dados["active"]        = "pedidos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados_pedidos          = Pedido::join('tb_formas_pagamentos', 'tb_formas_pagamentos.id', '=', 'tb_pedidos.id_forma_pagamento')
                                        ->join('tb_status_pedidos', 'tb_status_pedidos.id', '=', 'tb_pedidos.id_status_pedido')
                                        ->where("tb_pedidos.id", "=", $id_pedido)
                                        ->first([
                                                "tb_pedidos.*", 
                                                "tb_formas_pagamentos.nome AS nome_forma", 
                                                "tb_formas_pagamentos.imagem AS imagem_forma",
                                                "tb_status_pedidos.nome AS nome_status", 
                                                "tb_status_pedidos.codigo AS codigo_status",
                                                "tb_status_pedidos.cor AS cor_status", 
                                            ]);

        if (!empty($dados_pedidos)) {
            $rows = $dados_pedidos->toArray();
            $dados_pedidos_itens   = [];
            $dados_pedidos_cliente   = [];
            $dados_pedidos_entrega = [];
            $responsePedidoItens   = PedidoItem::join('tb_produtos', 'tb_produtos.id', '=', 'tb_pedidos_itens.id_produto')
                                             ->where("tb_pedidos_itens.id_pedido", "=",$rows["id"])
                                             ->get(["tb_pedidos_itens.*","tb_produtos.nome AS nome_produto"]);

            if (!empty($responsePedidoItens)) {
                $dados_pedidos_itens = $responsePedidoItens->toArray();
            }

        

                $responseClienteEndereco = ClienteEndereco::where("id", "=",$rows["id_cliente_endereco"])
                                                 ->first();

                $responseCliente   = Cliente::where("id", "=", $rows["id_cliente"])
                                                 ->first();

                if (!empty($responseCliente)) {
                    $dados_pedidos_cliente = $responseCliente->toArray();
                }


                if (!empty($responseClienteEndereco)) {
                    $dados_pedidos_entrega = $responseClienteEndereco->toArray();
                }

                $dados_pedidos["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
                $dados_pedidos["dados_pedidos_itens"]    = $dados_pedidos_itens;
                $dados_pedidos["dados_pedidos_cliente"]   = $dados_pedidos_cliente;
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }

        $this->load->view('layout/site/header_print', $dados);
        $this->load->view('site/clientes/print', $dados);
    }

     /*
    ** METODO RESPONSAVEL POR ALTERAÇÃO DE STATUS
    **
    */
    public function altera_status() {

        $dados_post = $this->input->post();
        if (strlen($dados_post["id_pedido"]) > 0 && strlen($dados_post["id_status_pedido"]) > 0) {
            $update = Pedido::find($dados_post["id_pedido"]);
            $update->id_status_pedido   = $dados_post["id_status_pedido"];
            $response = $update->save();
            if ($response) {
                exit(json_encode(["erro" => false, "msg" => "Status do pedido atualizado com sucesso"]));
            } else {
                exit(json_encode(["erro" => true, "msg" => "Erro ao atualiza o status do pedido"]));
            }
        } else {
            exit(json_encode(["erro" => true, "msg" => "Erro ao atualiza o status do pedido"]));
        }
    }
}
