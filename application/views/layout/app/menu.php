<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?php echo base_url('app/home/index');?>">
                <img style="height: 30px;display: inline;" src="<?php echo base_url('asset/img/favicon.png');?>" alt="logo"> Valbernielson's</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li <?php echo ($active == "home") ? 'class="active"' : "" ;?>><a href="<?php echo base_url('app/home/index');?>"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                <li class="dropdown <?php echo (in_array($active, array("clientes","categorias","produtos","formasPagamentos","statusPedidos","paginas","usuarios"))) ? 'active' : "" ;?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-plus" aria-hidden="true"></i> Cadastros <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('app/clientes/index');?>">Clientes</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/categorias/index');?>">Categorias</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/produtos/index');?>">Produtos</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/formasPagamentos/index');?>">Formas de Pagamentos</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/statusPedidos/index');?>">Status Pedidos</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/paginas/index');?>">Páginas Site</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('app/usuarios/index');?>">Usuários</a></li>
                    </ul>
                </li>
                <li <?php echo ($active == "pedidos") ? 'class="active"' : "" ;?>><a href="<?php echo base_url('app/pedidos/index');?>"><i class="fa fa-cart-plus" aria-hidden="true"></i> Pedidos</a></li>
                <li <?php echo ($active == "configuracao") ? 'class="active"' : "" ;?>><a href="<?php echo base_url('app/configuracoes/index');?>"><i class="fa fa-cog" aria-hidden="true"></i> Configuração</a></li>
                <li <?php echo ($active == "login") ? 'class="active"' : "" ;?>><a href="<?php echo base_url('app/login/logout');?>"><i class="fa fa-power-off" aria-hidden="true"></i> Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
