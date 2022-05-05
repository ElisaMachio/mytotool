<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505212606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE firstname_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE todo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE todo_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE firstname (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE todo (id INT NOT NULL, todo_list_id INT NOT NULL, value VARCHAR(255) NOT NULL, is_done BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A0EB6A0E8A7DCFA ON todo (todo_list_id)');
        $this->addSql('CREATE TABLE todo_list (id INT NOT NULL, owner_id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B199E077E3C61F9 ON todo_list (owner_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0E8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_list ADD CONSTRAINT FK_1B199E077E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE todo DROP CONSTRAINT FK_5A0EB6A0E8A7DCFA');
        $this->addSql('ALTER TABLE todo_list DROP CONSTRAINT FK_1B199E077E3C61F9');
        $this->addSql('DROP SEQUENCE firstname_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE todo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE todo_list_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE firstname');
        $this->addSql('DROP TABLE todo');
        $this->addSql('DROP TABLE todo_list');
        $this->addSql('DROP TABLE "user"');
    }
}
