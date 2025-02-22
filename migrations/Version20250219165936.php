<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219165936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courses_categories (course_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_30ED10BD591CC992 (course_id), INDEX IDX_30ED10BD12469DE2 (category_id), PRIMARY KEY(course_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses_categories ADD CONSTRAINT FK_30ED10BD591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courses_categories ADD CONSTRAINT FK_30ED10BD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2');
        $this->addSql('DROP INDEX IDX_169E6FB912469DE2 ON course');
        $this->addSql('ALTER TABLE course DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses_categories DROP FOREIGN KEY FK_30ED10BD591CC992');
        $this->addSql('ALTER TABLE courses_categories DROP FOREIGN KEY FK_30ED10BD12469DE2');
        $this->addSql('DROP TABLE courses_categories');
        $this->addSql('ALTER TABLE course ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_169E6FB912469DE2 ON course (category_id)');
    }
}
