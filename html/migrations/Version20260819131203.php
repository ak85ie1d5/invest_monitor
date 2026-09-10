<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819131203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Inverse la relation Wallet/Product : une ligne de portefeuille reference un seul produit';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY `FK_D34A04AD712520F3`');
        $this->addSql('DROP INDEX IDX_D34A04AD712520F3 ON product');
        $this->addSql('ALTER TABLE product DROP wallet_id');
        // product_id est NOT NULL et la table product est vide :
        // les lignes de wallet existantes ne peuvent pas etre rattachees a un produit.
        $this->addSql('DELETE FROM wallet');
        $this->addSql('ALTER TABLE wallet ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_7C68921F4584665A ON wallet (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD wallet_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT `FK_D34A04AD712520F3` FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD712520F3 ON product (wallet_id)');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F4584665A');
        $this->addSql('DROP INDEX IDX_7C68921F4584665A ON wallet');
        $this->addSql('ALTER TABLE wallet DROP product_id');
    }
}
