<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210727084056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_FE38F844549213EC');
        $this->addSql('DROP INDEX IDX_FE38F8448C03F15C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointment AS SELECT id, employee_id, property_id, appointment_date, email, phone, firstname, lastname FROM appointment');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, property_id INTEGER NOT NULL, appointment_date DATETIME NOT NULL, email VARCHAR(120) NOT NULL COLLATE BINARY, phone VARCHAR(15) NOT NULL COLLATE BINARY, firstname VARCHAR(65) NOT NULL COLLATE BINARY, lastname VARCHAR(65) NOT NULL COLLATE BINARY, CONSTRAINT FK_FE38F8448C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FE38F844549213EC FOREIGN KEY (property_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appointment (id, employee_id, property_id, appointment_date, email, phone, firstname, lastname) SELECT id, employee_id, property_id, appointment_date, email, phone, firstname, lastname FROM __temp__appointment');
        $this->addSql('DROP TABLE __temp__appointment');
        $this->addSql('CREATE INDEX IDX_FE38F844549213EC ON appointment (property_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8448C03F15C ON appointment (employee_id)');
        $this->addSql('DROP INDEX IDX_8F7C2FC0549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pictures AS SELECT id, property_id, name FROM pictures');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('CREATE TABLE pictures (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER DEFAULT NULL, name VARCHAR(40) NOT NULL COLLATE BINARY, CONSTRAINT FK_8F7C2FC0549213EC FOREIGN KEY (property_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pictures (id, property_id, name) SELECT id, property_id, name FROM __temp__pictures');
        $this->addSql('DROP TABLE __temp__pictures');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0549213EC ON pictures (property_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, title VARCHAR(120) NOT NULL COLLATE BINARY, surface INTEGER NOT NULL, content CLOB DEFAULT NULL COLLATE BINARY, price INTEGER NOT NULL, rooms INTEGER NOT NULL, floor INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL COLLATE BINARY, zipcode VARCHAR(15) NOT NULL COLLATE BINARY, city VARCHAR(100) NOT NULL COLLATE BINARY, type VARCHAR(50) NOT NULL COLLATE BINARY, transaction_type BOOLEAN NOT NULL, ground_size INTEGER DEFAULT NULL, date_of_construction DATE DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(150) NOT NULL COLLATE BINARY, CONSTRAINT FK_8BF21CDE8C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO property (id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug) SELECT id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('CREATE INDEX IDX_8BF21CDE8C03F15C ON property (employee_id)');
        $this->addSql('DROP INDEX IDX_89F8B0FF3ADB05F1');
        $this->addSql('DROP INDEX IDX_89F8B0FF549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property_options AS SELECT property_id, options_id FROM property_options');
        $this->addSql('DROP TABLE property_options');
        $this->addSql('CREATE TABLE property_options (property_id INTEGER NOT NULL, options_id INTEGER NOT NULL, PRIMARY KEY(property_id, options_id), CONSTRAINT FK_89F8B0FF549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_89F8B0FF3ADB05F1 FOREIGN KEY (options_id) REFERENCES options (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO property_options (property_id, options_id) SELECT property_id, options_id FROM __temp__property_options');
        $this->addSql('DROP TABLE __temp__property_options');
        $this->addSql('CREATE INDEX IDX_89F8B0FF3ADB05F1 ON property_options (options_id)');
        $this->addSql('CREATE INDEX IDX_89F8B0FF549213EC ON property_options (property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_FE38F8448C03F15C');
        $this->addSql('DROP INDEX IDX_FE38F844549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointment AS SELECT id, employee_id, property_id, appointment_date, email, phone, firstname, lastname FROM appointment');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, property_id INTEGER NOT NULL, appointment_date DATETIME NOT NULL, email VARCHAR(120) NOT NULL, phone VARCHAR(15) NOT NULL, firstname VARCHAR(65) NOT NULL, lastname VARCHAR(65) NOT NULL)');
        $this->addSql('INSERT INTO appointment (id, employee_id, property_id, appointment_date, email, phone, firstname, lastname) SELECT id, employee_id, property_id, appointment_date, email, phone, firstname, lastname FROM __temp__appointment');
        $this->addSql('DROP TABLE __temp__appointment');
        $this->addSql('CREATE INDEX IDX_FE38F8448C03F15C ON appointment (employee_id)');
        $this->addSql('CREATE INDEX IDX_FE38F844549213EC ON appointment (property_id)');
        $this->addSql('DROP INDEX IDX_8F7C2FC0549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pictures AS SELECT id, property_id, name FROM pictures');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('CREATE TABLE pictures (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER DEFAULT NULL, name VARCHAR(40) NOT NULL)');
        $this->addSql('INSERT INTO pictures (id, property_id, name) SELECT id, property_id, name FROM __temp__pictures');
        $this->addSql('DROP TABLE __temp__pictures');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0549213EC ON pictures (property_id)');
        $this->addSql('DROP INDEX IDX_8BF21CDE8C03F15C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(120) NOT NULL, surface INTEGER NOT NULL, content CLOB DEFAULT NULL, price INTEGER NOT NULL, rooms INTEGER NOT NULL, floor INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(15) NOT NULL, city VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, transaction_type BOOLEAN NOT NULL, ground_size INTEGER DEFAULT NULL, date_of_construction DATE DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(150) NOT NULL)');
        $this->addSql('INSERT INTO property (id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug) SELECT id, title, surface, content, price, rooms, floor, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('DROP INDEX IDX_89F8B0FF549213EC');
        $this->addSql('DROP INDEX IDX_89F8B0FF3ADB05F1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property_options AS SELECT property_id, options_id FROM property_options');
        $this->addSql('DROP TABLE property_options');
        $this->addSql('CREATE TABLE property_options (property_id INTEGER NOT NULL, options_id INTEGER NOT NULL, PRIMARY KEY(property_id, options_id))');
        $this->addSql('INSERT INTO property_options (property_id, options_id) SELECT property_id, options_id FROM __temp__property_options');
        $this->addSql('DROP TABLE __temp__property_options');
        $this->addSql('CREATE INDEX IDX_89F8B0FF549213EC ON property_options (property_id)');
        $this->addSql('CREATE INDEX IDX_89F8B0FF3ADB05F1 ON property_options (options_id)');
    }
}
