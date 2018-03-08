<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160807231949 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_admin_redactor (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_back VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57AADE9F85E0677 (username), UNIQUE INDEX UNIQ_57AADE9E7927C74 (email), UNIQUE INDEX UNIQ_57AADE9F2F8E1B2 (email_back), INDEX IDX_57AADE925ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_administrator (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_back VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EDCC2095F85E0677 (username), UNIQUE INDEX UNIQ_EDCC2095E7927C74 (email), UNIQUE INDEX UNIQ_EDCC2095F2F8E1B2 (email_back), INDEX IDX_EDCC209525ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_infoUser (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(128) NOT NULL, last_name VARCHAR(128) DEFAULT NULL, birthday DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_moderator (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_back VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_19AA3580F85E0677 (username), UNIQUE INDEX UNIQ_19AA3580E7927C74 (email), UNIQUE INDEX UNIQ_19AA3580F2F8E1B2 (email_back), INDEX IDX_19AA358025ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_admin_redactor ADD CONSTRAINT FK_57AADE925ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
        $this->addSql('ALTER TABLE cm_admin_administrator ADD CONSTRAINT FK_EDCC209525ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
        $this->addSql('ALTER TABLE cm_admin_moderator ADD CONSTRAINT FK_19AA358025ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_admin_redactor DROP FOREIGN KEY FK_57AADE925ABFA0B');
        $this->addSql('ALTER TABLE cm_admin_administrator DROP FOREIGN KEY FK_EDCC209525ABFA0B');
        $this->addSql('ALTER TABLE cm_admin_moderator DROP FOREIGN KEY FK_19AA358025ABFA0B');
        $this->addSql('DROP TABLE cm_admin_redactor');
        $this->addSql('DROP TABLE cm_admin_administrator');
        $this->addSql('DROP TABLE cm_admin_infoUser');
        $this->addSql('DROP TABLE cm_admin_moderator');
    }
}
