<div class="container container-branco">
    <div class="panel panel-default painel-personalizado">
        <div class="panel-body">
            <h3 class="border-bottom"><span class="titulo-pagina"><?php echo $title;?></span>
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
                        <th>COR</th>
                        <th>NOME</th>
                        <th class="tac">STATUS</th>
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
                            <td><span class="btn btn-<?php echo $rows["cor"];?>"></span></td>
                            <td><?php echo $rows["nome"];?></td>
                            <td class="tac">
                             <?php  
                                if ($rows["status"] == "A") {
                                    echo '<a href="" class="btn btn-success btn-xs" title="Ativo">Ativo</a>';
                                }
                                if (($rows["status"] == "I") || ($rows["status"] == "")) {
                                    echo '<a href="" class="btn btn-danger btn-xs" title="Inativo">Inativo</a>';
                                }
                            ?>
                            </td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
