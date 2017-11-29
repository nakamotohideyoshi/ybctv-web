CREATE TABLE `wp_2_email_builder_logs` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `CreatedAt` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

alter table wp_2_email_builder_logs add column Ref varchar(255) not null default '' after Id;
