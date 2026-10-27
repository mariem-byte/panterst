<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261022115141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pine ADD no VARCHAR(255) NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE pine ADD CONSTRAINT FK_CBDB5CD1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CBDB5CD1A76ED395 ON pine (user_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE enabled enabled VARCHAR(255) NOT NULL, CHANGE account_non_expired account_non_expired VARCHAR(255) NOT NULL, CHANGE credentials_non_expired credentials_non_expired VARCHAR(255) NOT NULL, CHANGE account_non_locked account_non_locked VARCHAR(255) NOT NULL, CHANGE roles roles VARCHAR(255) NOT NULL, CHANGE extra_fields extra_fields VARCHAR(255) NOT NULL, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pine DROP FOREIGN KEY FK_CBDB5CD1A76ED395');
        $this->addSql('DROP INDEX IDX_CBDB5CD1A76ED395 ON pine');
        $this->addSql('ALTER TABLE pine DROP no, DROP user_id');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE enabled enabled VARCHAR(255) DEFAULT NULL, CHANGE account_non_expired account_non_expired VARCHAR(255) DEFAULT NULL, CHANGE credentials_non_expired credentials_non_expired VARCHAR(255) DEFAULT NULL, CHANGE account_non_locked account_non_locked VARCHAR(255) DEFAULT NULL, CHANGE roles roles VARCHAR(255) DEFAULT NULL, CHANGE extra_fields extra_fields VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }
}
