<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920092920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules ADD modules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659460D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id)');
        $this->addSql('CREATE INDEX IDX_2692659460D6DC42 ON partenaires_modules (modules_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659460D6DC42');
        $this->addSql('DROP INDEX IDX_2692659460D6DC42 ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules DROP modules_id');
    }
}
