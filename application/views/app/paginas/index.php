<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $title;?> 
                <span class="pull-right">
                        <button type="button" class="btn btn-outline-secondary btn-icon-text btn-sm">
                          <i class="mdi mdi-export btn-icon-prepend"></i>                                                    
                          Exportar
                        </button>
                </span></h4>
                <p class="card-description"></p>
                <div class="table-responsive" id="imprimipagina">
                    <table id="data_table" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="tac">#ID</th>
                                <th>Nome Página</th>
                                <th>Titulo Página</th>
                                <th class="tac">Conteúdo</th>
                                <th class="tac">Status</th>
                                <th class="tac">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $row) {?>
                            <tr>
                                <td class="py-1 tac">
                                    <?php echo $row["id"];?>
                                </td>
                                <td><?php echo $row["nome_pagina"];?></td>
                                <td><?php echo $row["titulo_pagina"];?></td>
                                <td class="tac">
                                    <button type="button" data-toggle="modal" DATA-TARGET="#MODAL-<?php echo $row["id"];?>" class="btn btn-warning btn-xxs"><i class="mdi mdi-magnify mdi-sm"></i> Visualizar</button>

                                    <div class="modal fade tal" id="MODAL-<?php echo $row["id"];?>" tabindex="-1" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header tal">
                                            <h4 class="modal-title tal">Conteúdo</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          </div>
                                          <div class="modal-body">
                                            <p><?php echo $row["conteudo"];?></p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-xxs" data-dismiss="modal">Fechar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>


                                </td>
                                <td class="tac">
                                    <?php if ($row["status"] == "S") {?>
                                        <a href="<?php echo base_url('/app/paginas/status/'.$row["id"]);?>">
                                            <label class="badge badge-success">Ativo</label>
                                        </a>
                                    <?php } else {?>
                                        <a href="<?php echo base_url('/app/paginas/status/'.$row["id"]);?>">
                                            <label class="badge badge-danger">Inativo</label>
                                        </a>
                                    <?php }?>
                                </td>
                                <td class="tac">
                                    <a href="<?php echo base_url('/app/paginas/editar/'.$row["id"]);?>" class="btn btn-primary btn-xxs" title="Editar"><i class="mdi mdi-file-check mdi-sm"></i></a>
                                </td>
                            </tr>
                            <?php }?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>