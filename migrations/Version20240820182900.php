<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240820182900 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE counter (id SERIAL NOT NULL, session_id VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, url VARCHAR(1000) NOT NULL, refresh INT NOT NULL, entry INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE counter');
    }
}
