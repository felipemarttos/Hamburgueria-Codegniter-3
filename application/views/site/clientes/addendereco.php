        <h4><?php echo $title;?></h4>
        <?php if (isset($msg_erro) && count($msg_erro) > 0): ?>
            <div class="alert alert-danger" id="alertas">
                <?php echo implode("<br>", $msg_erro); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($msg_success) && count($msg_success) > 0): ?>
            <div class="alert alert-success" id="alertas">
                <?php echo implode("<br>", $msg_success); ?>
            </div>
        <?php endif; ?>
        <?php 
            if (isset($id) && $id > 0) {
                echo form_open_multipart('/clientes/editEndereco/'.$id, 'class="form-sample"'); 
                echo '<input type="hidden" name="id" value="'.$id.'" />';
                echo '<input type="hidden" name="id_cliente" value="'.$id_cliente.'" />';
            } else {
               echo form_open_multipart('clientes/addEndereco', 'class="form-sample"');
                echo '<input type="hidden" name="id_cliente" value="'.$id_cliente.'" />';

            }
        ?>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <input type="text" class="form-control input-lg" value="<?php echo  (isset($titulo) && strlen($titulo) > 0) ? $titulo : "";?>" name="titulo" id="titulo" placeholder="Titulo do Endereço">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <input type="text" class="form-control cep input-lg" value="<?php echo  (isset($cep) && strlen($cep) > 0) ? $cep : "";?>" name="cep" id="cep" placeholder="CEP">
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                    <input type="text" class="form-control endereco input-lg" value="<?php echo  (isset($endereco) && strlen($endereco) > 0) ? $endereco : "";?>" name="endereco" id="endereco" placeholder="Rua xxx">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <input type="text" class="form-control numero input-lg" value="<?php echo  (isset($numero) && strlen($numero) > 0) ? $numero : "";?>" name="numero" id="numero" placeholder="Nº">
                </div>
            </div><BR>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <input type="text" class="form-control input-lg complemento" value="<?php echo  (isset($complemento) && strlen($complemento) > 0) ? $complemento : "";?>" name="complemento" id="complemento" placeholder="Complemento">
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <input type="text" class="form-control input-lg bairro" value="<?php echo  (isset($bairro) && strlen($bairro) > 0) ? $bairro : "";?>" name="bairro" id="bairro" placeholder="Bairro">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-lg cidade" value="<?php echo  (isset($cidade) && strlen($cidade) > 0) ? $cidade : "";?>" name="cidade" id="cidade" placeholder="Cidade">
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1">
                    <input type="text" class="form-control input-lg uf" value="<?php echo  (isset($uf) && strlen($uf) > 0) ? $uf : "";?>" name="uf" id="uf" placeholder="UF">
                </div>
            </div><BR>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-lg ponto_referencia" value="<?php echo  (isset($ponto_referencia) && strlen($ponto_referencia) > 0) ? $ponto_referencia : "";?>" name="ponto_referencia" id="ponto_referencia" placeholder="Ponto de referência">
                </div>
            </div><BR>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4"></div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <button type="submit" class="btn btn-block btn-success btn-lg">SALVAR</button>
                </div>
            </div>
        </form>
    </div>
</div>