<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101085852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added mailer apelinia to crond_job.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO cron_job (id, name, command, schedule, description, enabled) VALUES (2, \'cron 2\', \'app:mailer:apelinia mgorski.dev@gmail.com ola_2341@o2.pl\', \'0 2 * * *\', \'\', true);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM cron_job WHERE id=2');
    }
}
