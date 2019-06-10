    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="row">
            <div class="col-xs-4 col-sm-5 col-md-5"></div>
            <div class="col-xs-4 col-sm-2 col-md-2">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url();?>"> 
                        <img class="img-responsive" src="<?php echo base_url('asset/img/logo.png');?>" alt="logo">
                    </a>
                </div>
            </div>
            <div class="col-xs-4 col-sm-5 col-md-5"></div>
        </div>
        <div class="row menu">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url();?>"><i class="fa fa-cutlery"></i> Cardapio</a></li>
                    <li><a href="<?php echo base_url('formasPagamentos/index');?>"><i class="fa fa-money"></i> Forma de Pagamento</a></li>
                    <li><a href="<?php echo base_url('contato/index');?>"><i class="fa fa-phone"></i> Contato</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right no-mobile nav-barras">
                    <li> 
                        <?php if ($expedientes["aberto"] == "S") {?>
                            <div class="col-xs-3 col-sm-4 col-md-3">
                                <i class="fa fa-circle bloco-icone icone-on"></i>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-9 txt-barra">
                                <p>Loja Aberta</p>
                                <em>Faça seu pedido</em><br />
                            </div>
                        <?php } else {?>
                            <div class="col-xs-3 col-sm-4 col-md-3">
                                <i class="fa fa-circle bloco-icone icone-off"></i>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-9 txt-barra">
                                <p>Loja Fechada</p>
                                <em>Aguade para efetuar seu pedido</em><br />
                            </div>
                        <?php }?>
                    </li>
                    <li>
                        <div class="col-xs-3 col-sm-4 col-md-3">
                            <i class="fa fa-clock-o bloco-icone"></i>
                        </div>
                         <div class="col-xs-9 col-sm-8 col-md-9 txt-barra">
                            <p>Tempo de entrega</p>
                            <em><?php echo $configuracoes["tempo_entrega"];?></em><br />
                        </div>
                    </li>
                    <li class="no-borda-right">
                        <div class="col-xs-3 col-sm-4 col-md-3">
                            <i class="fa fa-user bloco-icone"></i>
                        </div>
                         <div class="col-xs-9 col-sm-8 col-md-9 txt-barra">
                            Área do Cliente<br />
                            <a href="<?php echo base_url('login/index');?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Cadastrar</a>
                            <a href="<?php echo base_url('login/index');?>" class="btn btn-default btn-xs"><i class="fa fa-lock"></i> Entrar</a>
                        </div>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
      </div>
    </nav>
    <div class="container">
       
                
