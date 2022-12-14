<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214145950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_list_by_user ADD computers_id INT DEFAULT NULL, ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce_list_by_user ADD CONSTRAINT FK_81A4A15EF4B903A6 FOREIGN KEY (computers_id) REFERENCES computer (id)');
        $this->addSql('ALTER TABLE annonce_list_by_user ADD CONSTRAINT FK_81A4A15E67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_81A4A15EF4B903A6 ON annonce_list_by_user (computers_id)');
        $this->addSql('CREATE INDEX IDX_81A4A15E67B3B43D ON annonce_list_by_user (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_list_by_user DROP FOREIGN KEY FK_81A4A15EF4B903A6');
        $this->addSql('ALTER TABLE annonce_list_by_user DROP FOREIGN KEY FK_81A4A15E67B3B43D');
        $this->addSql('DROP INDEX IDX_81A4A15EF4B903A6 ON annonce_list_by_user');
        $this->addSql('DROP INDEX IDX_81A4A15E67B3B43D ON annonce_list_by_user');
        $this->addSql('ALTER TABLE annonce_list_by_user DROP computers_id, DROP users_id');
    }
}
