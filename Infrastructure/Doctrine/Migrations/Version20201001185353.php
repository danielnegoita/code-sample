<?php

declare(strict_types=1);

namespace Fleet\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001185353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attributes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, type ENUM(\'size\', \'other\') COMMENT \'(DC2Type:vehicle_attribute_type)\' NOT NULL, image VARCHAR(255) DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_319B9E705E237E06 (name), UNIQUE INDEX UNIQ_319B9E70D17F50A6 (uuid), INDEX attributes_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicles (id INT AUTO_INCREMENT NOT NULL, make VARCHAR(50) NOT NULL, model VARCHAR(100) NOT NULL, manufactured_at DATE DEFAULT NULL, registration_plate VARCHAR(50) DEFAULT NULL, type ENUM(\'small\', \'medium\', \'large\', \'suv\', \'van\', \'convertible\', \'commercial\') COMMENT \'(DC2Type:vehicle_type)\' DEFAULT NULL, status VARCHAR(20) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1FCE69FAD17F50A6 (uuid), INDEX vehicle_idx (type, make, model, registration_plate), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicles_attributes (vehicle_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_C1D08507545317D1 (vehicle_id), INDEX IDX_C1D08507B6E62EFA (attribute_id), PRIMARY KEY(vehicle_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicles_attributes ADD CONSTRAINT FK_C1D08507545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)');
        $this->addSql('ALTER TABLE vehicles_attributes ADD CONSTRAINT FK_C1D08507B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicles_attributes DROP FOREIGN KEY FK_C1D08507B6E62EFA');
        $this->addSql('ALTER TABLE vehicles_attributes DROP FOREIGN KEY FK_C1D08507545317D1');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE vehicles');
        $this->addSql('DROP TABLE vehicles_attributes');
    }
}
