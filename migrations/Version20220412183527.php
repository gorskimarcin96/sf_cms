<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added counter table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE counter (id INT NOT NULL, session_id VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, refresh INT NOT NULL, entry INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');

        $this->addSql(file_get_contents(__dir__ . '/counter_13_04_22.sql'));

        $this->addSql('CREATE SEQUENCE counter_id_seq');
        $this->addSql('SELECT setval(\'counter_id_seq\', (SELECT MAX(id) FROM counter))');
        $this->addSql('ALTER TABLE counter ALTER id SET DEFAULT nextval(\'counter_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE counter_id_seq CASCADE');
        $this->addSql('DROP TABLE counter');
    }
}
