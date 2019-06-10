<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3 class="border-bottom"><span class="titulo-pagina"><?php echo $title;?></span>
                <a href="<?php echo base_url('app/produtos/add');?>" class="btn btn-success pull-right"><span class="fa fa-plus"></span> <span class="no-mobile"> Novo Produto</span></a>    
            </h3>
            <h3 class="titulo-filtro">Filtro</h3>
            <?php echo form_open('app/produtos/index'); ?>
            <div class="row">
                <div class="col-sm-5">
                    <label>Categorias</label>
                    <select name="id_categoria"  id="id_categoria" class="form-control select2">
                        <option value="">Selecione ...</option>
                        <?php foreach ($categorias as $key => $value) {?>
                            <option value="<?php echo $value["id"]?>" <?php echo (isset($id_categoria) && $id_categoria == $value["id"]) ? "selected" : "";?>><?php echo $value["nome"];?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label>Nome</label>
                    <input type="text"  class="form-control input-sm" value="<?php echo (isset($campo_filtro)) ? $campo_filtro : "";?>" name="campo_filtro">
                </div>
                <div class="col-sm-2">
                    <div class="ajuste-btn-filtro">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="titulo-th">
                        <th class="tac">#ID</th>
                        <th></th>
                        <th class="tac">CATEGORIA</th>
                        <th>NOME</th>
                        <th class="tac">PREÇO</th>
                        <th class="tac">PREÇO PROMOCIONAL</th>
                        <th class="tac">STATUS</th>
                        <th class="tac">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (empty($list)) {
                            echo '<tr><td colspan="100%" align="center">Nenhum registro encontrado.</td></tr>';
                        } else {
                            foreach ($list as $key => $rows) {
                                
                            if (strlen($rows["imagem"]) > 0) {
                                $imagem = $rows["imagem"];
                            } else {
                                $imagem = "sem_foto.png";
                            }
                    ?>      
                        <tr>
                            <td style="vertical-align: middle;" class="tac"><?php echo $rows["id"];?></td>
                            <td style="vertical-align: middle;" class="tac"><img width="50" src="<?php echo base_url('asset/img/produtos/'.$imagem);?>"alt=""></td>
                            <td style="vertical-align: middle;"><?php echo $rows["categoria_nome"];?></td>
                            <td style="vertical-align: middle;"><?php echo $rows["nome"];?></td>
                            <td style="vertical-align: middle;" class="tac"><?php echo geraValorReais($rows["preco"]);?></td>
                            <td style="vertical-align: middle;" class="tac"><?php echo geraValorReais($rows["preco_promocional"]);?></td>
                            <td style="vertical-align: middle;" class="tac">
                             <?php  
                                if ($rows["status"] == "A") {
                                    echo '<a href="'.base_url('app/produtos/status/'.$rows["id"]).'" class="btn btn-success btn-xs" title="Ativo">Ativo</a>';
                                }
                                if (($rows["status"] == "I") || ($rows["status"] == "")) {
                                    echo '<a href="'.base_url('app/produtos/status/'.$rows["id"]).'" class="btn btn-danger btn-xs" title="Inativo">Inativo</a>';
                                }
                            ?>
                            </td>
                            <td style="vertical-align: middle;" class="tac">
                                <a href="<?php echo base_url('app/produtos/edit/'.$rows["id"]);?>"  class="btn btn-info btn-xs" title="Editar"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo base_url('app/produtos/delete/'.$rows["id"]);?>" onclick="return confirm('Deseja remover este registro?')" class="btn btn-danger btn-xs" title="Remover"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

