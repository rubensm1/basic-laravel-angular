CREATE TABLE `migrations` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `password_resets` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `arquivos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(63) NOT NULL,
  `hash` varchar(20) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `path` varchar(127) DEFAULT NULL,
  `ativo` boolean NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `login` varchar(31) NOT NULL UNIQUE,
  `email` varchar(64) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `permissao` enum('ADMINISTRADOR','USUARIO','INATIVO') NOT NULL DEFAULT 'USUARIO',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `configuracoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(31) NOT NULL,
  `valor` varchar(63) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `logs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tipo_acao` enum ('CREATE', 'UPDATE', 'DELETE') NOT NULL,
  `classe` varchar(31) NOT NULL,
  `acao` TEXT NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `configuracoes`(`nome`,`valor`) VALUES 
('EMAIL_SUPORTE','suporte@sistema.com'),
('PREFIXO_DOWNLOADS','/storage'),
('TAMANHO_MAXIMO_UPLOAD','10000'),
('SEPARADOR_EMAIL',','),
('TIMEZONE','-4');

