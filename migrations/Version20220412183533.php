<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added dog_joke table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE dog_joke (id INT NOT NULL, url VARCHAR(255) NOT NULL, image TEXT NOT NULL, width INT NOT NULL, height INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F0E961DF47645AE ON dog_joke (url)');

        $this->addSql(file_get_contents(__dir__ . '/dog_jokes.sql'));

        $this->addSql('CREATE SEQUENCE dog_joke_id_seq');
        $this->addSql('SELECT setval(\'dog_joke_id_seq\', (SELECT MAX(id) FROM dog_joke))');
        $this->addSql('ALTER TABLE dog_joke ALTER id SET DEFAULT nextval(\'dog_joke_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE dog_joke_id_seq CASCADE');
        $this->addSql('DROP TABLE dog_joke');
    }
}
