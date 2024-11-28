CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int NOT NULL DEFAULT '0',
  `home_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `users` (`id`, `username`, `password`, `failed_attempts`, `home_address`, `created_at`) VALUES
(1, 'Alice', '$2y$10$A4OIs2RXF72UMXklBpTbF.2sTYGqagUyDr/MRXvKLRRRr7G0QpUnG', 0, 'Alices Adress', '2024-11-26 13:46:27'),
(2, 'Bob', '$2y$10$A4OIs2RXF72UMXklBpTbF.2sTYGqagUyDr/MRXvKLRRRr7G0QpUnG', 0, 'Bobs Adress', '2024-11-26 13:47:03'),
(3, 'Evil', '$2y$10$A4OIs2RXF72UMXklBpTbF.2sTYGqagUyDr/MRXvKLRRRr7G0QpUnG', 0, 'Evils Adress', '2024-11-26 13:48:19');

-- Move the auto increment to 4 (next id)
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
