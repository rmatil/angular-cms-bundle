<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620101653 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO userGroups (name, role) VALUES ('User', 'ROLE_USER'), ('Member', 'ROLE_MEMBER'), ('Admin', 'ROLE_ADMIN'), ('Super Admin', 'ROLE_SUPER_ADMIN')");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM userGroups WHERE userGroups.role IN ('ROLE_USER', 'ROLE_MEMBER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN')");

    }
}
