/*
 Navicat Premium Data Transfer

 Source Server         : BASE_LARAGON_MYSQL
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : laravel

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 28/10/2023 17:20:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for accounts
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `banco` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of accounts
-- ----------------------------
INSERT INTO `accounts` VALUES (1, 'teste', '2023-10-28 11:36:30', '2023-10-28 11:36:30');

-- ----------------------------
-- Table structure for chirps
-- ----------------------------
DROP TABLE IF EXISTS `chirps`;
CREATE TABLE `chirps`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `chirps_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `chirps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chirps
-- ----------------------------

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES (1, 'teste', NULL, NULL, '2023-10-27 04:04:28', '2023-10-27 04:04:28');
INSERT INTO `clients` VALUES (2, 'teste2', NULL, NULL, '2023-10-27 04:09:12', '2023-10-27 04:09:12');

-- ----------------------------
-- Table structure for contrato_movimentacao_historicos
-- ----------------------------
DROP TABLE IF EXISTS `contrato_movimentacao_historicos`;
CREATE TABLE `contrato_movimentacao_historicos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `screen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contrato_movimentacao_historicos_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contrato_movimentacao_historicos_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `contrato_movimentacao_historicos_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contrato_movimentacao_historicos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contrato_movimentacao_historicos
-- ----------------------------

-- ----------------------------
-- Table structure for contrato_pagamento
-- ----------------------------
DROP TABLE IF EXISTS `contrato_pagamento`;
CREATE TABLE `contrato_pagamento`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `numero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `contrato_medicao_id` bigint UNSIGNED NOT NULL,
  `quantidade` double(10, 2) NOT NULL,
  `preco` double(10, 2) NOT NULL,
  `total` double(10, 2) NOT NULL,
  `valor` double(10, 2) NOT NULL,
  `observacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nota_fiscal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contrato_pagamento_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contrato_pagamento_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  INDEX `contrato_pagamento_contrato_medicao_id_foreign`(`contrato_medicao_id` ASC) USING BTREE,
  CONSTRAINT `contrato_pagamento_contrato_medicao_id_foreign` FOREIGN KEY (`contrato_medicao_id`) REFERENCES `contratos_medicoes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contrato_pagamento_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contrato_pagamento_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contrato_pagamento
-- ----------------------------

-- ----------------------------
-- Table structure for contrato_reajustes
-- ----------------------------
DROP TABLE IF EXISTS `contrato_reajustes`;
CREATE TABLE `contrato_reajustes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `indice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_base` double(10, 2) NOT NULL,
  `valor_atual` double(10, 2) NOT NULL,
  `valor_reajuste` double(10, 2) NOT NULL,
  `valor_reajustado` double(10, 2) NOT NULL,
  `contrato_medicao_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contrato_reajustes_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contrato_reajustes_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  INDEX `contrato_reajustes_contrato_medicao_id_foreign`(`contrato_medicao_id` ASC) USING BTREE,
  CONSTRAINT `contrato_reajustes_contrato_medicao_id_foreign` FOREIGN KEY (`contrato_medicao_id`) REFERENCES `contratos_medicoes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contrato_reajustes_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contrato_reajustes_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contrato_reajustes
-- ----------------------------

-- ----------------------------
-- Table structure for contratos
-- ----------------------------
DROP TABLE IF EXISTS `contratos`;
CREATE TABLE `contratos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `numero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('ADITIVO','NORMAL','REDUTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NULL DEFAULT NULL,
  `dados` json NULL,
  `inicio` date NULL DEFAULT NULL,
  `validade` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `situacao` enum('PREENCHIMENTO','AGUARDANDO','REVISAR','REVISADO','APROVADO','CONCLUIDO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PREENCHIMENTO',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contratos_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  CONSTRAINT `contratos_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contratos
-- ----------------------------

-- ----------------------------
-- Table structure for contratos_itens
-- ----------------------------
DROP TABLE IF EXISTS `contratos_itens`;
CREATE TABLE `contratos_itens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `servico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unidade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantidade` double(10, 2) NOT NULL,
  `preco` double(10, 2) NOT NULL,
  `total` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contratos_itens_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contratos_itens_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  CONSTRAINT `contratos_itens_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_itens_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contratos_itens
-- ----------------------------

-- ----------------------------
-- Table structure for contratos_itens_vinculos
-- ----------------------------
DROP TABLE IF EXISTS `contratos_itens_vinculos`;
CREATE TABLE `contratos_itens_vinculos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `contrato_item_id` bigint UNSIGNED NOT NULL,
  `orcamento_id` bigint UNSIGNED NOT NULL,
  `quantidade` double(10, 2) NOT NULL,
  `preco` double(10, 2) NOT NULL,
  `total` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contratos_itens_vinculos_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contratos_itens_vinculos_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  INDEX `contratos_itens_vinculos_contrato_item_id_foreign`(`contrato_item_id` ASC) USING BTREE,
  INDEX `contratos_itens_vinculos_orcamento_id_foreign`(`orcamento_id` ASC) USING BTREE,
  CONSTRAINT `contratos_itens_vinculos_contrato_item_id_foreign` FOREIGN KEY (`contrato_item_id`) REFERENCES `contratos_itens` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_itens_vinculos_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_itens_vinculos_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_itens_vinculos_orcamento_id_foreign` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contratos_itens_vinculos
-- ----------------------------

-- ----------------------------
-- Table structure for contratos_medicoes
-- ----------------------------
DROP TABLE IF EXISTS `contratos_medicoes`;
CREATE TABLE `contratos_medicoes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `status` enum('ABERTA','FECHADA','REVISAR','REVISADA','APROVADA','PAGA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ABERTA',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contratos_medicoes_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contratos_medicoes_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  CONSTRAINT `contratos_medicoes_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_medicoes_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contratos_medicoes
-- ----------------------------

-- ----------------------------
-- Table structure for contratos_medicoes_itens
-- ----------------------------
DROP TABLE IF EXISTS `contratos_medicoes_itens`;
CREATE TABLE `contratos_medicoes_itens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `contrato_medicao_id` bigint UNSIGNED NOT NULL,
  `contrato_item_id` bigint UNSIGNED NOT NULL,
  `quantidade` double(10, 2) NOT NULL,
  `preco` double(10, 2) NOT NULL,
  `total` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contratos_medicoes_itens_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `contratos_medicoes_itens_contratos_id_foreign`(`contratos_id` ASC) USING BTREE,
  INDEX `contratos_medicoes_itens_contrato_medicao_id_foreign`(`contrato_medicao_id` ASC) USING BTREE,
  INDEX `contratos_medicoes_itens_contrato_item_id_foreign`(`contrato_item_id` ASC) USING BTREE,
  CONSTRAINT `contratos_medicoes_itens_contrato_item_id_foreign` FOREIGN KEY (`contrato_item_id`) REFERENCES `contratos_itens` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_medicoes_itens_contrato_medicao_id_foreign` FOREIGN KEY (`contrato_medicao_id`) REFERENCES `contratos_medicoes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_medicoes_itens_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contratos_medicoes_itens_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contratos_medicoes_itens
-- ----------------------------

-- ----------------------------
-- Table structure for customs
-- ----------------------------
DROP TABLE IF EXISTS `customs`;
CREATE TABLE `customs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `resume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `values` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `data` json NULL,
  `custom` json NULL,
  `special` json NULL,
  `can` json NULL,
  `canot` json NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customs_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  CONSTRAINT `customs_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customs
-- ----------------------------

-- ----------------------------
-- Table structure for expenses
-- ----------------------------
DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounts_id` bigint UNSIGNED NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `valor` double(8, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `expenses_account_id_foreign`(`accounts_id` ASC) USING BTREE,
  INDEX `expenses_user_id_foreign`(`users_id` ASC) USING BTREE,
  CONSTRAINT `expenses_account_id_foreign` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of expenses
-- ----------------------------
INSERT INTO `expenses` VALUES (1, '2023-10-05 00:00:00', '123123123', 1, 1, 123.00, '2023-10-28 11:37:21', '2023-10-28 11:37:21');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for fornecedores
-- ----------------------------
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `fornecedor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `servico_principal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cnpj` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `obra_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fornecedores_obra_id_foreign`(`obra_id` ASC) USING BTREE,
  CONSTRAINT `fornecedores_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fornecedores
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2023_07_31_224705_create_chirps_table', 1);
INSERT INTO `migrations` VALUES (6, '2023_07_31_235900_create_obras_controllers_table', 1);
INSERT INTO `migrations` VALUES (7, '2023_08_01_002252_create_orcamentos_table', 1);
INSERT INTO `migrations` VALUES (8, '2023_08_01_161515_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (9, '2023_08_05_003936_create_contratos_table', 1);
INSERT INTO `migrations` VALUES (10, '2023_08_08_130558_create_owners_table', 1);
INSERT INTO `migrations` VALUES (11, '2023_08_08_130558_create_patients_table', 1);
INSERT INTO `migrations` VALUES (12, '2023_08_08_130614_create_treatments_table', 1);
INSERT INTO `migrations` VALUES (13, '2023_08_10_172630_create_fornecedores_table', 1);
INSERT INTO `migrations` VALUES (14, '2023_08_15_124402_alter_contratos_add_enum_status', 1);
INSERT INTO `migrations` VALUES (15, '2023_08_17_140121_customs', 1);
INSERT INTO `migrations` VALUES (16, '2023_10_27_0314423_create_transactions_table', 1);
INSERT INTO `migrations` VALUES (17, '2023_10_27_031514_create_expenses_table', 1);

-- ----------------------------
-- Table structure for obras
-- ----------------------------
DROP TABLE IF EXISTS `obras`;
CREATE TABLE `obras`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `endereco` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bairro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cidade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `uf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contratante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cnpj` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `Cliente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `Contratada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_responsavel_cliente_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_responsavel_contratada_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `obras_user_responsavel_cliente_id_foreign`(`user_responsavel_cliente_id` ASC) USING BTREE,
  INDEX `obras_user_responsavel_contratada_id_foreign`(`user_responsavel_contratada_id` ASC) USING BTREE,
  CONSTRAINT `obras_user_responsavel_cliente_id_foreign` FOREIGN KEY (`user_responsavel_cliente_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `obras_user_responsavel_contratada_id_foreign` FOREIGN KEY (`user_responsavel_contratada_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of obras
-- ----------------------------

-- ----------------------------
-- Table structure for obras_user
-- ----------------------------
DROP TABLE IF EXISTS `obras_user`;
CREATE TABLE `obras_user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `obras_user_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `obras_user_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `obras_user_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `obras_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of obras_user
-- ----------------------------

-- ----------------------------
-- Table structure for orcamentos
-- ----------------------------
DROP TABLE IF EXISTS `orcamentos`;
CREATE TABLE `orcamentos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `obras_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `servico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `medivel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `grupo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `indice_base` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `indice_valor` double(4, 3) NULL DEFAULT NULL,
  `unidade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantidade` double(4, 2) NULL DEFAULT NULL,
  `preco` double(4, 2) NULL DEFAULT NULL,
  `total` double(4, 2) NULL DEFAULT NULL,
  `total_indexado` double(4, 3) NULL DEFAULT NULL,
  `data` json NULL,
  `fistrelationship` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `level` int NULL DEFAULT NULL,
  `ordem` int NULL DEFAULT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deep` int NULL DEFAULT NULL,
  `orcamentos_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orcamentos_obras_id_foreign`(`obras_id` ASC) USING BTREE,
  INDEX `orcamentos_orcamentos_id_foreign`(`orcamentos_id` ASC) USING BTREE,
  CONSTRAINT `orcamentos_obras_id_foreign` FOREIGN KEY (`obras_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `orcamentos_orcamentos_id_foreign` FOREIGN KEY (`orcamentos_id`) REFERENCES `orcamentos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orcamentos
-- ----------------------------

-- ----------------------------
-- Table structure for owners
-- ----------------------------
DROP TABLE IF EXISTS `owners`;
CREATE TABLE `owners`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of owners
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for patients
-- ----------------------------
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_of_birth` date NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `patients_owner_id_foreign`(`owner_id` ASC) USING BTREE,
  CONSTRAINT `patients_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patients
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for sellers
-- ----------------------------
DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sellers
-- ----------------------------
INSERT INTO `sellers` VALUES (1, 'teste2', NULL, '2023-10-27 04:04:35', '2023-10-27 04:04:35');
INSERT INTO `sellers` VALUES (2, 'teste 4', NULL, '2023-10-27 04:09:19', '2023-10-27 04:09:19');

-- ----------------------------
-- Table structure for sites
-- ----------------------------
DROP TABLE IF EXISTS `sites`;
CREATE TABLE `sites`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sites
-- ----------------------------
INSERT INTO `sites` VALUES (1, 'teste', '2023-10-27 04:05:27', '2023-10-27 04:05:27');
INSERT INTO `sites` VALUES (2, 'teste 6', '2023-10-27 04:09:24', '2023-10-27 04:09:24');

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `type` enum('compra','venda') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` double(8, 2) NOT NULL,
  `cotacao` double(8, 2) NOT NULL,
  `clients_id` bigint UNSIGNED NOT NULL,
  `sellers_id` bigint UNSIGNED NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `sites_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `repasse` tinyint(1) NULL DEFAULT 0,
  `valor_convertido` double(8, 2) GENERATED ALWAYS AS ((`valor` * `cotacao`)) STORED NULL,
  `observacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `valor_convertido_considerado` int GENERATED ALWAYS AS (if((`type` = _utf8mb4'compra'),((`valor` * `cotacao`) * -(1)),(`valor` * `cotacao`))) STORED NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transactions_clients_id_foreign`(`clients_id` ASC) USING BTREE,
  INDEX `transactions_sellers_id_foreign`(`sellers_id` ASC) USING BTREE,
  INDEX `transactions_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `transactions_sites_id_foreign`(`sites_id` ASC) USING BTREE,
  CONSTRAINT `transactions_clients_id_foreign` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transactions_sellers_id_foreign` FOREIGN KEY (`sellers_id`) REFERENCES `sellers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transactions_sites_id_foreign` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transactions_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (1, '2023-10-26 00:00:00', 'compra', 123.00, 12.00, 1, 1, 1, 1, '2023-10-27 04:07:51', '2023-10-27 04:07:51', 1, DEFAULT, NULL, DEFAULT);
INSERT INTO `transactions` VALUES (2, '2023-10-26 00:00:00', 'venda', 12.00, 123.00, 2, 2, 1, 1, '2023-10-27 04:09:28', '2023-10-27 04:09:28', 0, DEFAULT, NULL, DEFAULT);

-- ----------------------------
-- Table structure for treatments
-- ----------------------------
DROP TABLE IF EXISTS `treatments`;
CREATE TABLE `treatments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `price` int UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `treatments_patient_id_foreign`(`patient_id` ASC) USING BTREE,
  CONSTRAINT `treatments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of treatments
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Test User', 'test@example.com', '2023-10-27 04:03:59', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'V9zWVYRrbZ', '2023-10-27 04:03:59', '2023-10-27 04:03:59');

SET FOREIGN_KEY_CHECKS = 1;
