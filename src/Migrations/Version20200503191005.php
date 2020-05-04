<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200503191005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__aa_users AS SELECT id, email, password, created_at, updated_at FROM aa_users');
        $this->addSql('DROP TABLE aa_users');
        $this->addSql('CREATE TABLE aa_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(75) NOT NULL COLLATE BINARY, password VARCHAR(125) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO aa_users (id, email, password, created_at, updated_at) SELECT id, email, password, created_at, updated_at FROM __temp__aa_users');
        $this->addSql('DROP TABLE __temp__aa_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BDBD0CBE7927C74 ON aa_users (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_7BDBD0CBE7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__aa_users AS SELECT id, email, password, created_at, updated_at FROM aa_users');
        $this->addSql('DROP TABLE aa_users');
        $this->addSql('CREATE TABLE aa_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(75) NOT NULL, password VARCHAR(125) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO aa_users (id, email, password, created_at, updated_at) SELECT id, email, password, created_at, updated_at FROM __temp__aa_users');
        $this->addSql('DROP TABLE __temp__aa_users');
    }
}
