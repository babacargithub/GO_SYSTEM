<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190524173622 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE go_main_compte_banque (id INT AUTO_INCREMENT NOT NULL, numCompte BIGINT NOT NULL, libelle VARCHAR(100) NOT NULL, solde INT NOT NULL, banque INT NOT NULL, dateDerniereOp DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552A4C4478');
        $this->addSql('DROP INDEX UNIQ_42C849552A4C4478 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP paiement_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE go_main_compte_banque');
        $this->addSql('ALTER TABLE reservation ADD paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552A4C4478 FOREIGN KEY (paiement_id) REFERENCES payer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C849552A4C4478 ON reservation (paiement_id)');
    }
}
