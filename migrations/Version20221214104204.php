<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214104204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer ADD author_id INT DEFAULT NULL, ADD brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE computer ADD CONSTRAINT FK_A298A7A6F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE computer ADD CONSTRAINT FK_A298A7A644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_A298A7A6F675F31B ON computer (author_id)');
        $this->addSql('CREATE INDEX IDX_A298A7A644F5D008 ON computer (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer DROP FOREIGN KEY FK_A298A7A6F675F31B');
        $this->addSql('ALTER TABLE computer DROP FOREIGN KEY FK_A298A7A644F5D008');
        $this->addSql('DROP INDEX IDX_A298A7A6F675F31B ON computer');
        $this->addSql('DROP INDEX IDX_A298A7A644F5D008 ON computer');
        $this->addSql('ALTER TABLE computer DROP author_id, DROP brand_id');
    }
}
