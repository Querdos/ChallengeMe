<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170406145718 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
        $this->addSql('CREATE TABLE SCHEDULED_COMMAND (ID_SCHEDULED_COMMAND INT AUTO_INCREMENT NOT NULL, NAME VARCHAR(100) NOT NULL, COMMAND VARCHAR(100) NOT NULL, ARGUMENTS VARCHAR(250) DEFAULT NULL, CRON_EXPRESSION VARCHAR(100) DEFAULT NULL, DH_LAST_EXECUTION DATETIME NOT NULL, LAST_RETURN_CODE INT DEFAULT NULL, LOG_FILE VARCHAR(100) DEFAULT NULL, PRIORITY INT NOT NULL, B_EXECUTE_IMMEDIATELY TINYINT(1) NOT NULL, B_DISABLED TINYINT(1) NOT NULL, B_LOCKED TINYINT(1) NOT NULL, PRIMARY KEY(ID_SCHEDULED_COMMAND)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_user_password_token_reset (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, value VARCHAR(128) NOT NULL, expiration_date DATE NOT NULL, UNIQUE INDEX UNIQ_F117BB8D1D775834 (value), UNIQUE INDEX UNIQ_F117BB8D99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_user_password_token_reset ADD CONSTRAINT FK_F117BB8D99E6F5DF FOREIGN KEY (player_id) REFERENCES cm_user_player (id)');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
        $this->addSql('ALTER TABLE cm_user_player ADD enabled TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cron_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, command VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, schedule VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, UNIQUE INDEX un_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_report (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, run_at DATETIME NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output LONGTEXT NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_B6C6A7F5BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id)');
        $this->addSql('DROP TABLE SCHEDULED_COMMAND');
        $this->addSql('DROP TABLE cm_user_password_token_reset');
        $this->addSql('ALTER TABLE cm_user_player DROP enabled');
    }
}
