<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211128194705 extends AbstractMigration
{
    public const TABLES = [
        'article', 'constant', 'counter', 'cron_job', 'cron_report', 'messenger_messages', 'offer', 'position',
        'realization', 'slider', 'user'
    ];

    public function getDescription(): string
    {
        return 'Fixed all autoincrement.';
    }

    public function up(Schema $schema): void
    {
        foreach (self::TABLES as $table) {
            $this->addSql(sprintf('SELECT setval(\'%s_id_seq\', (SELECT MAX(id) FROM "%s")+1);', $table, $table));
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
