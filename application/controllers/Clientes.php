<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('cliente');
         $this->load->model('pedido');
         $this->load->model('pedidoItem');
         $this->load->model('clienteEndereco');
    }

    public function index()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }

        $dados["title"]         = "Meus Pedidos";
        $dados["active"]        = "pedidos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados_pedidos          = Pedido::join('tb_formas_pagamentos', 'tb_formas_pagamentos.id', '=', 'tb_pedidos.id_forma_pagamento')
                                        ->join('tb_status_pedidos', 'tb_status_pedidos.id', '=', 'tb_pedidos.id_status_pedido')
                                        ->where("tb_pedidos.id_cliente", "=", $id)
                                        ->orderBy("tb_pedidos.data", "DESC")
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

                if (!empty($responseClienteEndereco)) {
                    $dados_pedidos_entrega = $responseClienteEndereco->toArray();
                }

                $responseCliente   = Cliente::where("id", "=", $rows["id_cliente"])
                                                 ->first();

                if (!empty($responseCliente)) {
                    $dados_pedidos_cliente = $responseCliente->toArray();
                }

                $dados_pedidos["dados_pedidos_cliente"]   = $dados_pedidos_cliente;
                $dados_pedidos[$key]["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
                $dados_pedidos[$key]["dados_pedidos_itens"]    = $dados_pedidos_itens;
            }
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }
        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('layout/site/menu_cliente', $dados);
        $this->load->view('site/clientes/index', $dados);
        $this->load->view('layout/site/footer');
    }

    public function print()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }
        $id_pedido = $this->uri->segment(3);

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
            $dados_pedidos_entrega = [];
            $dados_pedidos_cliente = [];
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

            $dados_pedidos["dados_pedidos_cliente"]   = $dados_pedidos_cliente;
            $dados_pedidos["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
            $dados_pedidos["dados_pedidos_itens"]    = $dados_pedidos_itens;
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }

        $this->load->view('layout/site/header_print', $dados);
        $this->load->view('site/clientes/print', $dados);
    }

    public function edit()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }

        if ($this->input->post()) {
            $dadosSave          = $this->input->post();
            $validaCamposVazios = $this->validaEdit($dadosSave);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

                $dados["msg_erro"] = $validaCamposVazios["msg"];

            } else {

                $validaDuplicado = Cliente::where([["email", "=", $dadosSave["email"]], ['id', "!=", $dadosSave["id"]]])->first();

                if (!empty($validaDuplicado)) {

                    $dados["msg_erro"] = ["Já existe um Cliente cadastrado com esse email"];

                } else {

                    $update             = Cliente::find($dadosSave["id"]);
                    $update->nome       = trim($dadosSave["nome"]);
                    $update->telefone   = trim($dadosSave["telefone"]);
                    $update->email      = trim($dadosSave["email"]);
                    if (strlen($dadosSave["nova_senha"]) > 0) {
                        $update->senha      = md5(trim($dadosSave["nova_senha"]));
                    }
                    $response           = $update->save($dadosSave);
                    if ($response) {
                        unset($dados);
                        $dados["msg_success"]   = ["Atualizado com sucesso"];
                    }

                }
            }
        }


        $dados["title"]         = "Meu Perfil";
        $dados["active"]        = "perfil";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados["dados_cliente"] = Cliente::where("id", "=", $id)->first()->toArray();

        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('layout/site/menu_cliente', $dados);
        $this->load->view('site/clientes/edit', $dados);
        $this->load->view('layout/site/footer');
    }

    public function add()
    {
        
        if ($this->input->post()) {
            $dados              = $this->input->post();
            $validaCamposVazios = $this->valida($dados);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

                $dados["msg_erro"] = $validaCamposVazios["msg"];

            } else {

                $validaDuplicado        = Cliente::where("email", "=", $dados["cad_email"])->first();

                if (!empty($validaDuplicado)) {

                    $dados["msg_erro"] = ["Já existe um Cliente cadastrado com esse email"];

                } else {

                    $insert             = new Cliente;
                    $insert->nome       = trim($dados["cad_nome"]);
                    $insert->status     = "A";
                    $insert->telefone   = trim($dados["cad_telefone"]);
                    $insert->email      = trim($dados["cad_email"]);
                    $insert->senha      = md5(trim($dados["cad_senha"]));
                    $response           = $insert->save($dados);
                    if ($response) {
                        unset($dados);
                        $dados["msg_success"]   = ["Cadastrado com sucesso, efetue o login ao lado"];
                    }

                }
            }
        } else {
            redirect('/login/index');
        }
        $dados["title"]         = "Cardápio";
        $dados["active"]        = "dashboard";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();

        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('site/login/index', $dados);
        $this->load->view('layout/site/footer');

    }


    public function enderecos()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }

        $dados["title"]         = "Meus Endereços";
        $dados["active"]        = "enderecos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();

        $dados_enderecos = ClienteEndereco::where([["id_cliente", "=", $id],["status", "!=", "E"]])->orderBy("id", "DESC")->get();
        if (!empty($dados_enderecos)) {
            $dados_enderecos = $dados_enderecos->toArray();
        } else {
            $dados_enderecos = [];
        }

        $dados["dados_enderecos"] = $dados_enderecos;

        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('layout/site/menu_cliente', $dados);
        $this->load->view('site/clientes/enderecos', $dados);
        $this->load->view('layout/site/footer');
    }


    public function editEndereco()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }
        if ($this->input->post()) {
            $dados              = $this->input->post();
            $validaCamposVazios = $this->validaEndereco($dados);
            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

                $dados["msg_erro"] = $validaCamposVazios["msg"];

            } else {
                $update                     = ClienteEndereco::find($dados["id"]);
                $update->id_cliente         = trim($dados["id_cliente"]);
                $update->titulo             = trim($dados["titulo"]);
                $update->cep                = trim($dados["cep"]);
                $update->endereco           = trim($dados["endereco"]);
                $update->numero             = trim($dados["numero"]);
                $update->complemento        = trim($dados["complemento"]);
                $update->ponto_referencia   = trim($dados["ponto_referencia"]);
                $update->bairro             = trim($dados["bairro"]);
                $update->cidade             = trim($dados["cidade"]);
                $update->uf                 = trim($dados["uf"]);
                $update->status             = "A";
                $response                   = $update->save();
                if ($response) {
                    $dados["msg_success"]   = ["Atualizado com sucesso"];
                }
            }




        } else {

            $id_endereco = $this->uri->segment(3);

            $dados_enderecos = ClienteEndereco::where([["id", "=", $id_endereco],["status", "!=", "E"]])->first();
            if (!empty($dados_enderecos)) {
                $dados_enderecos = $dados_enderecos->toArray();
            } else {
                $dados_enderecos = [];
            }

            $dados                  = $dados_enderecos;
        }
        $dados["title"]         = "Editar Endereço";
        $dados["active"]        = "enderecos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('layout/site/menu_cliente', $dados);
        $this->load->view('site/clientes/addendereco', $dados);
        $this->load->view('layout/site/footer');
    }


    public function addEndereco()
    {
        $logged   = $_SESSION["cliente"]["logged"];
        $id       = $_SESSION["cliente"]["id"];
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }

        if ($this->input->post()) {
            $dados              = $this->input->post();
            $validaCamposVazios = $this->validaEndereco($dados);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

                $dados["msg_erro"] = $validaCamposVazios["msg"];

            } else {

                $insert                     = new ClienteEndereco;
                $insert->id_cliente         = trim($dados["id_cliente"]);
                $insert->titulo             = trim($dados["titulo"]);
                $insert->cep                = trim($dados["cep"]);
                $insert->endereco           = trim($dados["endereco"]);
                $insert->numero             = trim($dados["numero"]);
                $insert->complemento        = trim($dados["complemento"]);
                $insert->ponto_referencia   = trim($dados["ponto_referencia"]);
                $insert->bairro             = trim($dados["bairro"]);
                $insert->cidade             = trim($dados["cidade"]);
                $insert->uf                 = trim($dados["uf"]);
                $insert->status             = "A";
                $response                  = $insert->save();
                if ($response) {
                    unset($dados);
                    $dados["msg_success"]   = ["Cadastrado com sucesso"];
                }
            }
        } 

        $dados["id_cliente"]    = $id;
        $dados["title"]         = "Novo Endereço";
        $dados["active"]        = "enderecos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();

        $this->load->view('layout/site/header', $dados);
        $this->load->view('layout/site/menu', $dados);
        $this->load->view('layout/site/menu_cliente', $dados);
        $this->load->view('site/clientes/addendereco', $dados);
        $this->load->view('layout/site/footer');
    }

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["cad_nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["cad_email"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        } else {
            if (!validaEmail($dados["cad_email"])) {
                $msg_erro['msg'][] = "O campo E-MAIL é invalido";
            }
        }
        if (strlen($dados["cad_telefone"]) == 0) {
            $msg_erro['msg'][] = "O campo TELEFONE é obrigatório";
        }
        if (strlen($dados["cad_senha"]) == 0) {
            $msg_erro['msg'][] = "O campo SENHA é obrigatório";
        }
        return $msg_erro;
    }

    public function validaEdit($dados)
    {

        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["email"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        } else {
            if (!validaEmail($dados["email"])) {
                $msg_erro['msg'][] = "O campo E-MAIL é invalido";
            }
        }
        if (strlen($dados["telefone"]) == 0) {
            $msg_erro['msg'][] = "O campo TELEFONE é obrigatório";
        }
        if (strlen($dados["senha_atual"]) > 0) {
            $response = Cliente::where('id', "=", $dados["id"])->first();

            if (!empty($response)) {
                $response = $response->toArray();
                if ($response["senha"] == md5($dados["senha_atual"])) {
                    if (strlen($dados["nova_senha"]) == 0) {
                        $msg_erro['msg'][] = "O campo NOVA SENHA é obrigatório";
                    }
                } else {
                    $msg_erro['msg'][] = "O campo SENHA ATUAL inválida";
                }
            }

        }
        
        return $msg_erro;
    }

    public function validaEndereco($dados)
    {

        $msg_erro = [];
        if (strlen($dados["titulo"]) == 0) {
            $msg_erro['msg'][] = "O campo TITULO é obrigatório";
        }
        if (strlen($dados["cep"]) == 0) {
            $msg_erro['msg'][] = "O campo CEP é obrigatório";
        } 

        if (strlen($dados["endereco"]) == 0) {
            $msg_erro['msg'][] = "O campo ENDEREÇO é obrigatório";
        }
         if (strlen($dados["numero"]) == 0) {
            $msg_erro['msg'][] = "O campo NÚMERO é obrigatório";
        }
         if (strlen($dados["bairro"]) == 0) {
            $msg_erro['msg'][] = "O campo BAIRRO é obrigatório";
        }
         if (strlen($dados["cidade"]) == 0) {
            $msg_erro['msg'][] = "O campo CIDADE é obrigatório";
        }
         if (strlen($dados["uf"]) == 0) {
            $msg_erro['msg'][] = "O campo UF é obrigatório";
        }
        
        return $msg_erro;
    }


}
