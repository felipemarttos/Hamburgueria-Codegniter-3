<div class="container"  style="margin-top: 20px">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3>
                <span class="titulo-pagina"><?php echo $title;?></span>
                <a href="<?php echo base_url('app/clientes/index');?>" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> <span class="no-mobile">Voltar</span></a>
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
                        echo form_open_multipart('/app/clientes/update', 'class="form-sample"'); 
                        echo '<input type="hidden" name="id" value="'.$id.'" />';
                    } else {
                       echo form_open_multipart('/app/clientes/create', 'class="form-sample"');  
                    }
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Nome*:</label>
                        <input type="text" name="nome" value="<?php echo (isset($nome) && strlen($nome) > 0) ? $nome : "";?>" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                        <label>E-mail*:</label>
                        <input type="email" name="email" value="<?php echo (isset($email) && strlen($email) > 0) ? $email : "";?>" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Telefone*:</label>
                        <input type="text" value="<?php echo (isset($telefone) && strlen($telefone) > 0) ?  $telefone : "";?>" class="form-control telefone"  name="telefone" />
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
