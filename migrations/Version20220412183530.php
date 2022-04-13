<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added realization table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE realization (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_fn VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CDAA30C6A76ED395 ON realization (user_id)');
        $this->addSql('ALTER TABLE realization ADD CONSTRAINT FK_CDAA30C6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('INSERT INTO realization (id, user_id, title, url, created_at, updated_at, file_fn) VALUES 
            (1, 1, \'MGorski\', \'https://mgorski.dev/\', \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\', \'mgorski.png\'),
            (2, 1, \'Psycholog Kraśnik\', \'http://www.psycholog-krasnik.pl/\', \'2021-08-18 20:00:00\', \'2021-08-18 20:00:00\', \'psychol.png\');'
        );

        $this->addSql('CREATE SEQUENCE realization_id_seq');
        $this->addSql('SELECT setval(\'realization_id_seq\', (SELECT MAX(id) FROM realization))');
        $this->addSql('ALTER TABLE realization ALTER id SET DEFAULT nextval(\'realization_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE realization DROP CONSTRAINT FK_CDAA30C6A76ED395');
        $this->addSql('DROP SEQUENCE realization_id_seq CASCADE');
        $this->addSql('DROP TABLE realization');
    }
}
