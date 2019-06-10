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
            <div class="col-xs-4 col-sm-3 col-md-3"></div>
            <div class="col-xs-4 col-sm-2 col-md-2 tac">
                <div class="box-cliente-top">
                    <i class="fa fa-user"></i> Área do Cliente <br><br>
                
                    <?php if (isset($_SESSION["cliente"]["username"]) && strlen($_SESSION["cliente"]["username"]) > 0) {?>
                        <span style="color: #fff;font-weight: normal;font-size: 12px;">Olá <b><?php echo $_SESSION["cliente"]["username"];?></b>!</span>
                        <a href="<?php echo base_url('clientes/index');?>" class="btn btn-default btn-block"><i class="fa fa-lock"></i> Minha Conta</a>
                        <a href="<?php echo base_url('login/logout');?>" class="btn btn-warning btn-block"><i class="fa fa-power-off"></i> Sair</a>
                    <?php } else {?>
                        <a href="<?php echo base_url('login/index');?>" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Cadastrar</a>
                        <a href="<?php echo base_url('login/index');?>" class="btn btn-default btn-block"><i class="fa fa-lock"></i> Entrar</a>
                    <?php }?>
                </div>
            </div>
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
                    <li class="<?php echo ($active == "cardapio") ? "active" : "";?>"><a href="<?php echo base_url();?>"><i class="fa fa-cutlery"></i> Cardapio</a></li>
                    <li class="<?php echo ($active == "sobre") ? "active" : "";?>"><a href="<?php echo base_url('sobre/index');?>"><i class="fa fa-home"></i> Sobre</a></li>
                    <li class="<?php echo ($active == "formas") ? "active" : "";?>"><a href="<?php echo base_url('formasPagamentos/index');?>"><i class="fa fa-money"></i> Forma de Pagamento</a></li>
                    <li class="<?php echo ($active == "termos") ? "active" : "";?>"><a href="<?php echo base_url('termos/index');?>"><i class="fa fa-file"></i> Termos de Uso</a></li>
                    <li class="<?php echo ($active == "contato") ? "active" : "";?>"><a href="<?php echo base_url('contato/index');?>"><i class="fa fa-phone"></i> Contato</a></li>
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
                    <li class="no-borda-right">
                        <div class="col-xs-3 col-sm-4 col-md-3">
                            <i class="fa fa-clock-o bloco-icone"></i>
                        </div>
                         <div class="col-xs-9 col-sm-8 col-md-9 txt-barra">
                            <p>Tempo de entrega</p>
                            <em><?php echo $configuracoes["tempo_entrega"];?></em><br />
                        </div>
                       
                    </li>
                  </ul>
                </div>
            </div>
        </div>
      </div>
    </nav>
    <div class="container">
       
                
