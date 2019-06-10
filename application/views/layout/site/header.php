<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $configuracoes["nome_site"];?> |  <?php echo $title;?></title>
    <link rel="icon" href="<?php echo base_url('asset/img/favicon.png?v='.date('YmdHis')); ?>" sizes="32x32" />
    <link href="<?php echo base_url('asset/js/fontawesome463/css/font-awesome.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/js/bootstrap3.0/css/bootstrap.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?php echo base_url('asset/js/smartmenu/jquery.smartmenus.bootstrap.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/js/datapicker/jquery-ui.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/js/DataTables/dataTables.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/js/select2/css/select2.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/css/site.css?v='.date('YmdHis')); ?>" rel="stylesheet">
</head>
<body>
