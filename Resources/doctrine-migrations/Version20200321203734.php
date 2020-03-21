<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200321203734 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offers CHANGE url url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event_detail ADD event_attendance_mode VARCHAR(255) DEFAULT "https://schema.org/OfflineEventAttendanceMode", ADD event_status VARCHAR(255) DEFAULT "https://schema.org/EventScheduled", ADD performer VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_detail DROP event_attendance_mode, DROP event_status, DROP performer');
        $this->addSql('ALTER TABLE offers CHANGE url url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
