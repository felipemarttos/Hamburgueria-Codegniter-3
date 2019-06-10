 <div class="row">
	 <div class="col-xs-12 col-sm-12 col-md-12 box-branco" style="padding-bottom: 40px;">
		<h4><?php echo $title;?></h4>

		<?php if (isset($sobre) && !empty($sobre)) {?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
	 		
				<h4 class="txt-formas"><?php echo $sobre["conteudo"];?></h4>
				
			</div>
		</div>
		<?php } else {?>
			<div class="alert alert-warning">Nenhuma conteudo cadastrado.</div>
		<?php }?>
	</div>
</div>
