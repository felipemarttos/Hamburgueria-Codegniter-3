<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3 class="border-bottom"><span class="titulo-pagina"><?php echo $title;?></span>
                <a href="<?php echo base_url('/app/formasPagamentos/add/');?>" class="btn btn-success pull-right"><span class="fa fa-plus"></span> <span class="no-mobile"> Nova Forma</span></a>    
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="titulo-th">
                        <th class="tac">#ID</th>
                        <th width="10%"></th>
                        <th>NOME</th>
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
                            <td style="vertical-align: middle;"><img width="50" src="<?php echo base_url('asset/img/formas/'.$imagem);?>"alt=""></td>
                            <td style="vertical-align: middle;"><?php echo $rows["nome"];?></td>
                            <td style="vertical-align: middle;" class="tac">
                             <?php  
                                if ($rows["status"] == "A") {
                                    echo '<a href="'.base_url('app/formasPagamentos/status/'.$rows["id"]).'" class="btn btn-success btn-xs" title="Ativo">Ativo</a>';
                                }
                                if (($rows["status"] == "I") || ($rows["status"] == "")) {
                                    echo '<a href="'.base_url('app/formasPagamentos/status/'.$rows["id"]).'" class="btn btn-danger btn-xs" title="Inativo">Inativo</a>';
                                }
                            ?>
                            </td>
                            <td style="vertical-align: middle;" class="tac">
                                <a href="<?php echo base_url('app/formasPagamentos/edit/'.$rows["id"]);?>"  class="btn btn-info btn-xs" title="Editar"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo base_url('app/formasPagamentos/delete/'.$rows["id"]);?>" onclick="return confirm('Deseja remover este registro?')" class="btn btn-danger btn-xs" title="Remover"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
