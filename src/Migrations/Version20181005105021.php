<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181005105021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('
            CREATE TABLE addressbook (
            id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, 
            Firstname VARCHAR(255) NOT NULL, 
            Lastname VARCHAR(255) NOT NULL, 
            Street_and_number TEXT NOT NULL, 
            Zip INT(11) NOT NULL, 
            City VARCHAR(255) NOT NULL, 
            Country VARCHAR(255) NOT NULL, 
            Phonenumber TEXT NOT NULL, 
            Email_address VARCHAR(255) UNIQUE NOT NULL, 
            Picture TEXT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER 
            SET UTF8 COLLATE utf8_general_ci ENGINE = InnoDB
            ');
    }



    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE addressbook');

    }
}
