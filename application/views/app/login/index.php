<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4"></div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <div class="box-login">
            <img width="100%" src="<?php echo base_url('asset/img/logo.png');?>" alt="logo">
            
            <h4>Painel de Controle da Hamburgueria</h4>
                <?php 
                    echo validation_errors(); 
                    if ($this->nativesession->get('error') == TRUE) {
                        echo  '<div class="alert alert-danger" id="alertas">'.$this->nativesession->get('error').'  </div>';
                    }
                    echo form_open('',' class="pt-3"');
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="email" class="form-control input-lg" value="<?php echo  (isset($username) && strlen($username) > 0) ? $username : "";?>" name="username" id="username" placeholder="E-mail">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="password" class="form-control input-lg" value="<?php echo  (isset($password) && strlen($password) > 0) ? $password : "";?>" name="password" id="password" placeholder="Senha">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-block btn-danger btn-lg">ACESSAR</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a href="<?php echo base_url('app/login/recuperar');?>" class="link-esqueceu">Esqueceu a senha?</a>
                    </div>
                </div>
            <?php form_close();?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4"></div>


    </div>
</div>
</div>
