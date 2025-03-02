<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302092645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review ADD instructor_id INT DEFAULT NULL, CHANGE course_id course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68C4FC193 FOREIGN KEY (instructor_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_794381C68C4FC193 ON review (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68C4FC193');
        $this->addSql('DROP INDEX IDX_794381C68C4FC193 ON review');
        $this->addSql('ALTER TABLE review DROP instructor_id, CHANGE course_id course_id INT NOT NULL');
    }
}
