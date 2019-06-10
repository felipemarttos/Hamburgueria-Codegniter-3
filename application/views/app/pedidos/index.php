<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3 class="border-bottom"><span class="titulo-pagina"><?php echo $title;?></span>
            </h3>
            <h3 class="titulo-filtro">Filtro</h3>
            <?php echo form_open('app/pedidos/index'); ?>
            <div class="row">
                <div class="col-sm-4">
                    <label>Cliente</label>
                    <select name="busca_cliente" id="busca_cliente" class="form-control select2">
                        <option value="" selected="selected">Selecione ...</option>
                        <?php if (count($clientes) > 0) {?>
	                        <?php foreach ($clientes as $key => $row) {?>
	                            <option value="<?php echo $row["id"];?>"><?php echo $row["nome"];?> - <?php echo $row["telefone"];?></option>
	                        <?php }?>
                        <?php }?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Nº Pedido</label>
                    <input type="text" class="form-control input-sm" name="busca_n_pedido">
                </div>
                <div class="col-sm-2">
                    <div class="ajuste-btn-filtro">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?php 
				if (isset($dados_pedidos) && count($dados_pedidos) > 0) {
					foreach ($dados_pedidos as $key => $rows) {
			?>
			<div class="well">
				<div class="row">
					<div class="col-xs-2 col-sm-2 col-md-2">
						<p><b>Número do Pedido</b></p>
						<h3>#<?php echo $rows["id"];?></h3>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<p><b>Data do Pedido</b></p>
						<?php echo geraDataTimeNormal($rows["data"]);?>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<p><b>Total do Pedido</b></p>
						<?php echo geraValorReais($rows["total_pedido"]);?>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2">
						<p><b>Status do Pedido</b></p>
						<span class="btn btn-xs btn-<?php echo $rows["cor_status"];?>">
			            <?php echo $rows["nome_status"];?>
			            </span>
						
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2">
						<a  target="_blank" href="<?php echo base_url('app/pedidos/print/'.$rows["id"]);?>" class="btn btn-xs btn-default btn-block"><i class="fa fa-print"></i> Imprimir pedido</a>
						<button type="button" data-posicao="<?php echo $rows["id"];?>" class="btn btn-xs btn-info btn-ver-detalhe-pedido btn-block"><i class="fa fa-search"></i> Ver detalhes do pedido</button>
					</div>
				</div>
				<hr>
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
					echo "<div class='alert alert-warning'>Nenhum pedido realizado</div>";
				} 
			?>
		</div>
	</div>
</div>
 