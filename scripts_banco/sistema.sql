
CREATE TABLE `tb_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `ordem` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



CREATE TABLE `tb_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;




CREATE TABLE `tb_clientes_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(60) DEFAULT NULL,
  `ponto_referencia` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `tb_clientes_enderecos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;



CREATE TABLE `tb_configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_site` varchar(255) DEFAULT NULL,
  `nome_empresa` varchar(255) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `google_analitcs` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `expediente` longtext,
  `endereco` longtext,
  `tempo_entrega` varchar(255) DEFAULT NULL,
  `taxa_entrega` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



CREATE TABLE `tb_expedientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aberto` varchar(1) DEFAULT NULL COMMENT 'S - sim N - nao',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



CREATE TABLE `tb_formas_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagem` varchar(50) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


CREATE TABLE `tb_paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `nome_pagina` varchar(255) DEFAULT NULL,
  `conteudo` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



CREATE TABLE `tb_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `descricao` longtext,
  `imagem` varchar(255) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `preco_promocional` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



CREATE TABLE `tb_status_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cor` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



CREATE TABLE `tb_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_forma_pagamento` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_cliente_endereco` int(11) DEFAULT NULL,
  `id_status_pedido` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `total_pedido_itens` float DEFAULT NULL,
  `total_pedido` float DEFAULT NULL,
  `taxa_entrega` float DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `retirar_na_loja` varchar(1) DEFAULT 'N' COMMENT 'S sim N nao',
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_cliente_end` (`id_cliente_endereco`),
  KEY `fk_pedidos_clientes` (`id_cliente`),
  KEY `fk_pedidos_formas` (`id_forma_pagamento`),
  KEY `fk_pedidos_status_pedidos` (`id_status_pedido`),
  CONSTRAINT `fk_pedidos_cliente_end` FOREIGN KEY (`id_cliente_endereco`) REFERENCES `tb_clientes_enderecos` (`id`),
  CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id`),
  CONSTRAINT `fk_pedidos_formas` FOREIGN KEY (`id_forma_pagamento`) REFERENCES `tb_formas_pagamentos` (`id`),
  CONSTRAINT `fk_pedidos_status_pedidos` FOREIGN KEY (`id_status_pedido`) REFERENCES `tb_status_pedidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;


CREATE TABLE `tb_pedidos_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `valor_unitario` float DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  `obs` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_pedido_itens` (`id_pedido`),
  KEY `fk_pedido_itens_produto` (`id_produto`),
  CONSTRAINT `fk_pedido_itens_produto` FOREIGN KEY (`id_produto`) REFERENCES `tb_produtos` (`id`),
  CONSTRAINT `fk_pedido_pedido_itens` FOREIGN KEY (`id_pedido`) REFERENCES `tb_pedidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;


CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL COMMENT 'A - ativo I - inativo E - excluido',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

