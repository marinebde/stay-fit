<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920223806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(250) NOT NULL, statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659438898CF5');
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659460D6DC42');
        $this->addSql('DROP TABLE partenaires_modules');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaires_modules (id INT AUTO_INCREMENT NOT NULL, partenaires_id INT DEFAULT NULL, modules_id INT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_2692659438898CF5 (partenaires_id), INDEX IDX_2692659460D6DC42 (modules_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659438898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659460D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id)');
        $this->addSql('DROP TABLE module');
    }
}
