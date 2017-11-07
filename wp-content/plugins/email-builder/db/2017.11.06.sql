alter table `wp_2_email_builder_emails` add column EditorId bigint not null default 0;
alter table `wp_2_email_builder_emails` add column EditorDisplayName varchar(255) not null default '';
alter table `wp_2_email_builder_emails` add column CreatedAt datetime not null;
alter table `wp_2_email_builder_emails` add column UpdatedAt datetime not null;
