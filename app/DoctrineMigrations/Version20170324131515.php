<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170324131515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_chal_challenge_solution (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_chal_challenge_resource (id INT AUTO_INCREMENT NOT NULL, uploaded_by_id INT NOT NULL, challenge_id INT NOT NULL, resource_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4D096F95103DEBC (resource_name), INDEX IDX_4D096F9A2B28FE8 (uploaded_by_id), INDEX IDX_4D096F998A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_chal_challenge_resource ADD CONSTRAINT FK_4D096F9A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES cm_admin_administrator (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge_resource ADD CONSTRAINT FK_4D096F998A21AC6 FOREIGN KEY (challenge_id) REFERENCES cm_chal_challenge (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge ADD solution_id INT NOT NULL, DROP solution');
        $this->addSql('ALTER TABLE cm_chal_challenge ADD CONSTRAINT FK_37E0D2251C0BE183 FOREIGN KEY (solution_id) REFERENCES cm_chal_challenge_solution (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37E0D2251C0BE183 ON cm_chal_challenge (solution_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_chal_challenge DROP FOREIGN KEY FK_37E0D2251C0BE183');
        $this->addSql('DROP TABLE cm_chal_challenge_solution');
        $this->addSql('DROP TABLE cm_chal_challenge_resource');
        $this->addSql('DROP INDEX UNIQ_37E0D2251C0BE183 ON cm_chal_challenge');
        $this->addSql('ALTER TABLE cm_chal_challenge ADD solution VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP solution_id');
    }
}
