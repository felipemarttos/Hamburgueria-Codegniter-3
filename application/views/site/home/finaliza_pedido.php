<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="box-login box-branco">
                <?php if (isset($msg_erro) && count($msg_erro) > 0): ?>
                    <div class="alert alert-danger">
                        <?php echo implode("<br>", $msg_erro); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($msg_success) && count($msg_success) > 0): ?>
                    <div class="alert alert-success tac">
                        <h3><?php echo implode("<br>", $msg_success); ?></h3>
                    </div>
                <?php endif; ?>
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
                        <span class="btn btn-<?php echo $rows["cor_status"];?>">
                        <?php echo $rows["nome_status"];?>
                        </span>
                        

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7">
                        <p><b>Dados da entrega</b></p>
                        
                        <?php echo $rows["dados_pedidos_entrega"]["endereco"];?>, Nº 
                        <?php echo $rows["dados_pedidos_entrega"]["numero"];?> - 
                        <?php echo $rows["dados_pedidos_entrega"]["complemento"];?> - 
                        <?php echo $rows["dados_pedidos_entrega"]["bairro"];?> - 
                        <?php echo $rows["dados_pedidos_entrega"]["cidade"];?>/
                        <?php echo $rows["dados_pedidos_entrega"]["uf"];?>
                        <p><b>Ponto de Referência:</b> <?php echo $rows["dados_pedidos_entrega"]["ponto_referencia"];?></p>
                        
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <p><b>Forma de entrega</b></p>
                        <?php 
                            if ($rows["retirar_na_loja"] == "S") {
                                echo "Retirar na Loja";
                            } else {
                                echo "Entrega a domicílio";
                            }
                        ?>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
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
        </div>
    </div>
</div>