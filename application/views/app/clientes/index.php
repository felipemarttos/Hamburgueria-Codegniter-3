<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3 class="border-bottom"><span class="titulo-pagina"><?php echo $title;?></span>
                <a href="<?php echo base_url('app/clientes/add');?>" class="btn btn-success pull-right"><span class="fa fa-plus"></span> <span class="no-mobile"> Novo Cliente</span></a>    
            </h3>
            <h3 class="titulo-filtro">Filtro</h3>
            <?php echo form_open('app/clientes/index'); ?>
            <div class="row">
                <div class="col-sm-5">
                    <label>Por</label>
                    <select name="tipo" required id="tipo" class="form-control select2">
                        <option value="" selected="selected">Selecione ...</option>
                            <option value="N">Nome</option>
                            <option value="T">Telefone</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label>Nome ou Telefone</label>
                    <input type="text" required class="form-control input-sm" name="campo_filtro">
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
                        <th>NOME</th>
                        <th>E-MAIL</th>
                        <th class="tac">FONE</th>
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
                    ?>      
                        <tr>
                            <td class="tac"><?php echo $rows["id"];?></td>
                            <td><?php echo $rows["nome"];?></td>
                            <td><?php echo $rows["email"];?></td>
                            <td><?php echo $rows["telefone"];?></td>
                            <td class="tac">
                             <?php  
                                if ($rows["status"] == "A") {
                                    echo '<a href="'.base_url('app/clientes/status/'.$rows["id"]).'" class="btn btn-success btn-xs" title="Ativo">Ativo</a>';
                                }
                                if (($rows["status"] == "I") || ($rows["status"] == "")) {
                                    echo '<a href="'.base_url('app/clientes/status/'.$rows["id"]).'" class="btn btn-danger btn-xs" title="Inativo">Inativo</a>';
                                }
                            ?>
                            </td>
                            <td class="tac">
                                <a href="<?php echo base_url('app/clientes/edit/'.$rows["id"]);?>"  class="btn btn-info btn-xs" title="Editar"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo base_url('app/clientes/delete/'.$rows["id"]);?>" onclick="return confirm('Deseja remover este registro?')" class="btn btn-danger btn-xs" title="Remover"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

