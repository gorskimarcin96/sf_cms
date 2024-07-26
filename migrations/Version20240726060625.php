<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240726060625 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO \"user\" (id, email) VALUES (1, 'gorskimarcin96@gmail.com');");
        $this->addSql(file_get_contents(__DIR__.'/slider.sql'));
        $this->addSql(file_get_contents(__DIR__.'/slider_translation.sql'));
        $this->addSql(file_get_contents(__DIR__.'/article.sql'));
        $this->addSql(file_get_contents(__DIR__.'/article_translation.sql'));
        $this->addSql(file_get_contents(__DIR__.'/realization.sql'));
        $this->addSql(file_get_contents(__DIR__.'/realization_translation.sql'));
    }
}
