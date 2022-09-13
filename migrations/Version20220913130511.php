<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913130511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaire_modules (partenaire_id INT NOT NULL, modules_id INT NOT NULL, INDEX IDX_3146BD0098DE13AC (partenaire_id), INDEX IDX_3146BD0060D6DC42 (modules_id), PRIMARY KEY(partenaire_id, modules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire_modules ADD CONSTRAINT FK_3146BD0098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaire_modules ADD CONSTRAINT FK_3146BD0060D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_modules DROP FOREIGN KEY FK_3146BD0098DE13AC');
        $this->addSql('ALTER TABLE partenaire_modules DROP FOREIGN KEY FK_3146BD0060D6DC42');
        $this->addSql('DROP TABLE partenaire_modules');
    }
}
