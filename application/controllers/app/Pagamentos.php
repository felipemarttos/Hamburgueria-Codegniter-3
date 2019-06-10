<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagamentos extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }
    public function index()
    {
        $dados["active"] = "mkt";
        $dados["title"] = "Pagamentos";
        $dados["list"] = Pagamento::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/pagamentos/index', $dados);
        $this->load->view('layout/app/footer');
    }
 

    public function editar() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/pagamentos/index"));
        }
        $dados          = Pagamento::where('id', "=", $id)->first()->toArray();
        $dadosConfig    = json_decode($dados["config"],1);
                
        if ($dados["codigo"] == "pagseguro") {
            extract($dadosConfig);
            $dados["ps_ambiente"] =  $ps_ambiente;
            $dados["ps_email_pd"] =  $ps_email_pd;
            $dados["ps_token_pd"] =  $ps_token_pd;
            $dados["ps_email_sb"] =  $ps_email_sb;
            $dados["ps_token_sb"] =  $ps_token_sb;
            $dados["ps_qtde_parcelas"] =  $ps_qtde_parcelas;
            $dados["ps_usa_boleto"] =  $ps_usa_boleto;
            $dados["ps_usa_cartao"] =  $ps_usa_cartao;
            
        }


        if ($dados["codigo"] == "mercadopago") {
            extract($dadosConfig);
            $dados["mp_ambiente"] = $mp_ambiente;
            $dados["mp_email"] = $mp_email;
            $dados["mp_token_pd"] = $mp_token_pd;
            $dados["mp_token_sb"] = $mp_token_sb;
            $dados["mp_qtde_parcelas"] = $mp_qtde_parcelas;
            $dados["mp_usa_boleto"] = $mp_usa_boleto;
            $dados["mp_usa_cartao"] = $mp_usa_cartao;
        }

        if ($dados["codigo"] == "gerencianet") {
            extract($dadosConfig);
            $dados["gn_ambiente"] = $gn_ambiente;
            $dados["gn_client_id_sb"] = $gn_client_id_sb;
            $dados["gn_client_secret_sb"] = $gn_client_secret_sb;
            $dados["gn_client_id_pd"] = $gn_client_id_pd;
            $dados["gn_client_secret_pd"] = $gn_client_secret_pd;
        }
        $dados["title"] = "Editar Pagamentos";
        $dados['id'] = $id;
        $dados['active'] = 'mkt';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/pagamentos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function update() {
        $dados["active"] = "mkt";
        $dados["title"] = "Editar Pagamentos";

         if ($this->input->post()) {

                $dadosSave                  = $this->input->post();
                $pagina                     = Pagamento::find($dadosSave["id"]);
                
                if ($dadosSave["codigo"] == "pagseguro") {
                    $dadosJson = [
                                    "ps_ambiente" => $dadosSave["ps_ambiente"], 
                                    "ps_email_pd" => $dadosSave["ps_email_pd"], 
                                    "ps_token_pd" => $dadosSave["ps_token_pd"], 
                                    "ps_email_sb" => $dadosSave["ps_email_sb"], 
                                    "ps_token_sb" => $dadosSave["ps_token_sb"], 
                                    "ps_qtde_parcelas" => $dadosSave["ps_qtde_parcelas"], 
                                    "ps_usa_boleto" => $dadosSave["ps_usa_boleto"], 
                                    "ps_usa_cartao" => $dadosSave["ps_usa_cartao"], 
                                ];
                }

                if ($dadosSave["codigo"] == "mercadopago") {
                    $dadosJson = [
                                    "mp_ambiente" => $dadosSave["mp_ambiente"], 
                                    "mp_email" => $dadosSave["mp_email"], 
                                    "mp_token_pd" => $dadosSave["mp_token_pd"], 
                                    "mp_token_sb" => $dadosSave["mp_token_sb"], 
                                    "mp_qtde_parcelas" => $dadosSave["mp_qtde_parcelas"], 
                                    "mp_usa_boleto" => $dadosSave["mp_usa_boleto"], 
                                    "mp_usa_cartao" => $dadosSave["mp_usa_cartao"], 
                                ];
                }

                if ($dadosSave["codigo"] == "gerencianet") {
                    $dadosJson = [
                                    "gn_ambiente" => $dadosSave["gn_ambiente"], 
                                    "gn_client_id_sb" => $dadosSave["gn_client_id_sb"], 
                                    "gn_client_secret_sb" => $dadosSave["gn_client_secret_sb"], 
                                    "gn_client_id_pd" => $dadosSave["gn_client_id_pd"], 
                                    "gn_client_secret_pd" => $dadosSave["gn_client_secret_pd"], 
                                ];
                }

                $pagina->config = json_encode($dadosJson);
                $pagina->status = $dadosSave["status"];
                $ok             = $pagina->save();
                $atualizaStatus = $this->atualizaStatus($dadosSave["id"], $dadosSave["status"]);
                if ($ok) {
                    $dados["active"] = "mkt";
                    $dados["msg_success"]   = ["Pagamentos atualizado com sucesso"];
                    $dados["title"]         = "Editar Pagamentos";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/pagamentos/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/pagamentos/index"),1);
                }
        } else {
            redirect('/app/pagamentos/index');
        }
    }

    public function atualizaStatus($id, $status) {
        $data['active'] = 'mkt';

        if ($status == "S") {

            $pags = Pagamento::where("id", "!=", $id)->get()->toArray();
            foreach ($pags as $key => $rows) {
               
                $pg = Pagamento::find($rows["id"]);
                $pg->status   = "N";
                $pg->save();
                unset($pg);
            }
        }
    }

    public function status() {
        $data['active'] = 'mkt';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/pagamentos/index");
        }
        $retorno = Pagamento::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "N") {
            $novoStatus = "S";
        } else {
            $novoStatus = "N";
        }
        $user = Pagamento::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/pagamentos/index"));
        } else {
            redireciona(base_url("/app/pagamentos/index"));
        }

    }

}

