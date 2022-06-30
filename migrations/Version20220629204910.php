<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629204910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added dog_joke data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(file_get_contents(__dir__ . '/dog_jokes_3.sql'));
        $this->addSql('SELECT setval(\'dog_joke_id_seq\', (SELECT MAX(id) FROM dog_joke))');
        $this->addSql('ALTER TABLE dog_joke ALTER id SET DEFAULT nextval(\'dog_joke_id_seq\')');
    }

    public function down(Schema $schema): void
    {

    }
}
