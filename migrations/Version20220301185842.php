<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301185842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create dog_joke table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE dog_joke_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dog_joke (id INT NOT NULL, url VARCHAR(255) NOT NULL, image VARCHAR(500) NOT NULL, width INT NOT NULL, height INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F0E961DF47645AE ON dog_joke (url)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F0E961DC53D045F ON dog_joke (image)');
        $this->addSql(file_get_contents(__dir__ . '/dog_jokes.sql'));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE dog_joke_id_seq CASCADE');
        $this->addSql('DROP TABLE dog_joke');
    }
}
