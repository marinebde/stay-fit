<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920224548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaire_module (id INT AUTO_INCREMENT NOT NULL, partenaires_id INT DEFAULT NULL, modules_id INT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_27599FFB38898CF5 (partenaires_id), INDEX IDX_27599FFB60D6DC42 (modules_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB38898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE partenaire_module ADD CONSTRAINT FK_27599FFB60D6DC42 FOREIGN KEY (modules_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB38898CF5');
        $this->addSql('ALTER TABLE partenaire_module DROP FOREIGN KEY FK_27599FFB60D6DC42');
        $this->addSql('DROP TABLE partenaire_module');
    }
}
