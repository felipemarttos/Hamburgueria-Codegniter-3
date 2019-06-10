<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo $title;?></h4>
</div>
<div class="modal-body">
<?php 

    if (strlen($produtos["imagem"]) > 0) {
        $imagem = $produtos["imagem"];
    } else {
        $imagem = "sem_foto.png";
    }
    if ($produtos["preco_promocional"] > 0) {
        $preco = $produtos["preco_promocional"];
    } else {
        $preco = $produtos["preco"];
    }
?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <img class="img-responsive" src="<?php echo base_url('asset/img/produtos/'.$imagem);?>" alt="<?php echo $produtos["nome"];?>">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <h4><b><?php echo $produtos["nome"];?></b></h4>
                    <p class="txt-descricao"><?php echo $produtos["descricao"];?></p>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <h3 class="txt-preco"><?php echo geraValorReais($preco);?></h3>
                    <p class="txt-descricao">
                        <input type="number" name="qtde_item" value="1" class="form-control input-lg" placeholder="Qtde">
                    </p>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p>Observações do item:</p>
                    <textarea name="obs_pedido_item" placeholder="ex: Sem alface" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer tac">
    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
    <button type="button" data-preco="<?php echo $preco;?>" data-nome="<?php echo $produtos["nome"];?>" data-id="<?php echo $produtos["id"];?>" class="btn btn-primary btn-add-pedido">Adicionar no Carrinho</button>
</div>