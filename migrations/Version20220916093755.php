<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916093755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD partenaires_id INT DEFAULT NULL, ADD structures_id INT DEFAULT NULL, DROP partenaires, DROP structures, CHANGE date_connexion date_connexion DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64938898CF5 FOREIGN KEY (partenaires_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D3ED38D FOREIGN KEY (structures_id) REFERENCES structure (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64938898CF5 ON user (partenaires_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499D3ED38D ON user (structures_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64938898CF5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D3ED38D');
        $this->addSql('DROP INDEX IDX_8D93D64938898CF5 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6499D3ED38D ON user');
        $this->addSql('ALTER TABLE user ADD partenaires VARCHAR(255) DEFAULT NULL, ADD structures VARCHAR(255) DEFAULT NULL, DROP partenaires_id, DROP structures_id, CHANGE date_connexion date_connexion DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
