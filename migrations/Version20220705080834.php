<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705080834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added position type and unique for title and type.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DELETE FROM "position" WHERE id in (SELECT MAX(id) FROM position group by title having count(title)>1)');
        $this->addSql('ALTER TABLE "position" ADD position_type VARCHAR(2) CHECK(position_type IN (\'O\', \'ZG\')) NOT NULL DEFAULT \'O\'');
        $this->addSql('ALTER TABLE "position" ALTER position_type DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "position".position_type IS \'(DC2Type:App\\DBAL\\Types\\PositionType)\'');
        $this->addSql('CREATE UNIQUE INDEX title_position_type ON "position" (title, position_type)');
        $this->addSql(file_get_contents(__dir__ . '/positions_2.sql'));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX title_position_type');
        $this->addSql('ALTER TABLE position DROP position_type');
    }
}
