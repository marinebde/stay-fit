<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220917122127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE structure_modules (structure_id INT NOT NULL, modules_id INT NOT NULL, INDEX IDX_F51533E62534008B (structure_id), INDEX IDX_F51533E660D6DC42 (modules_id), PRIMARY KEY(structure_id, modules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E62534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structure_modules ADD CONSTRAINT FK_F51533E660D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E62534008B');
        $this->addSql('ALTER TABLE structure_modules DROP FOREIGN KEY FK_F51533E660D6DC42');
        $this->addSql('DROP TABLE structure_modules');
    }
}
