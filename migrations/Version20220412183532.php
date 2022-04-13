<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added position table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE position (id INT NOT NULL, title VARCHAR(255) NOT NULL, image TEXT NOT NULL, first_section TEXT NOT NULL, second_section TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql(file_get_contents(__dir__ . '/positions.sql'));

        $this->addSql('CREATE SEQUENCE position_id_seq');
        $this->addSql('SELECT setval(\'position_id_seq\', (SELECT MAX(id) FROM position))');
        $this->addSql('ALTER TABLE position ALTER id SET DEFAULT nextval(\'position_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('DROP TABLE position');
    }
}
