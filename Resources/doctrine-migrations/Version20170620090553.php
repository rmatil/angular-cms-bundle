<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620090553 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_detail (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, event_detail_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, currency VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_DA4604275E453D86 (event_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA4604275E453D86 FOREIGN KEY (event_detail_id) REFERENCES event_detail (id)');
        $this->addSql('ALTER TABLE events ADD event_detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A5E453D86 FOREIGN KEY (event_detail_id) REFERENCES event_detail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5387574A5E453D86 ON events (event_detail_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A5E453D86');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA4604275E453D86');
        $this->addSql('DROP TABLE event_detail');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP INDEX UNIQ_5387574A5E453D86 ON events');
        $this->addSql('ALTER TABLE events DROP event_detail_id');
    }
}
