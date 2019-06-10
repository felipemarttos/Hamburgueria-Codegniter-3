<div class="container">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="box-login box-branco">
                
                <h4>Quero me cadastrar</h4>
                    <?php 
                        echo validation_errors(); 
                        if ($this->nativesession->get('error') == TRUE) {
                            echo  '<div class="alert alert-danger" id="alertas">'.$this->nativesession->get('error').'  </div>';
                        }
                        echo form_open('',' class="pt-3"');
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="text" class="form-control input-lg" value="<?php echo  (isset($nome) && strlen($nome) > 0) ? $nome : "";?>" name="nome" id="nome" placeholder="Nome">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="email" class="form-control input-lg" value="<?php echo  (isset($email) && strlen($email) > 0) ? $email : "";?>" name="email" id="email" placeholder="E-mail">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-lg telefone" value="<?php echo  (isset($telefone) && strlen($telefone) > 0) ? $telefone : "";?>" name="telefone" id="telefone" placeholder="Telefone">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="password" class="form-control input-lg" value="<?php echo  (isset($password) && strlen($password) > 0) ? $password : "";?>" name="password" id="password" placeholder="Senha">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-block btn-success btn-lg">CADASTRAR</button>
                        </div>
                    </div>
                <?php form_close();?>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 ">
            <div class="box-login2 box-branco">
                
                <h4>Já sou cadastrado</h4>
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
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="password" class="form-control input-lg" value="<?php echo  (isset($password) && strlen($password) > 0) ? $password : "";?>" name="password" id="password" placeholder="Senha">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-block btn-danger btn-lg">ACESSAR</button>
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 tac">
                            <a href="<?php echo base_url('app/login/recuperar');?>" class="link-esqueceu">Esqueceu a senha?</a>
                        </div>
                    </div>
                <?php form_close();?>
            </div>
        </div>
    </div>
</div>
