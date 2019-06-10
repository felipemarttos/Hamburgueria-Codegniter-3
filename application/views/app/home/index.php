<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3>
            	<span class="titulo-pagina"><?php echo $title;?></span>
            	<?php if ($expedientes["aberto"] == "S") {?>
	                <button type="button" data-status="N" class="btn btn-danger  btn-abre-fecha-loja pull-right">
	                	<span class="fa fa-close"></span> Fechar Loja
	                </button>    
            	<?php } else {?>
	                <button type="button" data-status="S" class="btn btn-success btn-abre-fecha-loja pull-right">
	                	<span class="fa fa-check"></span> Abrir Loja
	                </button>    
            	<?php }?>
            </h3>
        </div>
    </div>
	<h3 class="tac">Pedidos realizados hoje <?php echo date("d/m/Y");?></h3><hr>
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8">
		
			<?php 
				if (isset($dados_pedidos) && count($dados_pedidos) > 0) {
					foreach ($dados_pedidos as $key => $rows) {
			?>
			<div class="well">
				<div class="row">
					<div class="col-xs-2 col-sm-2 col-md-2">
						<p><b>Nº Pedido</b></p>
						<h3>#<?php echo $rows["id"];?></h3>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<p><b>Data Pedido</b></p>
						<?php echo geraDataTimeNormal($rows["data"]);?>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2">
						<p><b>Total</b></p>
						<?php echo geraValorReais($rows["total_pedido"]);?>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<p><b>Status do Pedido</b></p>
						<span class="btn btn-xs btn-<?php echo $rows["cor_status"];?>">
			            <?php echo $rows["nome_status"];?>
			            </span>
						
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2">
						<a  target="_blank" href="<?php echo base_url('app/pedidos/print/'.$rows["id"]);?>" class="btn btn-xs btn-default btn-block"><i class="fa fa-print"></i> Imprimir</a>
						<button type="button" data-posicao="<?php echo $rows["id"];?>" class="btn btn-xs btn-warning btn-ver-detalhe-pedido btn-block"><i class="fa fa-search"></i> Ver detalhes</button>
					</div>
				</div><hr>
				<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4">
						<select name="id_status_pedido" class="form-control select2" id="id_status_pedido">
							<option value="">Status do Pedido...</option>
							<?php foreach ($status_pedidos as $ke => $rowe) {?>
								<option value="<?php echo $rowe["id"];?>"><?php echo $rowe["nome"];?></option>
							<?php }?>
						</select>

					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<button type="button" data-pedido="<?php echo $rows["id"];?>" class="btn btn-primary btn-altera-status-pedido btn-block"><i class="fa fa-refresh"></i> Alterar Status do Pedido</button>
					</div>
				</div>
				<br>
				<div class="detalhes_pedido_<?php echo $rows["id"];?>" style="display: none;">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<p><b>Dados do Cliente</b></p>
							
							<?php echo $rows["dados_pedidos_cliente"]["nome"];?><br> 
							<?php echo $rows["dados_pedidos_cliente"]["email"];?> - 
							<?php echo $rows["dados_pedidos_cliente"]["telefone"];?>
							
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<p><b>Dados da entrega</b></p>
							
							<?php echo $rows["dados_pedidos_entrega"]["endereco"];?>, Nº 
							<?php echo $rows["dados_pedidos_entrega"]["numero"];?> - 
							<?php echo $rows["dados_pedidos_entrega"]["complemento"];?> - 
							<?php echo $rows["dados_pedidos_entrega"]["bairro"];?> - 
							<?php echo $rows["dados_pedidos_entrega"]["cidade"];?>/
							<?php echo $rows["dados_pedidos_entrega"]["uf"];?>
							<p><em>Ponto de Referência: <?php echo $rows["dados_pedidos_entrega"]["ponto_referencia"];?></em></p>
							
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<p><b>Forma de entrega</b></p>
							<?php 
								if ($rows["retirar_na_loja"] == "S") {
									echo "Retirar na Loja";
								} else {
									echo "Entrega a domicílio";
								}
							?>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<p><b>Forma de Pagamento</b></p>
							<?php 
								if (strlen($rows["imagem_forma"]) > 0 ) {
									$imagem_forma = $rows["imagem_forma"];
								} else {
									$imagem_forma = "sem_foto.png";
								}
							?>
							<img height="20" src="<?php echo base_url('asset/img/formas/'.$imagem_forma);?>" alt="<?php echo $rows["nome_forma"];?>"> <?php echo $rows["nome_forma"];?>
						</div>
					</div><br />
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<p><b>Itens do pedido</b></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<table class="table table-striped">
								<thead>
									<tr class="titulo_th">
										<th>Produto</th>
										<th>Qtde.</th>
										<th>Valor Unit.</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if (isset($rows["dados_pedidos_itens"]) && count($rows["dados_pedidos_itens"])) {
											foreach ($rows["dados_pedidos_itens"] as $k => $linha) {
									?>
									<tr>
										<td>
											<?php echo $linha["nome_produto"];?>
											<br>
											<em>Observação: <?php echo $linha["obs"];?></em>
										</td>
										<td><?php echo $linha["quantidade"];?></td>
										<td><?php echo geraValorReais($linha["valor_unitario"]);?></td>
										<td><?php echo geraValorReais($linha["quantidade"]*$linha["valor_unitario"]);?></td>
									</tr> 
									<?php }}?>
									<tr>
										<td colspan="3" class="tar">Subtotal</td>
										<td><?php echo geraValorReais($rows["total_pedido_itens"]);?></td>
									</tr>
									<tr>
										<td colspan="3" class="tar">Taxa de entrega</td>
										<td><?php echo geraValorReais($rows["taxa_entrega"]);?></td>
									</tr>
									<tr>
										<td colspan="3" class="tar">Total Final do Pedido</td>
										<td><?php echo geraValorReais($rows["total_pedido"]);?></td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
				} 
				} else {
					echo "<div class='alert alert-warning tac'>Nenhum pedido realizado</div>";
				} 
			?>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4">
 			<div class="list-group">
			<?php 

				if (isset($dados_pedidos) && count($dados_pedidos) > 0) {
					foreach ($dados_pedidos as $key => $rows) {
						$contador_pedido[$rows["codigo_status"]]["total"][] = 1;
						$contador_pedido[$rows["codigo_status"]]["cor_status"] = $rows["cor_status"];
						$contador_pedido[$rows["codigo_status"]]["nome_status"] = $rows["nome_status"];
					}
					

			?>
				<div class="list-group-item active">RESUMO DE PEDIDOS</div>
				<?php foreach ($contador_pedido as $codigo_status => $rows) {?>
				<div class="list-group-item list-group-item-<?php echo $rows["cor_status"];?>">
					<div class="row">
						<div class="col-xs-9 col-sm-9 col-md-9">
							<h4 class="txt-formas"><?php echo $rows["nome_status"];?></h4>
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3">
							<h3><?php echo count($rows["total"]);?></h3>
						</div>
					</div>
				</div>
			<?php }} ?>
			</div>
    	</div>
    </div>
 </div>
