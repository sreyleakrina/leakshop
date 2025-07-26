CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `class` VARCHAR(100) NOT NULL,
  `academic_year` VARCHAR(50) NOT NULL,
  `pay_type` VARCHAR(50) NOT NULL,
  `date` DATE NOT NULL,
  `price` DECIMAL(10,2) NOT NULL
);
