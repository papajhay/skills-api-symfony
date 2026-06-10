<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260603000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create app_user, category, and product tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME(6) NOT NULL, updated_at DATETIME(6) DEFAULT NULL, UNIQUE INDEX uniq_app_user_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME(6) NOT NULL, UNIQUE INDEX uniq_category_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(150) NOT NULL, sku VARCHAR(64) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, stock INT NOT NULL, is_published TINYINT(1) NOT NULL, created_at DATETIME(6) NOT NULL, updated_at DATETIME(6) DEFAULT NULL, UNIQUE INDEX uniq_product_sku (sku), INDEX idx_product_category_id (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_PRODUCT_CATEGORY_ID FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_PRODUCT_CATEGORY_ID');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE app_user');
    }
}
