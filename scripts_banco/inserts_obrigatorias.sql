﻿INSERT INTO `tb_categorias` VALUES (1,'Lanches','A',1,'2019-06-08 21:53:28','2019-06-10 17:17:26'),(2,'Porções','A',2,'2019-06-08 21:54:02','2019-06-08 21:54:33'),(3,'Bebidas','A',3,'2019-06-08 21:54:16','2019-06-08 21:54:29');

INSERT INTO `tb_clientes` VALUES (1,'Cliente Teste','teste@vh.com.br','(14) 99837-4009','934b535800b1cba8f96a5d72f72f1611','A','2019-06-08 21:18:27','2019-06-10 17:18:32'),(2,'felipe marttos putti','qwewqe@hotmail.com','(12) 3123-1231','934b535800b1cba8f96a5d72f72f1611','I','2019-06-08 21:20:27','2019-06-10 17:38:27'),(8,'Cliente Teste','ewqe@hotmail.com','(14) 99837-4009','934b535800b1cba8f96a5d72f72f1611','A','2019-06-09 16:25:26','2019-06-10 17:18:37');

INSERT INTO `tb_clientes_enderecos` VALUES (1,8,'MINHA CASA','17421-182','RUA ALEXANDRE CHAIA','188','CASA','AO LADO DA ESCOLA RENE','JD ESPLANADA','MARILIA','SP','A',NULL,'2019-06-09 21:33:31'),(3,1,'CASA 2','04180-112','Travessa 19 de Agosto','1232','','PADARIA','Jardim Maria Estela','São Paulo','SP','A','2019-06-09 21:06:55','2019-06-09 21:33:20');

INSERT INTO `tb_configuracoes` VALUES (1,'Valbernielson\'s Hamburgueria - Pedido Online','Valbernielson\'s Hamburgueria - Pedido Online','','12.321.321/3213-23','UA-76055939-1','felipemarttos@hotmail.com','(14) 3333-4343','(14) 99999-9899','https://www.instagram.com/felipemarttos','https://www.facebook.com/felipemarttos','https://www.youtube.com/','','Rua Alexandre Chaia, Nº 176, Jd. Esplanada - Marília/SP','40 - 60 min',5,NULL,'2019-06-10 17:23:47');

INSERT INTO `tb_expedientes` VALUES (1,'S',NULL,'2019-06-10 17:52:39');

INSERT INTO `tb_formas_pagamentos` VALUES (1,'090619_formas_icone_din.png','Dinheiro','A','2019-06-08 23:22:00','2019-06-10 17:30:40'),(2,'090619_formas_icone_card_cred.png','Cartão de Crédito','A',NULL,'2019-06-10 17:31:15'),(3,'090619_formas_cartao-debito.png','Cartão de Débito','A',NULL,'2019-06-09 21:55:14'),(4,'090619_formas_icone-vale-refeicao.png','Vale Refeição','A',NULL,'2019-06-09 21:55:25'),(5,'090619_formas_vale_ali.png','Vale Alimentação','A',NULL,'2019-06-09 21:55:37');

INSERT INTO `tb_paginas` VALUES (2,'sobre','SOBRE A HAMBUGUERIA','<p>Valbernielson\'s Hamburgueria - Pedido Online</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Lorem Ipsum</strong><span>&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</span></p>',NULL,'2019-06-10 14:34:07','A'),(3,'termos','TERMOS DE USO','<p><strong>Lorem Ipsum</strong><span>&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</span></p>',NULL,'2019-06-10 14:33:53','A');

INSERT INTO `tb_produtos` VALUES (1,1,'xbancon','<p>asdsdsd</p>','100619_produto_kkr-_86-sku-54___lanche__kero-mignon-bacon.jpg',763.25,238.88,'2019-06-08 22:49:20','2019-06-10 17:43:35','A'),(2,3,'Coca Cola 1 Litro','<p>coca pet</p>','100619_produto_12175683682334.jpg',9.5,0,'2019-06-08 22:56:23','2019-06-10 17:42:14','A'),(3,1,'X SALADA BACON HAMBURGUER CASEIRO','<p>asda</p>','100619_produto_burguer_salad-1000x1000.jpg',20.83,0,'2019-06-09 03:35:06','2019-06-10 17:43:50','A'),(4,1,'X Filé Mignon Salada Bacon ','<p>Fil&eacute;, mu&ccedil;arela, bacon, alface, tomate e maionese.</p>','100619_produto_file.png',32.33,0,'2019-06-09 03:36:12','2019-06-10 17:42:54','A');

INSERT INTO `tb_status_pedidos` VALUES (1,'default','AGUARDANDO','Aguardando Confirmação','A','2019-06-08 20:56:01','2019-06-08 23:07:07'),(2,'info','CONFIRMADO','Confirmado','A','2019-06-08 20:58:01','2019-06-08 21:00:22'),(3,'warning','PREPARACAO','Em preparação','A','2019-06-08 21:01:00','2019-06-08 21:01:00'),(4,'primary','SAIUENTREGA','Saiu para entrega','A','2019-06-08 21:01:25','2019-06-08 21:01:25'),(5,'success','FINALIZADO','Finalizado','A','2019-06-08 21:01:37','2019-06-08 21:01:37'),(6,'danger','CANCELADO','Cancelado','A','2019-06-08 21:01:49','2019-06-08 21:01:49');

INSERT INTO `tb_usuarios` VALUES (1,'Valbernielson','adm@adm.com','934b535800b1cba8f96a5d72f72f1611','2019-06-08 19:45:20','2019-04-09 07:23:39','A'));
