<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007095558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules ADD structure_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E6AA95C5C1 FOREIGN KEY (structure_id_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_F51533E6AA95C5C1 ON structure_modules (structure_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E6AA95C5C1');
        $this->addSql('DROP INDEX IDX_F51533E6AA95C5C1 ON structure_modules');
        $this->addSql('ALTER TABLE structure_modules DROP structure_id_id');
    }
}
