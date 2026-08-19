<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819070939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, quantity_purchased INT NOT NULL, purchase_price DOUBLE PRECISION NOT NULL, selling_price DOUBLE PRECISION DEFAULT NULL, quantity_sold INT NOT NULL, date_of_purchase DATETIME NOT NULL, date_of_sale DATETIME DEFAULT NULL, article_id INT DEFAULT NULL, INDEX IDX_7C68921F7294869C (article_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F7294869C FOREIGN KEY (article_id) REFERENCES article_archive (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F7294869C');
        $this->addSql('DROP TABLE wallet');
    }
}
