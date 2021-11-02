<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104213417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE position (id INT NOT NULL, title VARCHAR(255) NOT NULL, image TEXT NOT NULL, first_section TEXT NOT NULL, second_section TEXT NOT NULL, PRIMARY KEY(id))');;
        $this->addSql(file_get_contents(__dir__ . '/positions.sql'));
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE position');
    }
}
