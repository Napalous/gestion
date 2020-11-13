<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110112618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vente_article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66BA206B11 ON article (codebarre)');
        $this->addSql('ALTER TABLE vente ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_888A2A4C7294869C ON vente (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente_article (vente_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_5D3092867DC7170A (vente_id), INDEX IDX_5D3092867294869C (article_id), PRIMARY KEY(vente_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vente_article ADD CONSTRAINT FK_5D3092867294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vente_article ADD CONSTRAINT FK_5D3092867DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_23A0E66BA206B11 ON article');
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4C7294869C');
        $this->addSql('DROP INDEX IDX_888A2A4C7294869C ON vente');
        $this->addSql('ALTER TABLE vente DROP article_id');
    }
}
