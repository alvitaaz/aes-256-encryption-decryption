-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS `secure_app_db`;

-- Gunakan database yang dibuat
USE `secure_app_db`;

-- Tabel untuk menyimpan informasi pengguna
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabel untuk menyimpan data terenkripsi terkait dengan pengguna
CREATE TABLE `encrypted_data` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `encrypted_content` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id_idx` (`user_id`),
    CONSTRAINT `fk_user_id`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Isi contoh pengguna (gunakan password_hash untuk menyimpan kata sandi yang terenkripsi)
INSERT INTO `users` (`username`, `password`) VALUES
('alvita', '$2y$10$B9c9Y2UshPT4FZPb.xQ9h.NTJ3kDaVHG9dcdJK/Z.0vF7AAYRJtRi'); -- Password admin
