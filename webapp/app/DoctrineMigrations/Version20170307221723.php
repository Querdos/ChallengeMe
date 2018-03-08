<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170307221723 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_admin_private_message (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, recipient_id INT DEFAULT NULL, content LONGTEXT NOT NULL, sent DATETIME NOT NULL, INDEX IDX_3ADFDE3FF675F31B (author_id), INDEX IDX_3ADFDE3FE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_chal_challenge (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, points INT NOT NULL, level INT NOT NULL, description VARCHAR(255) NOT NULL, statement LONGTEXT NOT NULL, created DATETIME NOT NULL, solution VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_37E0D2252B36786B (title), INDEX IDX_37E0D22512469DE2 (category_id), INDEX IDX_37E0D225F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm_cha_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_D436DF8F2B36786B (title), UNIQUE INDEX UNIQ_D436DF8F6DE44026 (description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_admin_private_message ADD CONSTRAINT FK_3ADFDE3FF675F31B FOREIGN KEY (author_id) REFERENCES cm_admin_administrator (id)');
        $this->addSql('ALTER TABLE cm_admin_private_message ADD CONSTRAINT FK_3ADFDE3FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES cm_admin_administrator (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge ADD CONSTRAINT FK_37E0D22512469DE2 FOREIGN KEY (category_id) REFERENCES cm_cha_category (id)');
        $this->addSql('ALTER TABLE cm_chal_challenge ADD CONSTRAINT FK_37E0D225F675F31B FOREIGN KEY (author_id) REFERENCES cm_admin_administrator (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_chal_challenge DROP FOREIGN KEY FK_37E0D22512469DE2');
        $this->addSql('DROP TABLE cm_admin_private_message');
        $this->addSql('DROP TABLE cm_chal_challenge');
        $this->addSql('DROP TABLE cm_cha_category');
    }
}
