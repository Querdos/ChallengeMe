<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170405134018 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_admin_dump_database (id INT AUTO_INCREMENT NOT NULL, dump_name VARCHAR(255) NOT NULL, dump_file_name VARCHAR(255) NOT NULL, dump_size INT NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A4572F2D27518216 (dump_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_player_player_activity (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_9C2D901599E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_player_team_activity (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_8E628A3B296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_player_player_activity ADD CONSTRAINT FK_9C2D901599E6F5DF FOREIGN KEY (player_id) REFERENCES cm_user_player (id)');
        $this->addSql('ALTER TABLE cm_player_team_activity ADD CONSTRAINT FK_8E628A3B296CD8AE FOREIGN KEY (team_id) REFERENCES cm_user_team (id)');
        $this->addSql('ALTER TABLE cm_admin_infoUser CHANGE birthday birthday DATE DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_B0FB7CDCF2F8E1B2 ON cm_user_player');
        $this->addSql('ALTER TABLE cm_user_player ADD blocked TINYINT(1) NOT NULL, CHANGE email_back email_back VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_37E0D2252B36786B ON cm_chal_challenge');
        $this->addSql('ALTER TABLE cm_chal_challenge_solving ADD duration INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cm_admin_dump_database');
        $this->addSql('DROP TABLE cm_player_player_activity');
        $this->addSql('DROP TABLE cm_player_team_activity');
        $this->addSql('ALTER TABLE cm_admin_infoUser CHANGE birthday birthday DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37E0D2252B36786B ON cm_chal_challenge (title)');
        $this->addSql('ALTER TABLE cm_chal_challenge_solving DROP duration');
        $this->addSql('ALTER TABLE cm_user_player DROP blocked, CHANGE email_back email_back VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0FB7CDCF2F8E1B2 ON cm_user_player (email_back)');
    }
}
