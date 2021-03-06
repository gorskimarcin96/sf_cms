<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added todo tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE todo_list_user_access (todo_list_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(todo_list_id, user_id))');
        $this->addSql('CREATE TABLE todo_task (id INT NOT NULL, user_id INT DEFAULT NULL, todo_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, is_done BOOLEAN NOT NULL, file_fn VARCHAR(255), created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE todo_list (id INT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_done BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B199E07A76ED395 ON todo_list (user_id)');
        $this->addSql('CREATE INDEX IDX_3751C7C4E8A7DCFA ON todo_list_user_access (todo_list_id)');
        $this->addSql('CREATE INDEX IDX_3751C7C4A76ED395 ON todo_list_user_access (user_id)');
        $this->addSql('CREATE INDEX IDX_DAFBD3AA76ED395 ON todo_task (user_id)');
        $this->addSql('CREATE INDEX IDX_DAFBD3AE8A7DCFA ON todo_task (todo_list_id)');
        $this->addSql('ALTER TABLE todo_list ADD CONSTRAINT FK_1B199E07A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_list_user_access ADD CONSTRAINT FK_3751C7C4E8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_list_user_access ADD CONSTRAINT FK_3751C7C4A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_task ADD CONSTRAINT FK_DAFBD3AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_task ADD CONSTRAINT FK_DAFBD3AE8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE SEQUENCE todo_list_id_seq');
        $this->addSql('SELECT setval(\'todo_list_id_seq\', null)');
        $this->addSql('ALTER TABLE todo_list ALTER id SET DEFAULT nextval(\'todo_list_id_seq\')');
        $this->addSql('CREATE SEQUENCE todo_task_id_seq');
        $this->addSql('SELECT setval(\'todo_task_id_seq\', null)');
        $this->addSql('ALTER TABLE todo_task ALTER id SET DEFAULT nextval(\'todo_task_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE todo_list_user_access DROP CONSTRAINT FK_3751C7C4E8A7DCFA');
        $this->addSql('ALTER TABLE todo_task DROP CONSTRAINT FK_DAFBD3AE8A7DCFA');
        $this->addSql('ALTER TABLE todo_list DROP CONSTRAINT FK_1B199E07A76ED395');
        $this->addSql('ALTER TABLE todo_list_user_access DROP CONSTRAINT FK_3751C7C4A76ED395');
        $this->addSql('ALTER TABLE todo_task DROP CONSTRAINT FK_DAFBD3AA76ED395');
        $this->addSql('DROP SEQUENCE todo_list_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE todo_task_id_seq CASCADE');
        $this->addSql('DROP TABLE todo_list');
        $this->addSql('DROP TABLE todo_list_user_access');
        $this->addSql('DROP TABLE todo_task');
    }
}
