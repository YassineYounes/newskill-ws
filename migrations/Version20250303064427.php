<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303064427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD logo VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68C4FC193');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68C4FC193 FOREIGN KEY (instructor_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP logo');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68C4FC193');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68C4FC193 FOREIGN KEY (instructor_id) REFERENCES course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
