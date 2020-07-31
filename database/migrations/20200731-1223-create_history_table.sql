create table `history` (
	`id` int unsigned not null auto_increment primary key, 

	`origin_id` int unsigned not null, 
	`target_id` int unsigned not null, 
	`action` varchar(5) not null,

	`created_at` timestamp default current_timestamp, 
	`updated_at` timestamp null
)