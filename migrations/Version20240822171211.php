<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822171211 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cv (id SERIAL NOT NULL, type VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B66FFE928CDE5729 ON cv (type)');
        $this->addSql(file_get_contents(__DIR__.'/CV.sql'));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE cv');
    }
}
