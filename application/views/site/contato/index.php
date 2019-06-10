 <div class="row">
	 <div class="col-xs-12 col-sm-12 col-md-12 box-branco" style="padding-bottom: 40px;">
		<h4>Sobre a empresa</h4>
		<p><?php echo $configuracoes["nome_site"];?></p>
		<p>CNPJ: <?php echo $configuracoes["cnpj"];?></p>
		<p>Contato: <?php echo $configuracoes["telefone"];?> - Whatsapp: <?php echo $configuracoes["whatsapp"];?></p>
		<p>E-mail: <?php echo $configuracoes["email"];?></p>
		<p>Endereço: <?php echo $configuracoes["endereco"];?></p><br>
		
		<h4>Siga-nos</h4>
		<ul class="redes-sociais">
			<?php if (strlen($configuracoes["instagram"]) > 0) {?>
				<li><a href="<?php echo $configuracoes["instagram"];?>" class="ico-instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
			<?php }?>
			<?php if (strlen($configuracoes["facebook"]) > 0) {?>
				<li><a href="<?php echo $configuracoes["facebook"];?>" class="ico-facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
			<?php }?>
			<?php if (strlen($configuracoes["youtube"]) > 0) {?>
				<li><a href="<?php echo $configuracoes["youtube"];?>" class="ico-youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
			<?php }?>
		</ul><br>

        <?php echo form_open_multipart('/contato/index');?>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3"></div>
                <div class="col-xs-6 col-sm-6 col-md-6">
            		<h4>Preencha o Formulário abaixo</h4>
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
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Nome*:</label>
                            <input type="text" name="nome" value="<?php echo (isset($nome) && strlen($nome) > 0) ? $nome : "";?>" class="form-control" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-8">
                            <label>E-mail*:</label>
                            <input type="text" name="email" value="<?php echo (isset($email) && strlen($email) > 0) ? $email : "";?>" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label>Telefone:</label>
                            <input type="text" name="telefone" value="<?php echo (isset($telefone) && strlen($telefone) > 0) ? $telefone : "";?>" class="form-control telefone" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Assunto*:</label>
                            <input type="text" name="assunto" value="<?php echo (isset($assunto) && strlen($assunto) > 0) ? $assunto : "";?>" class="form-control" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Mensagem*:</label>
                            <textarea name="texto" class="form-control"><?php echo (isset($texto)) ?  $texto : "";?></textarea>
                        </div>
                    </div>
                    <br /><br />
                    <div class="row">
                        <div class="col-sm-12" align="center">
                            <input type="submit" class="btn btn-success" value="Enviar Mensagem" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>
