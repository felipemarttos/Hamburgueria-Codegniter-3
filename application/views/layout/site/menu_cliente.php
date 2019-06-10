 <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12 box-branco" style="padding-top: 40px;padding-bottom: 40px;">
         <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2"></div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <a href="<?php echo base_url('clientes/index');?>" class="btn btn-block btn-<?php echo ($active == 'pedidos') ? "primary": "default";?>
                <i class="fa fa-shopping-cart"></i> Meus Pedidos</a>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <a href="<?php echo base_url('clientes/edit');?>" class="btn btn-block btn-<?php echo ($active == 'perfil') ? "primary": "default";?>
                <i class="fa fa-user"></i> Meu Perfil</a>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <a href="<?php echo base_url('clientes/enderecos');?>" class="btn btn-block btn-<?php echo ($active == 'enderecos') ? "primary": "default";?>
                <i class="fa fa-map-marker"></i> Meus Endereços</a>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <a href="<?php echo base_url('login/logout');?>" class="btn btn-block btn-<?php echo ($active == 'sair') ? "primary": "default";?>
                    <i class="fa fa-power-off"></i> Sair</a>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"></div>
        </div>
        <hr>
