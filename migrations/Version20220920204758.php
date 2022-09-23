<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920204758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaires_modules_modules DROP FOREIGN KEY FK_3694160F60D6DC42');
        $this->addSql('ALTER TABLE partenaires_modules_modules DROP FOREIGN KEY FK_3694160F9AD0B8B0');
        $this->addSql('DROP TABLE partenaires_modules_modules');
        $this->addSql('ALTER TABLE partenaires_modules ADD modules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires_modules ADD CONSTRAINT FK_2692659460D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id)');
        $this->addSql('CREATE INDEX IDX_2692659460D6DC42 ON partenaires_modules (modules_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partenaires_modules_modules (partenaires_modules_id INT NOT NULL, modules_id INT NOT NULL, INDEX IDX_3694160F60D6DC42 (modules_id), INDEX IDX_3694160F9AD0B8B0 (partenaires_modules_id), PRIMARY KEY(partenaires_modules_id, modules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partenaires_modules_modules ADD CONSTRAINT FK_3694160F60D6DC42 FOREIGN KEY (modules_id) REFERENCES modules (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaires_modules_modules ADD CONSTRAINT FK_3694160F9AD0B8B0 FOREIGN KEY (partenaires_modules_id) REFERENCES partenaires_modules (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partenaires_modules DROP FOREIGN KEY FK_2692659460D6DC42');
        $this->addSql('DROP INDEX IDX_2692659460D6DC42 ON partenaires_modules');
        $this->addSql('ALTER TABLE partenaires_modules DROP modules_id');
    }
}
