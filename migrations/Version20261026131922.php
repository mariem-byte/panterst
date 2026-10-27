<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261026131922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) NOT NULL, CHANGE enabled enabled VARCHAR(255) NOT NULL, CHANGE account_non_expired account_non_expired VARCHAR(255) NOT NULL, CHANGE credentials_non_expired credentials_non_expired VARCHAR(255) NOT NULL, CHANGE account_non_locked account_non_locked VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE extra_fields extra_fields VARCHAR(255) NOT NULL, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE is_verified is_verified TINYINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE enabled enabled VARCHAR(255) DEFAULT NULL, CHANGE account_non_expired account_non_expired VARCHAR(255) DEFAULT NULL, CHANGE credentials_non_expired credentials_non_expired VARCHAR(255) DEFAULT NULL, CHANGE account_non_locked account_non_locked VARCHAR(255) DEFAULT NULL, CHANGE roles roles VARCHAR(255) DEFAULT NULL, CHANGE extra_fields extra_fields VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE is_verified is_verified TINYINT DEFAULT NULL');
    }
}
