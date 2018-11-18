<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181117062842 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project ADD priority INT NOT NULL, ADD subject TEXT NOT NULL, ADD description LONGTEXT NOT NULL, ADD start_date DATE NOT NULL, ADD done_ratio INT NOT NULL, ADD created_on DATETIME NOT NULL, ADD updated_on DATETIME NOT NULL, DROP title, DROP body');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project ADD title TINYTEXT NOT NULL COLLATE utf8mb4_unicode_ci, ADD body LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, DROP priority, DROP subject, DROP description, DROP start_date, DROP done_ratio, DROP created_on, DROP updated_on');
    }
}
