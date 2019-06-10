<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Autentica extends Eloquent{
    protected $table = 'tb_usuarios';

}

  
/*
    public function validateBarber() {
       
        $query = $this->db->query("SELECT * FROM tb_usuarios WHERE status='S' AND login = '".$this->input->post('username')."' AND  senha='".$this->input->post('password')."'");
        if (!empty($query->row())) { 
            return $query->row();
        } else {
            return false;
        }
    }

    public function loggedBarber() {
        $logged = $this->session->userdata('loggado');

        if (!isset($logged) || $logged != true) {
            redirect(base_url('barber/login/index'));
        }
    }

    public function logged() {
        $logged = $this->session->userdata('logged');

        if (!isset($logged) || $logged != true) {
            redirect(base_url('login/index'));
        }
    }

}*/