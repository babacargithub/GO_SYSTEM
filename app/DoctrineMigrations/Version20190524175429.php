<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190524175429 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payer DROP FOREIGN KEY FK_41CB5B9979B2DA48');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B9979B2DA48 FOREIGN KEY (res) REFERENCES reservation (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payer DROP FOREIGN KEY FK_41CB5B9979B2DA48');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B9979B2DA48 FOREIGN KEY (res) REFERENCES reservation (id)');
    }
}
