<div class="container"  style="margin-top: 20px">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3>
                <span class="titulo-pagina"><?php echo $title;?></span>
                <a href="<?php echo base_url('app/produtos/index');?>" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> <span class="no-mobile">Voltar</span></a>
            </h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
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
                        echo form_open_multipart('/app/produtos/update', 'class="form-sample"'); 
                        echo '<input type="hidden" name="id" value="'.$id.'" />';
                    } else {
                       echo form_open_multipart('/app/produtos/create', 'class="form-sample"');  
                    }
                ?>
                <div class="row">
                     <div class="col-md-4">
                        <label>Categoria*:</label>
                        <select name="id_categoria" id="id_categoria" class="form-control select2">
                            <option value="">Selecione ...</option>
                            <?php foreach ($listcategorias as $key => $rows) {?>
                                <option value="<?php echo $rows["id"];?>" <?php echo (isset($id_categoria) && $id_categoria == $rows["id"]) ? "selected" : "";?>><?php echo $rows["nome"];?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <label>Nome do Produto*:</label>
                        <input type="text" name="nome" value="<?php echo (isset($nome) && strlen($nome) > 0) ? $nome : "";?>" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Preço*:</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1">R$</span>
                            <input type="text" name="preco" id="preco" onKeyPress="return(MascaraMoeda(this,'.',',',event))" class="form-control" value="<?php echo (isset($preco) && strlen($preco) > 0) ? geraValorReaisSem($preco) : "";?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Preço Promocional</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1">R$</span>
                            <input type="text" name="preco_promocional" id="preco_promocional" onKeyPress="return(MascaraMoeda(this,'.',',',event))" class="form-control" value="<?php echo (isset($preco_promocional) && strlen($preco_promocional) > 0) ? geraValorReaisSem($preco_promocional) : "";?>">
                        </div>
                    </div>
                    <div class="col-sm-2">
                       <label>Status:</label>
                       <select name="status" id="status" class="form-control select2">
                           <option value="">Selecione ...</option>
                           <option value="A" <?php echo (isset($status) && $status == "A") ? 'selected' : '';?>>Ativo</option>
                           <option value="I" <?php echo (isset($status) && $status == "I") ? 'selected' : '';?>>Inativo</option>
                       </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Detalhes do Produto:</label>
                        <textarea name="descricao" class="form-control editor_full"><?php echo (isset($descricao)) ?  $descricao : "";?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Foto do Produto:</label>
                            <input type="file" name="imagem">
                        </div>
                    </div>
                    <?php if (isset($id) && $id > 0 && strlen($imagem) > 0) {?>
                    <div class="col-md-12">
                        <label>Foto Atual</label><br>
                        <img style="border:solid 2px #cccccc;" width="100" height="80" src="<?php echo base_url('asset/img/produtos/'.$imagem);?>" alt="image" />
                    </div>
                    <?php }?>
                </div>
                <br /><br />
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <input type="submit" class="btn btn-success btn-lg" value="Gravar" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
