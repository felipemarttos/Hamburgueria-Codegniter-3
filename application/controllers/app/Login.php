<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    /*
    ** METODO RESPONSAVEL POR EFETUAR LOGIN
    **
    */
    public function index()
    {
         $this->load->model('usuario');

        $dados["programa"] = "login";
        $dados["title"] = "Login - Painel de Controle";
        if ($this->input->post()) {

            $dados = $this->input->post();


            $this->form_validation->set_rules('username', 'E-mail', 'required');
            $this->form_validation->set_rules('password', 'Senha', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger error">', '</div>');

            if ($this->form_validation->run() == FALSE) {
                $dados["programa"] = "login";
                $dados["title"] = "Login - Painel de Controle";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('app/login/index', $dados);

            } else {

                $usuario = Usuario::where([
                                        ["status", "=", "A"],
                                        ["email",  "=", $this->input->post('username')],
                                        ["senha",  "=", md5(trim($this->input->post('password')))],
                                    ])->first();

                if (!empty($usuario)) {
                    
                    $usuario = $usuario->toArray();
                  
                    $this->nativesession->set('username',  $usuario["nome"]);
                    $this->nativesession->set('id', $usuario["id"]);
                    $this->nativesession->set('nome', $usuario["nome"]);
                    $this->nativesession->set('email', $usuario["email"]);
                    $this->nativesession->set('logged',  true);
                    redirect('/app/home/index');
                } else {
                    $this->nativesession->set('error', 'Usuário não encontrado.');
                    redirect('/app/login/index');
                }

            }
        } else {
            $dados["username"] = '';
            $dados["password"] = '';
            $this->load->view('layout/app/header', $dados);
            $this->load->view('app/login/index', $dados);
        }



    }
    /*
    ** METODO RESPONSAVEL POR DESLOGAR 
    **
    */
    public function logout() {
        session_destroy();
        redirect('/app/login/index');
    }


    
}
