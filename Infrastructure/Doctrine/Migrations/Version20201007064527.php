<?php

declare(strict_types=1);

namespace Fleet\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007064527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes ADD tenant_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('DROP INDEX vehicle_idx ON vehicles');
        $this->addSql('ALTER TABLE vehicles ADD tenant_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('CREATE INDEX vehicle_idx ON vehicles (type, make, model, registration_plate)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes DROP tenant_id');
        $this->addSql('DROP INDEX vehicle_idx ON vehicles');
        $this->addSql('ALTER TABLE vehicles DROP tenant_id');
        $this->addSql('CREATE INDEX vehicle_idx ON vehicles (type, make, model, registration_plate)');
    }
}
