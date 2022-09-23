<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920213837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659460D6DC42');
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659498DE13AC');
        $this->addSql('DROP TABLE partenaires_modules');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaires_modules (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, modules_id INT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_2692659498DE13AC (partenaire_id), INDEX IDX_2692659460D6DC42 (modules_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659460D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id)');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659498DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
    }
}
