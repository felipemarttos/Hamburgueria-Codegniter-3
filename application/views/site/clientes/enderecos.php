	<h4><?php echo $title;?> <div class="pull-right"><a href="<?php echo base_url('clientes/addEndereco/');?>" class="btn btn-sm btn-info btn-block"><i class="fa fa-plus"></i> Novo Endereço</a></div></h4>
	<br />
	<?php 
		if (isset($dados_enderecos) && count($dados_enderecos) > 0) {
			foreach ($dados_enderecos as $key => $rows) {
	?>
	<div class="well">
		<div class="row">
			<div class="col-xs-10 col-sm-10 col-md-10">
				<h4><?php echo $rows["titulo"];?></h4>
				<p>
					<?php echo $rows["endereco"];?>, Nº <?php echo $rows["numero"];?> - 
					<?php echo $rows["complemento"];?> - <?php echo $rows["bairro"];?> - CEP: <?php echo $rows["cep"];?> - <?php echo $rows["cidade"];?>/<?php echo $rows["uf"];?><br>
					
					<b>Ponto de Referência:</b> <?php echo $rows["ponto_referencia"];?>
					
				</p>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2">
				<a href="<?php echo base_url('clientes/editEndereco/'.$rows["id"]);?>" class="btn  btn-success btn-block"><i class="fa fa-edit"></i> Editar</a>
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
 