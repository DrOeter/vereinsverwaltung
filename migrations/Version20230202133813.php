<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202133813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_activity ADD account_id INT NOT NULL');
        $this->addSql('ALTER TABLE account_activity ADD CONSTRAINT FK_D4BAEBEC9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_D4BAEBEC9B6B5FBA ON account_activity (account_id)');
        $this->addSql('ALTER TABLE user ADD account_id INT DEFAULT NULL, ADD sepa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FB9DE7AA FOREIGN KEY (sepa_id) REFERENCES sepa (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499B6B5FBA ON user (account_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649FB9DE7AA ON user (sepa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499B6B5FBA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FB9DE7AA');
        $this->addSql('DROP INDEX UNIQ_8D93D6499B6B5FBA ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649FB9DE7AA ON user');
        $this->addSql('ALTER TABLE user DROP account_id, DROP sepa_id');
        $this->addSql('ALTER TABLE account_activity DROP FOREIGN KEY FK_D4BAEBEC9B6B5FBA');
        $this->addSql('DROP INDEX IDX_D4BAEBEC9B6B5FBA ON account_activity');
        $this->addSql('ALTER TABLE account_activity DROP account_id');
    }
}
