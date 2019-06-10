        <h4><?php echo $title;?></h4>
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
            echo form_open('clientes/edit', ' name="form_cad"');
            echo '<input type="hidden" name="id" value="'.$dados_cliente["id"].'" />';
        ?>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-lg" value="<?php echo  (isset($dados_cliente["nome"]) && strlen($dados_cliente["nome"]) > 0) ? $dados_cliente["nome"] : "";?>" name="nome" id="nome" placeholder="Nome">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-lg" value="<?php echo  (isset($dados_cliente["email"]) && strlen($dados_cliente["email"]) > 0) ? $dados_cliente["email"] : "";?>" name="email" id="email" placeholder="E-mail">
                </div>
            </div><BR>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <input type="text" class="form-control input-lg telefone" value="<?php echo  (isset($dados_cliente["telefone"]) && strlen($dados_cliente["telefone"]) > 0) ? $dados_cliente["telefone"] : "";?>" name="telefone" id="telefone" placeholder="Telefone">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <input type="password" class="form-control input-lg" value="<?php echo  (isset($senha_atual) && strlen($senha_atual) > 0) ? $senha_atual : "";?>" name="senha_atual" id="senha_atual" placeholder="Senha Atual">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <input type="password" class="form-control input-lg" value="<?php echo  (isset($nova_senha) && strlen($nova_senha) > 0) ? $nova_senha : "";?>" name="nova_senha" id="nova_senha" placeholder="Senha Nova">
                </div>
            </div><BR>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4"></div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <button type="submit" class="btn btn-block btn-success btn-lg">ATUALIZAR MEU DADOS</button>
                </div>
            </div>
        </form>
    </div>
</div>