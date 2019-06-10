 <div class="row">
	 <div class="col-xs-12 col-sm-12 col-md-7 box-branco box-branco-int">
		<?php foreach ($produtos as $key => $rows) {?>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  			<div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingOne"  data-toggle="collapse" data-parent="#accordion" href="#ct-<?php echo $rows["id"];?>" aria-expanded="<?php echo ($rows["ordem"] == 1) ? "true" : "false";?>" aria-controls="ct-<?php echo $rows["id"];?>">
			      	<h4 class="panel-title txt-categorias">
				        <b><?php echo $rows["nome"];?></b>
			      	</h4>
			    </div>
		    	<div id="ct-<?php echo $rows["id"];?>" class="panel-collapse collapse <?php echo ($rows["ordem"] == 1) ? "in" :"";?>" role="tabpanel" aria-labelledby="headingOne">
			      	<div class="panel-body">
					<?php
						if (isset($rows["produtos"]) && count($rows["produtos"]) > 0) {
							foreach ($rows["produtos"] as $k => $row) {
								if (strlen($row["imagem"]) > 0) {
	                                $imagem = $row["imagem"];
	                            } else {
	                                $imagem = "sem_foto.png";
	                            }
								if ($row["preco_promocional"] > 0) {
	                                $preco = $row["preco_promocional"];
	                            } else {
	                                $preco = $row["preco"];
	                            }
								$botao_pedir = "";
	                            if ($expedientes["aberto"] == "S" && (isset($_SESSION["cliente"]) && $_SESSION["cliente"]["logged"] == true)) {
									$botao_pedir = '
											<div class="col-xs-3 col-sm-3 col-md-3">
												<a data-toggle="modal" href="'.base_url('home/modal_add_carrinho/'.$row["id"]).'" data-target="#modal_add_carrinho" type="button" data-id="'.$row["id"].'" class="btn btn-success  btn-block">Pedir</a>
												<h3 class="txt-preco">'.geraValorReais($preco).'</h3>
											</div>';
								} else {
									$botao_pedir = "<div class='col-xs-3 col-sm-3 col-md-3'><div class='alert alert-danger'>Efetue o login para realizar seu pedido.</div></div>";
								}
								echo '
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="row">
											<div class="col-xs-3 col-sm-3 col-md-3">
												<img class="img-responsive" src="'.base_url('asset/img/produtos/'.$imagem).'" alt="'.$row["nome"].'">
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6">
												<h4><b>'.$row["nome"].'</b></h4>
												<p class="txt-descricao">'.$row["descricao"].'</p>
											</div>
											'.$botao_pedir.'
										</div>
									</div>
									
								</div>
								<hr>
									';
							}
						}
					?>
			      	</div>
				</div>
	  		</div>
		</div>
		<?php }?>
	</div>
	<div class="col-xs-1 col-sm-1 col-md-1"></div>
	<div class="col-xs-4 col-sm-4 col-md-4">
		<?php 
			if (isset($_SESSION["carrinho"]) && count($_SESSION["carrinho"]) > 0  && (isset($_SESSION["cliente"]) && $_SESSION["cliente"]["logged"] == true)) {
                
                echo form_open_multipart('/home/finaliza', 'name="form_finaliza"'); 
                echo '<input type="hidden" name="total_item" value="'.count($_SESSION["carrinho"]["id_produto"]).'" />';
                
		?>
			<?php if ($expedientes["aberto"] == "S") {?>
			<div class="row box-branco" style="padding-bottom: 10px;">
				<div class="col-xs-12 col-sm-12 col-md-12 box-branco">
					<b>Forma de Entrega</b>
					<select name="forma_envio" class="form-control select2" id="forma_envio">
						<option value="">Escolha...</option>
						<option value="retirar">Retirar na loja</option>
						<?php foreach ($meus_enderecos as $ke => $rowe) {?>
							<option value="<?php echo $rowe["id"];?>">
								Entregar em: <?php echo $rowe["titulo"];?>
							</option>
						<?php }?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 box-branco">
					<b>Forma de Pagamento</b>
					<select name="id_forma_pagamento" class="form-control select2" id="id_forma_pagamento">
						<option value="">Escolha...</option>
						<?php foreach ($formas_pagamentos as $ke => $rowe) {?>
							<option value="<?php echo $rowe["id"];?>"><?php echo $rowe["nome"];?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<?php }?>
			<div class="row box-laranja">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i class="fa fa-shopping-cart icone-carrinho"></i>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<p class="txt-carrinho">Meu Carrinho (<?php echo count($_SESSION["carrinho"]["id_produto"]);?>)</p>
				</div>
			</div>
			<div class="row box-branco box-carrinho">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<?php 
					$subtotal = [];
					for ($i=0; $i < count($_SESSION["carrinho"]["id_produto"]); $i++) {
					 	$subtotal[] = ($_SESSION["carrinho"]["qtde_item"][$i]*$_SESSION["carrinho"]["preco_item"][$i]);

					?>
						<div class="row border-bottom">
							<div class="col-xs-8 col-sm-8 col-md-8">
								<p class="txt-carrinho-nome"><?php echo $_SESSION["carrinho"]["nome_item"][$i];?></p>
								<p class="txt-carrinho-obs">Obs: <?php echo $_SESSION["carrinho"]["obs_item"][$i];?></p>
							</div>
							<div class="col-xs-2 col-sm-2 col-md-2">
								<p class="txt-carrinho-qtde"><?php echo $_SESSION["carrinho"]["qtde_item"][$i];?>x</p>
								<p class="txt-carrinho-preco"><?php echo geraValorReaisSem($_SESSION["carrinho"]["preco_item"][$i]);?></p>
							</div>
							<div class="col-xs-2 col-sm-2 col-md-2">
								<button type="button" data-posicao="<?php echo $i;?>" class="btn btn-remove-item-carrinho btn-danger"><i class="fa fa-remove"></i></button>
							</div>
						</div>
					<?php }?>
					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8">
							<p class="txt-carrinho-totais tar">Subtotal:</p>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
							<p class="txt-carrinho-totais tal"><?php echo geraValorReais(array_sum($subtotal));?></p>
						</div>
					</div>
					<hr>
					<?php if (isset($_SESSION["carrinho"]["id_produto"]) && count($_SESSION["carrinho"]["id_produto"]) > 0) {?>
					<div class="row">
						<div class="col-xs-2 col-sm-2 col-md-2"></div>
						<div class="col-xs-8 col-sm-8 col-md-8">
							<button class="btn btn-primary btn-fecha-pedido btn-block">Finalizar Pedido</button>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</form>
		<?php } else {?>
		<div class="row box-laranja">
			<div class="col-xs-2 col-sm-2 col-md-2">
				<i class="fa fa-shopping-cart icone-carrinho"></i>
			</div>
			<div class="col-xs-10 col-sm-10 col-md-10">
				<p class="txt-carrinho">Sua cesta ainda está vazia</p>
			</div>
		</div>
		<?php }?>

	</div>
</div>

 <div class="modal fade" data-backdrop="static" tabindex="-1" id="modal_add_carrinho" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
  </div>
  </div>
</div>