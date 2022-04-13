<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412183526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added user table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');

        $this->addSql('CREATE SEQUENCE user_id_seq');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');

        $this->addSql('INSERT INTO "user" ( email, roles, password) VALUES 
            ( \'gorskimarcin96@gmail.com\', \'["ROLE_ADMIN"]\', \'$2y$13$p5wIVn8Be/0zuT2cFG8SOO6deEyO670gbe5GfrfFq3X9ryjGdUumW\'),
            ( \'ola_2341@o2.pl\', \'["ROLE_USER"]\', \'$2y$13$xY83pZSQ60hUrWu7Mvf/TemysXYskiCsMB0o0JZfR1UYqLzcFvNWq\');
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE "user"');
    }
}
