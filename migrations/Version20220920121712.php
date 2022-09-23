<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920121712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules ADD id INT AUTO_INCREMENT NOT NULL, CHANGE partenaire_id partenaire_id INT DEFAULT NULL, CHANGE module_id module_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules DROP id, CHANGE partenaire_id partenaire_id INT NOT NULL, CHANGE module_id module_id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD PRIMARY KEY (partenaire_id, module_id)');
    }
}
