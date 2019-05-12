<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190512163429 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE capital');
        $this->addSql('DROP TABLE compte_client');
        $this->addSql('DROP TABLE crm_client_old');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE capital (id INT AUTO_INCREMENT NOT NULL, shop INT NOT NULL, montant INT NOT NULL, descrip VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, lastUpdate DATETIME NOT NULL, INDEX IDX_FFC1833AAC6A4CA2 (shop), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_client (id INT AUTO_INCREMENT NOT NULL, client INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crm_client_old (id INT AUTO_INCREMENT NOT NULL, categorie INT DEFAULT 1 NOT NULL, firstName VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, lastName VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, tel BIGINT NOT NULL, adresse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, sexe VARCHAR(1) DEFAULT NULL COLLATE utf8_unicode_ci, disabled TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, deleated_at DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT NULL, last_active DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EFFAB594F037AB0F (tel), UNIQUE INDEX UNIQ_EFFAB594E7927C74 (email), INDEX IDX_EFFAB594497DD634 (categorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crm_client_old ADD CONSTRAINT FK_EFFAB594497DD634 FOREIGN KEY (categorie) REFERENCES crm_categorie_client (id)');
    }
}
