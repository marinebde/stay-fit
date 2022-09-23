<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920092510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_modules DROP FOREIGN KEY FK_3146BD0060D6DC42');
        $this->addSql('ALTER TABLE partenaire_modules DROP FOREIGN KEY FK_3146BD0098DE13AC');
        $this->addSql('DROP TABLE partenaire_modules');
        $this->addSql('ALTER TABLE partenaires_modules ADD partenaire_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_26926594B6A7DFED FOREIGN KEY (partenaire_id_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_26926594B6A7DFED ON partenaires_modules (partenaire_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaire_modules (partenaire_id INT NOT NULL, modules_id INT NOT NULL, INDEX IDX_3146BD0060D6DC42 (modules_id), INDEX IDX_3146BD0098DE13AC (partenaire_id), PRIMARY KEY(partenaire_id, modules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partenaire_modules ADD CONSTRAINT FK_3146BD0060D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_modules ADD CONSTRAINT FK_3146BD0098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_26926594B6A7DFED');
        $this->addSql('DROP INDEX IDX_26926594B6A7DFED ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules DROP partenaire_id_id');
    }
}
