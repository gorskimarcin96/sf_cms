<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220123201357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added new user.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO "user" (id, email, roles, password) VALUES (2, \'ola_2341@o2.pl\', \'["ROLE_USER"]\', \'$2y$13$xY83pZSQ60hUrWu7Mvf/TemysXYskiCsMB0o0JZfR1UYqLzcFvNWq\');');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
    }
}

