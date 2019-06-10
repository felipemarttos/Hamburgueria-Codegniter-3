 <div class="row">
	 <div class="col-xs-12 col-sm-12 col-md-12 box-branco" style="padding-bottom: 40px;">
		<h4><?php echo $title;?></h4>

		<?php if (isset($termos) && !empty($termos)) {?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
	 		
				<h4 class="txt-formas"><?php echo $termos["conteudo"];?></h4>
				
			</div>
		</div>
		<?php } else {?>
			<div class="alert alert-warning">Nenhuma conteudo cadastrado.</div>
		<?php }?>
	</div>
</div>
