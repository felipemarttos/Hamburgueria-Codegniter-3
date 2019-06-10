<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }

    public function index()
    {
        $dados["active"]     = "produtos";
        $dados["title"]      = "Listagem de Produtos";
       
        $dados["categorias"] = Categoria::where("status", "!=", "E")->get()->toArray();

        if ($this->input->post()) {

            $xdadosPost            = $this->input->post();
            $dados["id_categoria"] = $xdadosPost["id_categoria"];
            $dados["campo_filtro"] = $xdadosPost["campo_filtro"];
            if ($xdadosPost["id_categoria"]) {
                 $cond[] = ["tb_categorias.id", "=", $xdadosPost["id_categoria"]];
            }
           
            if (strlen($xdadosPost["campo_filtro"]) > 0) {
                 $cond[] = ["tb_produtos.nome", "like", '%' . $xdadosPost["campo_filtro"] . '%'];
            }
            $cond[] = ["tb_produtos.status", "!=", "R"];
            $dadosProdutos = Produto::join('tb_categorias', 'tb_produtos.id_categoria', '=', 'tb_categorias.id')
                                    ->where($cond)
                                    ->orderBy("tb_produtos.nome", "ASC")
                                    ->get([
                                        'tb_produtos.*',
                                        'tb_categorias.nome AS categoria_nome'
                                    ])
                                    ->toArray();

        } else {
            $dadosProdutos = Produto::join('tb_categorias', 'tb_produtos.id_categoria', '=', 'tb_categorias.id')
                                    ->where("tb_produtos.status", "!=", "E")
                                    ->orderBy("tb_produtos.nome", "ASC")
                                    ->get([
                                        'tb_produtos.*',
                                        'tb_categorias.nome AS categoria_nome'
                                    ])
                                    ->toArray();
        }
        if (!empty($dadosProdutos)) {
            $dados["list"] = $dadosProdutos;
        } else {
            $dados["list"] = [];
        }

        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/produtos/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"] = "produtos";
        $dados["title"]  = "Novo Produto";
        $dados["listcategorias"] = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/produtos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/produtos/index"));
        }
        $dados           = Produto::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Produto";
        $dados['id']     = $id;
        $dados['active'] = 'produtos';
        $dados["listcategorias"] = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();

        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/produtos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function update() {
        $dados["title"]  = "Editar Produto";

         if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post(), false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados                      = $this->input->post();
                $dados["msg_erro"]          = $validaCamposVazios["msg"];
                $dados["title"]             = "Editar Produto";
                $dados["active"]            = "produtos";
                $dados["listcategorias"]    = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/produtos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave                  = $this->input->post();
                $update                     = Produto::find($dadosSave["id"]);
                $update->id_categoria       = $dadosSave["id_categoria"];
                $update->nome               = $dadosSave["nome"];
                $update->preco              = geraValorBD($dadosSave["preco"]);
                $update->preco_promocional  = geraValorBD($dadosSave["preco_promocional"]);
                $update->status             = $dadosSave["status"];
                $update->descricao          = $dadosSave["descricao"];
                if (isset($_FILES["imagem"]["name"]) && strlen($_FILES["imagem"]["name"]) > 0) {
                    $update->imagem = $this->uploadFoto();
                }

                $response                       = $update->save($dadosSave);
                if ($response) {
                    $dados["msg_success"]       = ["Produto atualizado com sucesso"];
                    $dados["active"]            = "produtos";
                    $dados["title"]             = "Editar Produto";
                    $dados["listcategorias"]    = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/produtos/add', $dados);
                    $this->load->view('layout/app/footer');
                     redireciona(base_url("/app/produtos/index"),1);
                }
            }
        } else {
            redirect('/app/produtos/index');
        }
    }

    public function create()
    {
       
        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados                      = $this->input->post();
                $dados["active"]            = "produtos";
                $dados["title"]             = "Novo Produto";
                $dados["msg_erro"]          = $validaCamposVazios["msg"];
                $dados["listcategorias"]    = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/produtos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave                  = $this->input->post();
                $insert                     = new Produto;
                $insert->id_categoria       = $dadosSave["id_categoria"];
                $insert->nome               = $dadosSave["nome"];
                $insert->preco              = geraValorBD($dadosSave["preco"]);
                $insert->preco_promocional  = geraValorBD($dadosSave["preco_promocional"]);
                $insert->status             = $dadosSave["status"];
                $insert->descricao          = $dadosSave["descricao"];
                if (isset($_FILES["imagem"]["name"]) && strlen($_FILES["imagem"]["name"]) > 0) {
                    $insert->imagem = $this->uploadFoto();
                }
                $response         = $insert->save($dadosSave);
                if ($response) {
                    $dados["msg_success"]       = ["Produto cadastrado com sucesso"];
                    $dados["title"]             = "Novo Produto";
                    $dados["active"]            = "produtos";
                    $dados["listcategorias"]    = Categoria::where("status", "=", "A")->orderBy("nome", "ASC")->get()->toArray();
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/produtos/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/produtos/index"),1);
                }
            }
        } else {
            redirect('/app/produtos/index');
        }
    }

    public function valida($dados, $insert = true)
    {
        $msg_erro = [];
        if (strlen($dados["id_categoria"]) == 0) {
            $msg_erro['msg'][] = "O campo CATEGORIA é obrigatório";
        }
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["preco"]) == 0) {
            $msg_erro['msg'][] = "O campo PREÇO é obrigatório";
        }
        return $msg_erro;
    }

    public function status() {
        $data['active'] = 'produtos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/produtos/index");
        }
        $retorno = Produto::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $update           = Produto::find($id);
        $update->status   = $novoStatus;
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/produtos/index"));
        } else {
            redireciona(base_url("/app/produtos/index"));
        }

    }

    public function delete() {
        $data['active'] = 'produtos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/produtos/index");
        }
        $update           = Produto::find($id);
        $update->status   = "E";
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/produtos/index"));
        } else {
            redireciona(base_url("/app/produtos/index"));
        }

    }

    public function uploadFoto() {
        $pasta = 'asset/img/produtos/';
        if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name   = $_FILES["imagem"]["tmp_name"];
            $nome_foto  = date('dmy') . '_produto_' . $_FILES["imagem"]["name"];
            $uploadfile = $pasta . basename($nome_foto);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                return $nome_foto;
            }
        }
    }
}
