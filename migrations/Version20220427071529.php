<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
//final class Version20220427071529 extends AbstractMigration
//{
//    public function getDescription(): string
//    {
//        return '';
//    }
//
//    public function up(Schema $schema): void
//    {
//        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TABLE enum_priorite (id INT AUTO_INCREMENT NOT NULL, priorite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//        $this->addSql('ALTER TABLE ticket ADD priorite_id INT NOT NULL');
//        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA353B4F1DE FOREIGN KEY (priorite_id) REFERENCES enum_priorite (id)');
//        $this->addSql('CREATE INDEX IDX_97A0ADA353B4F1DE ON ticket (priorite_id)');
//    }
//
//    public function down(Schema $schema): void
//    {
//        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA353B4F1DE');
//        $this->addSql('DROP TABLE enum_priorite');
//        $this->addSql('DROP INDEX IDX_97A0ADA353B4F1DE ON ticket');
//        $this->addSql('ALTER TABLE ticket DROP priorite_id');
//    }
//}
