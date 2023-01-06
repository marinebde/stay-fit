<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118100233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E62534008B');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E62534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E62534008B');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E62534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
    }
}
