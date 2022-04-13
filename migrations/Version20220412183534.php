<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added task table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE task (id INT NOT NULL, user_id INT NOT NULL, class VARCHAR(255) NOT NULL, executed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, arguments JSON NOT NULL, is_added BOOLEAN NOT NULL, has_error BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE SEQUENCE task_id_seq');
        $this->addSql('SELECT setval(\'task_id_seq\', (SELECT MAX(id) FROM task))');
        $this->addSql('ALTER TABLE task ALTER id SET DEFAULT nextval(\'task_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25A76ED395');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP TABLE task');
    }
}
