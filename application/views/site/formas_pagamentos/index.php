 <div class="row">
	 <div class="col-xs-12 col-sm-12 col-md-12 box-branco" style="padding-bottom: 40px;">
		<h4><?php echo $title;?></h4>

		<?php if (isset($formas) && count($formas) > 0) {?>
		<div class="row">
			<div class="col-xs-1 col-sm-1 col-md-4"></div>
			<div class="col-xs-10 col-sm-10 col-md-4">
	 			<div class="list-group">
				<?php foreach ($formas as $key => $rows) {?>
					<div class="list-group-item">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3">
								<?php 
									if (strlen($rows["imagem"]) > 0 ) {
										$imagem_forma = $rows["imagem"];
									} else {
										$imagem_forma = "sem_foto.png";
									}
								?>
								<img class="img-responsive" src="<?php echo base_url('asset/img/formas/'.$imagem_forma);?>" alt="<?php echo $rows["nome"];?>"> 
							</div>
							<div class="col-xs-9 col-sm-9 col-md-9">
								<h4 class="txt-formas"><?php echo $rows["nome"];?></h4>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<?php } else {?>
			<div class="alert alert-warning">Nenhuma forma de pagamento cadastrada.</div>
		<?php }?>
	</div>
</div>
