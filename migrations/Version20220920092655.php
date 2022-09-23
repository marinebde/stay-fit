<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920092655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_26926594B6A7DFED');
        $this->addSql('DROP INDEX IDX_26926594B6A7DFED ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules CHANGE partenaire_id_id partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659498DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_2692659498DE13AC ON partenaires_modules (partenaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659498DE13AC');
        $this->addSql('DROP INDEX IDX_2692659498DE13AC ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules CHANGE partenaire_id partenaire_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_26926594B6A7DFED FOREIGN KEY (partenaire_id_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_26926594B6A7DFED ON partenaires_modules (partenaire_id_id)');
    }
}
