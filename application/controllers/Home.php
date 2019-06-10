<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('cliente');
         $this->load->model('produto');
         $this->load->model('categoria');
         $this->load->model('pedido');
         $this->load->model('formaPagamento');
         $this->load->model('clienteEndereco');
         $this->load->model('pedidoItem');
         $this->load->model('statusPedido');
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

		if (isset($_SESSION["cliente"]) && $_SESSION["cliente"]["logged"] == true) {
			$meus_enderecos	= ClienteEndereco::where("id_cliente","=",$_SESSION["cliente"]["id"])
												->orderBy("titulo", "ASC")
												->get();
			$dados["meus_enderecos"] = [];
			if (!empty($meus_enderecos)) {
				$meus_enderecos = $meus_enderecos->toArray();
				$dados["meus_enderecos"] = $meus_enderecos;
			}
			$formas_pagamentos	= FormaPagamento::where("status","=","A")
												->orderBy("nome", "ASC")
												->get();
			$dados["formas_pagamentos"] = [];
			if (!empty($formas_pagamentos)) {
				$formas_pagamentos = $formas_pagamentos->toArray();
				$dados["formas_pagamentos"] = $formas_pagamentos;
			}

		}


		$dados["categorias"] 	= Categoria::orderBy("ordem", "ASC")->get()->toArray();
		$dados["produtos"] 	    = $produtos;

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/home/index', $dados);
        $this->load->view('layout/site/footer');
	}


    public function modal_add_carrinho()
    {
    	$id_produto = $this->uri->segment(3);
    	$dados["title"] = "Escolha a quantidade deste item";
		$produtos 	= Produto::where("id","=", $id_produto)->first();
		if (!empty($produtos)) {
			$dados["produtos"] 	= $produtos->toArray();
		}

        $this->load->view('site/home/modal_add_carrinho', $dados);
    }

    public function add_carrinho()
    {
    	$dados_post = $this->input->post();

    	if (strlen($dados_post["id_produto"]) == 0 || strlen($dados_post["qtde_item"]) == 0) {
    		exit(json_encode(["erro" => true, "msg" => "Erro ao adicionar"]));
    	} else {
    		$_SESSION["carrinho"]["id_produto"][] = $dados_post["id_produto"];
    		$_SESSION["carrinho"]["qtde_item"][]  = $dados_post["qtde_item"];
    		$_SESSION["carrinho"]["obs_item"][]   = $dados_post["obs_item"];
    		$_SESSION["carrinho"]["nome_item"][]   = $dados_post["nome"];
    		$_SESSION["carrinho"]["preco_item"][]   = $dados_post["preco"];
    		exit(json_encode(["erro" => false, "msg" => "Adicionado com sucesso"]));
    	}

    }
    public function delete_carrinho()
    {
    	$dados_post = $this->input->post();
    	if (strlen($dados_post["posicao"]) > 0) {
    		$posicao = $dados_post["posicao"];
    		unset($_SESSION["carrinho"]["id_produto"][$posicao]);
    		unset($_SESSION["carrinho"]["qtde_item"][$posicao]);
    		unset($_SESSION["carrinho"]["obs_item"][$posicao]);
    		unset($_SESSION["carrinho"]["nome_item"][$posicao]);
    		unset($_SESSION["carrinho"]["preco_item"][$posicao]);
    		exit(json_encode(["erro" => false, "msg" => "Removido com sucesso"]));
    	} else {
    		exit(json_encode(["erro" => true, "msg" => "Erro ao remover"]));
    	}

    }
    public function finaliza()
    {
    	$logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }
    	$dados_post = $this->input->post();

    	if (strlen($dados_post["total_item"]) > 0 && strlen($dados_post["forma_envio"]) > 0 && strlen($dados_post["id_forma_pagamento"]) > 0) {

    		$configuracoes = Configuracao::first()->toArray();
    		$statusPedido  = StatusPedido::where("codigo", "=", "AGUARDANDO")->first()->toArray();

    		$total_itens_pedidos = [];
    		for ($i=0; $i < count($_SESSION["carrinho"]["id_produto"]); $i++) { 
    			$itens_pedidos[$i]["id_produto"] 		= $_SESSION["carrinho"]["id_produto"][$i];
    			$itens_pedidos[$i]["valor_unitario"] 	= $_SESSION["carrinho"]["preco_item"][$i];
    			$itens_pedidos[$i]["quantidade"] 		= $_SESSION["carrinho"]["qtde_item"][$i];
    			$itens_pedidos[$i]["obs"] 				= $_SESSION["carrinho"]["obs_item"][$i];
    			$total_itens_pedidos[]                  = ($_SESSION["carrinho"]["qtde_item"][$i]*$_SESSION["carrinho"]["preco_item"][$i]);
    		}

    		$insert           				= new Pedido;
            $insert->id_forma_pagamento  	= $dados_post["id_forma_pagamento"];
            $insert->id_cliente  			= $_SESSION["cliente"]["id"];
            $insert->id_status_pedido  		= $statusPedido["id"];
            $insert->data  					= date("Y-m-d H:i:s");
            $insert->total_pedido_itens  	= array_sum($total_itens_pedidos);
            $insert->status  				= "A";

            if ($dados_post["forma_envio"] == "retirar") {
            	$insert->retirar_na_loja  		= "S";
            	$taxa_entrega                   = 0;
            } else {
            	$insert->id_cliente_endereco  	= $dados_post["forma_envio"];
            	$insert->taxa_entrega  			= $configuracoes["taxa_entrega"];
            	$taxa_entrega                   = $configuracoes["taxa_entrega"];
            }
            $insert->total_pedido  			= array_sum($total_itens_pedidos)+$taxa_entrega;
            $response         				= $insert->save();

            $msg_erro = [];
            $msg_success = [];
            if ($response) {

            	$id_pedido						= $insert->getAttributes()['id'];
            	foreach ($itens_pedidos as $key => $row) {
					$insertItens					= new PedidoItem;
					$insertItens->id_pedido  		= $id_pedido;
					$insertItens->id_produto		= $row["id_produto"];
					$insertItens->data  			= date("Y-m-d H:i:s");
					$insertItens->valor_unitario	= $row["valor_unitario"];
					$insertItens->quantidade  		= $row["quantidade"];
					$insertItens->status			= "A";
					$insertItens->obs  				= $row["obs"];
					$response         				= $insertItens->save();
					if (!$response) {
						$msg_erro[] = "Erro ao inserir item no pedido";
					}
					unset($insertItens);
            	}
            	if (count($msg_erro) == 0) {
            		$msg_success[] = "Pedido realizado com Sucesso";
            		$dados = $this->getPedido($id_pedido);
            		unset($_SESSION["carrinho"]);
            	}
            } else {
				$msg_erro[] = "Erro ao inserir pedido";
            }


            $dados["msg_success"] 	= $msg_success;
            $dados["msg_erro"] 		= $msg_erro;
	        $dados["title"]  		= "Cardápio";
	        $dados["active"] 		= "dashboard";
			$dados["configuracoes"] = Configuracao::first()->toArray();
			$dados["expedientes"] 	= Expediente::first()->toArray();


			$this->load->view('layout/site/header', $dados);
			$this->load->view('layout/site/menu', $dados);
	        $this->load->view('site/home/finaliza_pedido', $dados);
	        $this->load->view('layout/site/footer');


    	}
    }



    public function getPedido($id_pedido)
    {
       
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

            $dados_pedidos["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
            $dados_pedidos["dados_pedidos_itens"]    = $dados_pedidos_itens;
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }

        return $dados;
    }


}
