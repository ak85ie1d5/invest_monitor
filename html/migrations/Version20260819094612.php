<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819094612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD underlying_name VARCHAR(50) DEFAULT NULL, ADD underlying_isin VARCHAR(12) DEFAULT NULL, CHANGE stop_loss_currency stop_loss_currency VARCHAR(255) DEFAULT NULL, CHANGE leverage leverage DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP underlying_name, DROP underlying_isin, CHANGE stop_loss_currency stop_loss_currency VARCHAR(255) NOT NULL, CHANGE leverage leverage DOUBLE PRECISION NOT NULL');
    }
}
