<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $title;?></h4>
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
                        echo form_open_multipart('/app/paginas/update', 'class="form-sample"'); 
                        echo '<input type="hidden" name="id" value="'.$id.'" />';
                    } 
                ?>
                    <p class="card-description"></p>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nome da Página</label>
                            <input type="text" name="nome_pagina" value="<?php echo (isset($nome_pagina) && strlen($nome_pagina) > 0) ? $nome_pagina : "";?>" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label>Titulo da Página</label>
                            <input type="text" name="titulo_pagina" value="<?php echo (isset($titulo_pagina) && strlen($titulo_pagina) > 0) ? $titulo_pagina : "";?>" class="form-control" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Selecione ...</option>
                                <option value="S" <?php echo (isset($status) && $status == "S") ? "selected" : "";?>>Ativo</option>
                                <option value="N" <?php echo (isset($status) && $status == "N") ? "selected" : "";?>>Inativo</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Conteúdo da Página</label>
                            <textarea name="conteudo" class="form-control editor_full"><?php echo $conteudo;?></textarea>
                        </div>
                    </div><br>
                    <p class="card-description">
                      SEO
                    </p>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Meta Title</label>
                            <textarea name="meta_title" class="form-control"><?php echo (isset($meta_title) && strlen($meta_title) > 0) ? $meta_title : "";?></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Meta Desription</label>
                            <textarea name="meta_description" class="form-control"><?php echo (isset($meta_description) && strlen($meta_description) > 0) ? $meta_description : "";?></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Meta Key</label>
                            <textarea name="meta_key" class="form-control"> <?php echo (isset($meta_key) && strlen($meta_key) > 0) ? $meta_key : "";?></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12 tac">
                            <button type="submit" class="btn btn-primary mr-2">Salvar</button>
                            <a href="<?php echo base_url('/app/paginas/index');?>" class="btn btn-light">Voltar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>