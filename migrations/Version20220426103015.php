<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426103015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3D5E86FF FOREIGN KEY (etat_id) REFERENCES etat_ticket (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3D5E86FF ON ticket (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3D5E86FF');
        $this->addSql('DROP INDEX IDX_97A0ADA3D5E86FF ON ticket');
        $this->addSql('ALTER TABLE ticket DROP etat_id');
    }
}
