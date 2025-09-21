-- Script SQL pour ajouter la colonne related_model à la table transactions
-- Exécutez ce script dans votre base de données MySQL

-- Vérifier si la table transactions existe
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('subscription','donation','refund') NOT NULL DEFAULT 'subscription',
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `status` enum('pending','completed','failed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` text,
  `metadata` json DEFAULT NULL,
  `related_model` varchar(255) DEFAULT NULL,
  `related_id` bigint(20) unsigned DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_index` (`user_id`),
  KEY `transactions_type_index` (`type`),
  KEY `transactions_status_index` (`status`),
  KEY `transactions_payment_method_index` (`payment_method`),
  KEY `transactions_transaction_id_index` (`transaction_id`),
  KEY `transactions_related_model_index` (`related_model`),
  KEY `transactions_related_id_index` (`related_id`),
  KEY `transactions_created_at_index` (`created_at`),
  KEY `transactions_processed_at_index` (`processed_at`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Si la table existe déjà, ajouter seulement la colonne related_model
ALTER TABLE `transactions` 
ADD COLUMN IF NOT EXISTS `related_model` varchar(255) DEFAULT NULL AFTER `metadata`,
ADD INDEX IF NOT EXISTS `transactions_related_model_index` (`related_model`);

-- Ajouter la colonne related_model à la table user_subscriptions pour corriger l'erreur
ALTER TABLE `user_subscriptions` 
ADD COLUMN IF NOT EXISTS `related_model` varchar(255) DEFAULT NULL AFTER `updated_at`,
ADD INDEX IF NOT EXISTS `user_subscriptions_related_model_index` (`related_model`);

-- Ajouter la colonne related_model à la table donations pour corriger l'erreur
ALTER TABLE `donations` 
ADD COLUMN IF NOT EXISTS `related_model` varchar(255) DEFAULT NULL AFTER `updated_at`,
ADD INDEX IF NOT EXISTS `donations_related_model_index` (`related_model`);

-- Ajouter la colonne related_model à d'autres tables qui pourraient en avoir besoin
-- Table transactions (si elle existe déjà)
ALTER TABLE `transactions` 
ADD COLUMN IF NOT EXISTS `related_model` varchar(255) DEFAULT NULL AFTER `metadata`,
ADD INDEX IF NOT EXISTS `transactions_related_model_index` (`related_model`);

-- Vérifier que les colonnes ont été ajoutées
DESCRIBE `transactions`;
DESCRIBE `user_subscriptions`;
DESCRIBE `donations`; 