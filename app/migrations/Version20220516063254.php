<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516063254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY bookings_ibfk_1');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY bookings_ibfk_2');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY bookings_ibfk_3');
        $this->addSql('ALTER TABLE bookings CHANGE currency_id currency_id BIGINT UNSIGNED DEFAULT NULL, CHANGE tax_id tax_id BIGINT UNSIGNED DEFAULT NULL, CHANGE room_id room_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35B2A824D8 FOREIGN KEY (tax_id) REFERENCES taxes (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3538248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3554177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A853C355550C4ED ON bookings (pid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D11BCB27F8F253B ON guests (dni)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D11BCB2E7927C74 ON guests (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D11BCB277D9AAA4 ON guests (phone_1)');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY guests_bookings_ibfk_1');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY guests_bookings_ibfk_2');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY guests_bookings_ibfk_3');
        $this->addSql('ALTER TABLE guests_bookings CHANGE guest_id guest_id BIGINT UNSIGNED DEFAULT NULL, CHANGE booking_id booking_id BIGINT UNSIGNED DEFAULT NULL, CHANGE room_id room_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT FK_C1E1DC6E9A4AA658 FOREIGN KEY (guest_id) REFERENCES guests (id)');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT FK_C1E1DC6E3301C60 FOREIGN KEY (booking_id) REFERENCES bookings (id)');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT FK_C1E1DC6E54177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY rooms_ibfk_1');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY rooms_ibfk_2');
        $this->addSql('ALTER TABLE rooms CHANGE currency_id currency_id BIGINT UNSIGNED DEFAULT NULL, CHANGE tax_id tax_id BIGINT UNSIGNED DEFAULT NULL, CHANGE availability availability LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A96B2A824D8 FOREIGN KEY (tax_id) REFERENCES taxes (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A9638248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id BIGINT UNSIGNED NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, surname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, password VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, rol LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'guest\' NOT NULL COLLATE `utf8mb4_0900_ai_ci` COMMENT \'(DC2Type:simple_array)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT CURRENT_TIMESTAMP, phone_1 INT NOT NULL, int_call_code INT NOT NULL, country VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, city TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, postal_code INT DEFAULT NULL, birthday DATE DEFAULT NULL) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C35B2A824D8');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C3538248176');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C3554177093');
        $this->addSql('DROP INDEX UNIQ_7A853C355550C4ED ON bookings');
        $this->addSql('ALTER TABLE bookings CHANGE room_id room_id BIGINT UNSIGNED NOT NULL, CHANGE tax_id tax_id BIGINT UNSIGNED NOT NULL, CHANGE currency_id currency_id BIGINT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT bookings_ibfk_1 FOREIGN KEY (tax_id) REFERENCES taxes (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT bookings_ibfk_2 FOREIGN KEY (currency_id) REFERENCES currencies (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT bookings_ibfk_3 FOREIGN KEY (room_id) REFERENCES rooms (id) ON UPDATE CASCADE');
        $this->addSql('DROP INDEX UNIQ_4D11BCB27F8F253B ON guests');
        $this->addSql('DROP INDEX UNIQ_4D11BCB2E7927C74 ON guests');
        $this->addSql('DROP INDEX UNIQ_4D11BCB277D9AAA4 ON guests');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY FK_C1E1DC6E9A4AA658');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY FK_C1E1DC6E3301C60');
        $this->addSql('ALTER TABLE guests_bookings DROP FOREIGN KEY FK_C1E1DC6E54177093');
        $this->addSql('ALTER TABLE guests_bookings CHANGE guest_id guest_id BIGINT UNSIGNED NOT NULL, CHANGE booking_id booking_id BIGINT UNSIGNED NOT NULL, CHANGE room_id room_id BIGINT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT guests_bookings_ibfk_1 FOREIGN KEY (guest_id) REFERENCES guests (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT guests_bookings_ibfk_2 FOREIGN KEY (booking_id) REFERENCES bookings (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE guests_bookings ADD CONSTRAINT guests_bookings_ibfk_3 FOREIGN KEY (room_id) REFERENCES rooms (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A96B2A824D8');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A9638248176');
        $this->addSql('ALTER TABLE rooms CHANGE tax_id tax_id BIGINT UNSIGNED NOT NULL, CHANGE currency_id currency_id BIGINT UNSIGNED NOT NULL, CHANGE availability availability LONGTEXT DEFAULT \'0\' NOT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT rooms_ibfk_1 FOREIGN KEY (tax_id) REFERENCES taxes (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT rooms_ibfk_2 FOREIGN KEY (currency_id) REFERENCES currencies (id) ON UPDATE CASCADE');
    }
}
