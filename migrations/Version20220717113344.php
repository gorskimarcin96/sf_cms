<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717113344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added "anniversary" table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE anniversary_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE anniversary (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3E2A99AFA76ED395 ON anniversary (user_id)');
        $this->addSql('ALTER TABLE anniversary ADD CONSTRAINT FK_3E2A99AFA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE anniversary_id_seq CASCADE');
        $this->addSql('DROP TABLE anniversary');
    }
}
