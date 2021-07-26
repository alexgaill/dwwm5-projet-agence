<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726101013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, property_id INTEGER NOT NULL, appointment_date DATETIME NOT NULL, email VARCHAR(120) NOT NULL, phone VARCHAR(15) NOT NULL, firstname VARCHAR(65) NOT NULL, lastname VARCHAR(65) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_FE38F8448C03F15C ON appointment (employee_id)');
        $this->addSql('CREATE INDEX IDX_FE38F844549213EC ON appointment (property_id)');
        $this->addSql('CREATE TABLE options (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(30) NOT NULL)');
        $this->addSql('CREATE TABLE pictures (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER DEFAULT NULL, name VARCHAR(40) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0549213EC ON pictures (property_id)');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(120) NOT NULL, surface INTEGER NOT NULL, content CLOB DEFAULT NULL, price INTEGER NOT NULL, rooms INTEGER NOT NULL, floor INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(15) NOT NULL, city VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, transaction_type BOOLEAN NOT NULL, ground_size INTEGER DEFAULT NULL, date_of_construction DATE DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE TABLE property_options (property_id INTEGER NOT NULL, options_id INTEGER NOT NULL, PRIMARY KEY(property_id, options_id))');
        $this->addSql('CREATE INDEX IDX_89F8B0FF549213EC ON property_options (property_id)');
        $this->addSql('CREATE INDEX IDX_89F8B0FF3ADB05F1 ON property_options (options_id)');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role VARCHAR(20) NOT NULL)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(65) NOT NULL, lastname VARCHAR(65) NOT NULL, phone VARCHAR(15) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE options');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_options');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE "user"');
    }
}
