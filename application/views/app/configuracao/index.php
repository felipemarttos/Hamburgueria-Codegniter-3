<div class="container"  style="margin-top: 20px">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3>
                <span class="titulo-pagina"><?php echo $title;?></span>
            </h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
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
                    echo form_open_multipart('/app/configuracoes/index'); 
                ?>

                <legend>Dados do Site</legend>
                <div class="row">
                    <div class="col-sm-10">
                        <label>Nome do Site*:</label>
                        <input type="text" name="nome_site" value="<?php echo (isset($nome_site) && strlen($nome_site) > 0) ? $nome_site : "";?>" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <label>E-mail de Contato*:</label>
                        <input type="text" name="email" value="<?php echo (isset($email) && strlen($email) > 0) ? $email : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-2">
                        <label>Telefone*:</label>
                        <input type="text" name="telefone" value="<?php echo (isset($telefone) && strlen($telefone) > 0) ? $telefone : "";?>" class="form-control telefone" />
                    </div>
                    <div class="col-sm-3">
                        <label>Google Analytics:</label>
                        <input type="text" name="google_analitcs" value="<?php echo (isset($google_analitcs) && strlen($google_analitcs) > 0) ? $google_analitcs : "";?>" class="form-control" />
                    </div>
                </div><br />
                <legend>Redes Sociais</legend>
                <div class="row">
                    <div class="col-sm-3">
                        <label>Whatsapp:</label>
                        <input type="text" name="whatsapp" value="<?php echo (isset($whatsapp) && strlen($whatsapp) > 0) ? $whatsapp : "";?>" class="form-control telefone" />
                    </div>
                    <div class="col-sm-3">
                        <label>Instagram:</label>
                        <input type="text" name="instagram" value="<?php echo (isset($instagram) && strlen($instagram) > 0) ? $instagram : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-3">
                        <label>Facebook:</label>
                        <input type="text" name="facebook" value="<?php echo (isset($facebook) && strlen($facebook) > 0) ? $facebook : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-3">
                        <label>Youtube:</label>
                        <input type="text" name="youtube" value="<?php echo (isset($youtube) && strlen($youtube) > 0) ? $youtube : "";?>" class="form-control" />
                    </div>
                </div><br />
                <legend>Dados da Empresa</legend>
                <div class="row">
                    <div class="col-sm-8">
                        <label>Nome da Empresa*:</label>
                        <input type="text" name="nome_empresa" value="<?php echo (isset($nome_empresa) && strlen($nome_empresa) > 0) ? $nome_empresa : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                        <label>CNPJ:</label>
                        <input type="text" name="cnpj" value="<?php echo (isset($cnpj) && strlen($cnpj) > 0) ? $cnpj : "";?>" class="form-control cnpj" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Responsável pela Empresa:</label>
                        <input type="text" name="responsavel" value="<?php echo (isset($responsavel) && strlen($responsavel) > 0) ? $responsavel : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                        <label>Expediente:</label>
                        <input type="text" name="expediente" value="<?php echo (isset($expediente) && strlen($expediente) > 0) ? $expediente : "";?>" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <label>Endereço da empresa:</label>
                        <input type="text" name="endereco" value="<?php echo (isset($endereco) && strlen($endereco) > 0) ? $endereco : "";?>" class="form-control" />
                    </div>
                </div><br />
                <legend>Dados do Pedido</legend>
                <div class="row">
                    <div class="col-sm-3">
                        <label>Tempo Entrega:</label>
                        <input type="text" name="tempo_entrega" value="<?php echo (isset($tempo_entrega) && strlen($tempo_entrega) > 0) ? $tempo_entrega : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-2">
                        <label>Taxa de Entrega:</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1">R$</span>
                            <input type="text" name="taxa_entrega" id="taxa_entrega" onkeypress="return(MascaraMoeda(this,'.',',',event))"  value="<?php echo (isset($taxa_entrega) && strlen($taxa_entrega) > 0) ? geraValorReaisSem($taxa_entrega) : "";?>" class="form-control" value="">
                        </div>
                    </div>
                </div>
                
                <br /><br />
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <input type="submit" class="btn btn-success btn-lg" value="Gravar" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
