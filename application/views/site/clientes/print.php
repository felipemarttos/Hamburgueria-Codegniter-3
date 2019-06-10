<div class="container">
	<div class="row">
		<div class="col-xs-2 col-sm-2 col-md-2">
			<img class="img-responsive" src="<?php echo base_url('asset/img/logo.png');?>" alt="logo">
		</div>
		<div class="col-xs-10 col-sm-10 col-md-10 tar">
			
			<h4><?php echo $configuracoes['nome_site'];?></h4>
			CNPJ: <?php echo $configuracoes['nome_site'];?> - E-mail: <?php echo $configuracoes['email'];?><br>
			Telefone: <?php echo $configuracoes['telefone'];?> - Whatsapp: <?php echo $configuracoes['whatsapp'];?><br>
			Endereço: <?php echo $configuracoes['endereco'];?>
			
		</div>
	</div><hr />
	<?php 
        if (!empty($dados_pedidos)) {
            $rows = $dados_pedidos;
    ?>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <p><b>Número do Pedido</b></p>
            <h3 class="text-info">#<?php echo $rows["id"];?></h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <p><b>Data do Pedido</b></p>
            <?php echo geraDataTimeNormal($rows["data"]);?>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <p><b>Total do Pedido</b></p>
            <?php echo geraValorReais($rows["total_pedido"]);?>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <p><b>Status do Pedido</b></p>
            <span class="btn btn-xs btn-<?php echo $rows["cor_status"];?>">
            <?php echo $rows["nome_status"];?>
            </span>
            

        </div>
    </div>
    <hr>
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
    <?php
        } 
    ?>

</div>
 