<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170223181910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_admin_skill (id INT AUTO_INCREMENT NOT NULL, personal_information_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_B3A702094848E76E (personal_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_socials (id INT AUTO_INCREMENT NOT NULL, personal_information_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_907646C64848E76E (personal_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_roles (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_5BA4C8B91D775834 (value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_personnal_info (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_admin_skill ADD CONSTRAINT FK_B3A702094848E76E FOREIGN KEY (personal_information_id) REFERENCES cm_admin_personnal_info (id)');
        $this->addSql('ALTER TABLE cm_admin_socials ADD CONSTRAINT FK_907646C64848E76E FOREIGN KEY (personal_information_id) REFERENCES cm_admin_personnal_info (id)');
        $this->addSql('DROP TABLE cm_admin_moderator');
        $this->addSql('DROP TABLE cm_admin_redactor');
        $this->addSql('ALTER TABLE cm_admin_infoUser ADD personal_info INT DEFAULT NULL, DROP address');
        $this->addSql('ALTER TABLE cm_admin_infoUser ADD CONSTRAINT FK_FEB49276FA83366A FOREIGN KEY (personal_info) REFERENCES cm_admin_personnal_info (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FEB49276FA83366A ON cm_admin_infoUser (personal_info)');
        $this->addSql('ALTER TABLE cm_admin_administrator ADD role_id INT DEFAULT NULL, ADD creation_date DATE NOT NULL');
        $this->addSql('ALTER TABLE cm_admin_administrator ADD CONSTRAINT FK_EDCC2095D60322AC FOREIGN KEY (role_id) REFERENCES cm_admin_roles (id)');
        $this->addSql('CREATE INDEX IDX_EDCC2095D60322AC ON cm_admin_administrator (role_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_admin_administrator DROP FOREIGN KEY FK_EDCC2095D60322AC');
        $this->addSql('ALTER TABLE cm_admin_skill DROP FOREIGN KEY FK_B3A702094848E76E');
        $this->addSql('ALTER TABLE cm_admin_infoUser DROP FOREIGN KEY FK_FEB49276FA83366A');
        $this->addSql('ALTER TABLE cm_admin_socials DROP FOREIGN KEY FK_907646C64848E76E');
        $this->addSql('CREATE TABLE cm_admin_moderator (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email_back VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_19AA3580F85E0677 (username), UNIQUE INDEX UNIQ_19AA3580E7927C74 (email), UNIQUE INDEX UNIQ_19AA3580F2F8E1B2 (email_back), INDEX IDX_19AA358025ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_admin_redactor (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email_back VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_57AADE9F85E0677 (username), UNIQUE INDEX UNIQ_57AADE9E7927C74 (email), UNIQUE INDEX UNIQ_57AADE9F2F8E1B2 (email_back), INDEX IDX_57AADE925ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_admin_moderator ADD CONSTRAINT FK_19AA358025ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
        $this->addSql('ALTER TABLE cm_admin_redactor ADD CONSTRAINT FK_57AADE925ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
        $this->addSql('DROP TABLE cm_admin_skill');
        $this->addSql('DROP TABLE cm_admin_socials');
        $this->addSql('DROP TABLE cm_admin_roles');
        $this->addSql('DROP TABLE cm_admin_personnal_info');
        $this->addSql('DROP INDEX IDX_EDCC2095D60322AC ON cm_admin_administrator');
        $this->addSql('ALTER TABLE cm_admin_administrator DROP role_id, DROP creation_date');
        $this->addSql('DROP INDEX UNIQ_FEB49276FA83366A ON cm_admin_infoUser');
        $this->addSql('ALTER TABLE cm_admin_infoUser ADD address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP personal_info');
    }
}
