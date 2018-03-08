<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170323170422 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_user_team (id INT AUTO_INCREMENT NOT NULL, leader INT NOT NULL, name VARCHAR(255) NOT NULL, points INT NOT NULL, created DATETIME NOT NULL, avatar_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_AF2E80155E237E06 (name), UNIQUE INDEX UNIQ_AF2E8015F5E3EAD7 (leader), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_user_player_role (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3AF44584296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_user_demand (id INT AUTO_INCREMENT NOT NULL, team INT NOT NULL, player INT NOT NULL, date DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_6A6F7FCAC4E0A61F (team), INDEX IDX_6A6F7FCA98197A65 (player), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_user_player (id INT AUTO_INCREMENT NOT NULL, info_user_id INT DEFAULT NULL, team_id INT DEFAULT NULL, player_role_id INT DEFAULT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_back VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, avatar_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B0FB7CDCF85E0677 (username), UNIQUE INDEX UNIQ_B0FB7CDCE7927C74 (email), UNIQUE INDEX UNIQ_B0FB7CDCF2F8E1B2 (email_back), INDEX IDX_B0FB7CDC25ABFA0B (info_user_id), INDEX IDX_B0FB7CDC296CD8AE (team_id), INDEX IDX_B0FB7CDCB7F7DDE9 (player_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_chal_challenge_solving (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, challenge_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_38B16F01296CD8AE (team_id), INDEX IDX_38B16F0198A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_chal_rating (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, challenge_id INT NOT NULL, mark INT NOT NULL, INDEX IDX_5DBB261999E6F5DF (player_id), INDEX IDX_5DBB261998A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_player_notification (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, content LONGTEXT NOT NULL, state TINYINT(1) NOT NULL, created DATETIME NOT NULL, INDEX IDX_54B8DF4B99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_user_team ADD CONSTRAINT FK_AF2E8015F5E3EAD7 FOREIGN KEY (leader) REFERENCES cm_user_player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cm_user_player_role ADD CONSTRAINT FK_3AF44584296CD8AE FOREIGN KEY (team_id) REFERENCES cm_user_team (id)');
        $this->addSql('ALTER TABLE cm_user_demand ADD CONSTRAINT FK_6A6F7FCAC4E0A61F FOREIGN KEY (team) REFERENCES cm_user_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cm_user_demand ADD CONSTRAINT FK_6A6F7FCA98197A65 FOREIGN KEY (player) REFERENCES cm_user_player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cm_user_player ADD CONSTRAINT FK_B0FB7CDC25ABFA0B FOREIGN KEY (info_user_id) REFERENCES cm_admin_infoUser (id)');
        $this->addSql('ALTER TABLE cm_user_player ADD CONSTRAINT FK_B0FB7CDC296CD8AE FOREIGN KEY (team_id) REFERENCES cm_user_team (id)');
        $this->addSql('ALTER TABLE cm_user_player ADD CONSTRAINT FK_B0FB7CDCB7F7DDE9 FOREIGN KEY (player_role_id) REFERENCES cm_user_player_role (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge_solving ADD CONSTRAINT FK_38B16F01296CD8AE FOREIGN KEY (team_id) REFERENCES cm_user_team (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge_solving ADD CONSTRAINT FK_38B16F0198A21AC6 FOREIGN KEY (challenge_id) REFERENCES cm_chal_challenge (id)');
        $this->addSql('ALTER TABLE cm_chal_rating ADD CONSTRAINT FK_5DBB261999E6F5DF FOREIGN KEY (player_id) REFERENCES cm_user_player (id)');
        $this->addSql('ALTER TABLE cm_chal_rating ADD CONSTRAINT FK_5DBB261998A21AC6 FOREIGN KEY (challenge_id) REFERENCES cm_chal_challenge (id)');
        $this->addSql('ALTER TABLE cm_player_notification ADD CONSTRAINT FK_54B8DF4B99E6F5DF FOREIGN KEY (player_id) REFERENCES cm_user_player (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_user_player_role DROP FOREIGN KEY FK_3AF44584296CD8AE');
        $this->addSql('ALTER TABLE cm_user_demand DROP FOREIGN KEY FK_6A6F7FCAC4E0A61F');
        $this->addSql('ALTER TABLE cm_user_player DROP FOREIGN KEY FK_B0FB7CDC296CD8AE');
        $this->addSql('ALTER TABLE cm_chal_challenge_solving DROP FOREIGN KEY FK_38B16F01296CD8AE');
        $this->addSql('ALTER TABLE cm_user_player DROP FOREIGN KEY FK_B0FB7CDCB7F7DDE9');
        $this->addSql('ALTER TABLE cm_user_team DROP FOREIGN KEY FK_AF2E8015F5E3EAD7');
        $this->addSql('ALTER TABLE cm_user_demand DROP FOREIGN KEY FK_6A6F7FCA98197A65');
        $this->addSql('ALTER TABLE cm_chal_rating DROP FOREIGN KEY FK_5DBB261999E6F5DF');
        $this->addSql('ALTER TABLE cm_player_notification DROP FOREIGN KEY FK_54B8DF4B99E6F5DF');
        $this->addSql('DROP TABLE cm_user_team');
        $this->addSql('DROP TABLE cm_user_player_role');
        $this->addSql('DROP TABLE cm_user_demand');
        $this->addSql('DROP TABLE cm_user_player');
        $this->addSql('DROP TABLE cm_chal_challenge_solving');
        $this->addSql('DROP TABLE cm_chal_rating');
        $this->addSql('DROP TABLE cm_player_notification');
    }
}
