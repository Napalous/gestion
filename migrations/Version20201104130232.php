<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104130232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, gerant_id INT NOT NULL, quantite INT NOT NULL, vente_at DATETIME NOT NULL, INDEX IDX_888A2A4CA500A924 (gerant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vente_article (vente_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_5D3092867DC7170A (vente_id), INDEX IDX_5D3092867294869C (article_id), PRIMARY KEY(vente_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CA500A924 FOREIGN KEY (gerant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vente_article ADD CONSTRAINT FK_5D3092867DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente_article ADD CONSTRAINT FK_5D3092867294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente_article DROP FOREIGN KEY FK_5D3092867294869C');
        $this->addSql('ALTER TABLE vente_article DROP FOREIGN KEY FK_5D3092867DC7170A');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP TABLE vente_article');
    }
}
