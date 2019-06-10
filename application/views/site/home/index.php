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
											<div class="col-xs-3 col-sm-3 col-md-3">
												<button class="btn btn-success btn-block">Pedir</button>
												<h3 class="txt-preco">'.geraValorReais($preco).'</h3>
											</div>
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
		<?php if ($expedientes["aberto"] == "S") {?>

		<div class="row box-branco">
			<div class="col-xs-2 col-sm-2 col-md-2">
				<input type="radio" name="forma_envio" value="retirar" class="form-control input-entrega">
			</div>
			<div class="col-xs-10 col-sm-10 col-md-10 box-branco">
				<b>Retirar na Loja</b>
				<p><?php echo $configuracoes["endereco"];?></p>
			</div>
		</div>
		<div class="row box-branco">
			<div class="col-xs-2 col-sm-2 col-md-2">
				<input type="radio" name="forma_envio" value="entregar" class="form-control input-entrega">
			</div>
			<div class="col-xs-10 col-sm-10 col-md-10 box-branco">
				<b>Entrega a domicílio</b>
				<p>Taxa de entrega: <?php echo geraValorReais($configuracoes["taxa_entrega"]);?></p><br>
			</div>
		</div>
		<?php }?>
		<div class="row box-laranja">
			<div class="col-xs-2 col-sm-2 col-md-2">
				<i class="fa fa-shopping-cart icone-carrinho"></i>
			</div>
			<div class="col-xs-10 col-sm-10 col-md-10">
				<p class="txt-carrinho">Sua cesta ainda está vazia</p>
			</div>
		</div>

	</div>
</div>

