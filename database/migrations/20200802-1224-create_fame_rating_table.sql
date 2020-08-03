create table `rating` (
	`id` int unsigned not null auto_increment primary key, 

	`fame_rating` int unsigned not null default 1,

	`created_at` timestamp null, 
	`updated_at` timestamp null
)