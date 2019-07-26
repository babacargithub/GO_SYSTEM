<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190726154548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_shop (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, gerant VARCHAR(255) NOT NULL, tel BIGINT NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_EF07564C6C6E55B5 (nom), UNIQUE INDEX UNIQ_EF07564CF037AB0F (tel), UNIQUE INDEX UNIQ_EF07564CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop ADD company INT DEFAULT NULL, ADD ferme TINYINT(1) NOT NULL, ADD ferme_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA24FBF094F FOREIGN KEY (company) REFERENCES company_shop (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AC6A4CA24FBF094F ON shop (company)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA24FBF094F');
        $this->addSql('DROP TABLE company_shop');
        $this->addSql('DROP INDEX IDX_AC6A4CA24FBF094F ON shop');
        $this->addSql('ALTER TABLE shop DROP company, DROP ferme, DROP ferme_at');
    }
}
