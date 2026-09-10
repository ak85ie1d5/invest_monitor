<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819125416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD wallet_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD712520F3 ON product (wallet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD712520F3');
        $this->addSql('DROP INDEX IDX_D34A04AD712520F3 ON product');
        $this->addSql('ALTER TABLE product DROP wallet_id');
    }
}
