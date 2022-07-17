<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314224436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD news_uuid UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN image.news_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4A2A62D FOREIGN KEY (news_uuid) REFERENCES news (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C53D045F4A2A62D ON image (news_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F4A2A62D');
        $this->addSql('DROP INDEX IDX_C53D045F4A2A62D');
        $this->addSql('ALTER TABLE image DROP news_uuid');
    }
}
