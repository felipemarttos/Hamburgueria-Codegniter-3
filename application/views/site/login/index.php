<div class="container">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="box-login box-branco">
                
                <h4>Quero me cadastrar</h4>
                    <?php if (isset($msg_erro) && count($msg_erro) > 0): ?>
                        <div class="alert alert-danger" id="alertas">
                            <?php echo implode("<br>", $msg_erro); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($msg_success) && count($msg_success) > 0): ?>
                        <div class="alert alert-success" id="alertas">
                            <?php echo implode("<br>", $msg_success); ?>
                        </div>
                    <?php endif; ?>
                    <?php 
                        echo form_open('clientes/add', ' name="form_cad"');
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="text" class="form-control input-lg" value="<?php echo  (isset($cad_nome) && strlen($cad_nome) > 0) ? $cad_nome : "";?>" name="cad_nome" id="cad_nome" placeholder="Nome">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="text" class="form-control input-lg" value="<?php echo  (isset($cad_email) && strlen($cad_email) > 0) ? $cad_email : "";?>" name="cad_email" id="cad_email" placeholder="E-mail">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-lg telefone" value="<?php echo  (isset($cad_telefone) && strlen($cad_telefone) > 0) ? $cad_telefone : "";?>" name="cad_telefone" id="cad_telefone" placeholder="Telefone">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <input type="password" class="form-control input-lg" value="<?php echo  (isset($cad_senha) && strlen($cad_senha) > 0) ? $cad_senha : "";?>" name="cad_senha" id="cad_senha" placeholder="Senha">
                        </div>
                    </div><BR>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-block btn-success btn-lg">CADASTRAR</button>
                        </div>
                    </div>
                </form>
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
                        echo form_open('login/index', ' name="form_login"');
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
                            <button type="button" onclick="$('form[name=form_login]').submit()" class="btn btn-block btn-danger btn-lg">ACESSAR</button>
                        </div>
                    </div><BR>
                    
                </form>
            </div>
        </div>
    </div>
</div>
