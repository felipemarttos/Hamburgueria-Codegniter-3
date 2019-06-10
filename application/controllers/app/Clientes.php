<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
         $this->load->model('cliente');
         $this->load->model('clienteEndereco');
    }
    /*
    ** METODO RESPONSAVEL PELA LISTAGEM DE CLIENTES
    **
    */
    public function index()
    {
        $dados["active"] = "clientes";
        $dados["title"]  = "Listagem de Clientes";
        if ($this->input->post()) {
            $dadosBusca = $this->input->post();
            if ($dadosBusca["tipo"] == "N") {
                $condBusca[] = ["nome", "LIKE", "%".$dadosBusca["campo_filtro"]."%"];
            }
            if ($dadosBusca["tipo"] == "T") {

                $condBusca[] = ["telefone", "=", $dadosBusca["campo_filtro"]];
            }
            $condBusca[] = ["status", "!=", "E"];

            $dados["list"]   = Cliente::where($condBusca)->get()->toArray();
        } else {
            $dados["list"]   = Cliente::where("status", "!=", "E")->get()->toArray();
        }
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/index', $dados);
        $this->load->view('layout/app/footer');
    }
    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE CADASTRO DE CLINETES
    **
    */

    public function add()
    {
        $dados["active"] = "clientes";
        $dados["title"]  = "Novo Cliente";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE EDIÇÃO DE CLIENTES
    **
    */
    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/clientes/index"));
        }
        $dados           = Cliente::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Cliente";
        $dados['id']     = $id;
        $dados['active'] = 'clientes';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE EDIÇÃO DOS CLIENTES
    **
    */
    public function update() {

        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = [];  

        if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $validaCamposVazios = $this->valida($dadosSave, false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro = $validaCamposVazios["msg"];
            } else {

                $validaDuplicado = Cliente::where([["email", "=", $dadosSave["email"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {

                    $msg_erro = ["Já existe um Cliente cadastrado com esse email"];

                } else {
                    $update           = Cliente::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->email    = $dadosSave["email"];
                    $update->telefone = $dadosSave["telefone"];
                    $update->status   = $dadosSave["status"];
                    $response         = $update->save();
                    if ($response) {
                        $msg_success   = ["Cliente atualizado com sucesso"];
                    }
                }
            }

            $dados                  = Cliente::where("id", "=", $dadosSave["id"])->first()->toArray();
            $dados["active"]        = "clientes";
            $dados["title"]         = "Editar Cliente";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;
            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/clientes/add', $dados);
            $this->load->view('layout/app/footer');
            redireciona(base_url("/app/clientes/index"),1);

        } else {
            redirect('/app/clientes/index');
        }
    }

    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE INSERÇÃO DOS CLIENTES
    **
    */
    public function create()
    {
        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = [];  
       
        if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $dados    = $this->input->post();
            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro  = $validaCamposVazios["msg"];
            } else {
               
                $validaDuplicado        = Cliente::where("email", "=", $dadosSave["email"])->first();
               
                if (!empty($validaDuplicado)) {

                    $msg_erro = ["Já existe um Cliente cadastrado com esse email"];

                } else {
                    $insert             = new Cliente;
                    $insert->nome       = $dadosSave["nome"];
                    $insert->status     = $dadosSave["status"];
                    $insert->telefone   = $dadosSave["telefone"];
                    $insert->email      = $dadosSave["email"];
                    $response           = $insert->save($dadosSave);
                    if ($response) {
                        unset($dados);
                        $msg_success   = ["Cliente cadastrado com sucesso"];
                        
                    }
                }
            }

            $dados["title"]         = "Novo Cliente";
            $dados["active"]        = "clientes";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;
            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/clientes/add', $dados);
            $this->load->view('layout/app/footer');

        } else {
            redirect('/app/clientes/index');
        }
    }

    /*
    ** METODO RESPONSAVEL PELA VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    **
    */

    public function valida($dados, $insert = true)
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
        return $msg_erro;
    }


    /*
    ** METODO RESPONSAVEL POR ATIVAR E INATIVAR CLIENTE
    **
    */
    public function status() {
        $data['active'] = 'clientes';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/clientes/index");
        }
        $retorno = Cliente::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $user           = Cliente::find($id);
        $user->status   = $novoStatus;
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/clientes/index"));
        } else {
            redireciona(base_url("/app/clientes/index"));
        }

    }
    /*
    ** METODO RESPONSAVEL POR REMOVER CLIENTE
    **
    */
    public function delete() {
        $data['active'] = 'clientes';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/clientes/index");
        }
        $user           = Cliente::find($id);
        $user->status   = "E";
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/clientes/index"));
        } else {
            redireciona(base_url("/app/clientes/index"));
        }

    }

    public function print()
    {
        $logged = $this->nativesession->get('logged');
        $id       = $this->nativesession->get('id');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/login/index'));
        }
        $id_pedido = $this->uri->segment(3);

        $dados["title"]         = "Meus Pedidos";
        $dados["active"]        = "pedidos";
        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();
        $dados_pedidos          = Pedido::join('tb_formas_pagamentos', 'tb_formas_pagamentos.id', '=', 'tb_pedidos.id_forma_pagamento')
                                        ->where("tb_pedidos.id", "=", $id_pedido)
                                        ->first([
                                                "tb_pedidos.*", 
                                                "tb_formas_pagamentos.nome AS nome_forma", 
                                                "tb_formas_pagamentos.imagem AS imagem_forma",
                                            ]);

        if (!empty($dados_pedidos)) {
            $rows = $dados_pedidos->toArray();
            $dados_pedidos_itens   = [];
            $dados_pedidos_status  = [];
            $dados_pedidos_entrega = [];
            $responsePedidoItens   = PedidoItem::join('tb_produtos', 'tb_produtos.id', '=', 'tb_pedidos_itens.id_produto')
                                             ->where("tb_pedidos_itens.id_pedido", "=",$rows["id"])
                                             ->get(["tb_pedidos_itens.*","tb_produtos.nome AS nome_produto"]);

            if (!empty($responsePedidoItens)) {
                $dados_pedidos_itens = $responsePedidoItens->toArray();
            }

                $responsePedidoStatus = PedidoStatus::join('tb_status_pedidos', 'tb_status_pedidos.id', '=', 'tb_pedidos_status.id_status_pedido')
                                                 ->where("tb_pedidos_status.id_pedido", "=",$rows["id"])
                                                 ->orderBy("tb_pedidos_status.data", "DESC")
                                                 ->get(["tb_pedidos_status.*","tb_status_pedidos.nome AS nome_status","tb_status_pedidos.codigo AS codigo_status"]);
                if (!empty($responsePedidoStatus)) {
                    $dados_pedidos_status = $responsePedidoStatus->toArray();
                }

                $responseClienteEndereco = ClienteEndereco::where("id", "=",$rows["id_cliente_endereco"])
                                                 ->first();

                if (!empty($responseClienteEndereco)) {
                    $dados_pedidos_entrega = $responseClienteEndereco->toArray();
                }

                $dados_pedidos["dados_pedidos_entrega"]  = $dados_pedidos_entrega;
                $dados_pedidos["dados_pedidos_itens"]    = $dados_pedidos_itens;
                $dados_pedidos["dados_pedidos_status"]   = $dados_pedidos_status;
            $dados["dados_pedidos"]   = $dados_pedidos;
        } else {
            $dados["dados_pedidos"]   = [];
        }

        $this->load->view('layout/site/header_print', $dados);
        $this->load->view('site/clientes/index', $dados);
    }
}
