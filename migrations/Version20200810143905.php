<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810143905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actions (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_548F1EFB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, profil_de_sortie_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C4EB462EA76ED395 (user_id), INDEX IDX_C4EB462E65E0C4D3 (profil_de_sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences_groupes_de_competences (competences_id INT NOT NULL, groupes_de_competences_id INT NOT NULL, INDEX IDX_921877E4A660B158 (competences_id), INDEX IDX_921877E4F8F36872 (groupes_de_competences_id), PRIMARY KEY(competences_id, groupes_de_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_de_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_de_tag_tag (groupe_de_tag_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_86A22ADEF194E202 (groupe_de_tag_id), INDEX IDX_86A22ADEBAD26311 (tag_id), PRIMARY KEY(groupe_de_tag_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupes_de_competences (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, criter_d_evaluation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_competences (niveau_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_3EA14545B3E9C81 (niveau_id), INDEX IDX_3EA14545A660B158 (competences_id), PRIMARY KEY(niveau_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archives TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_de_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archives TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_groupes_de_competences (tag_id INT NOT NULL, groupes_de_competences_id INT NOT NULL, INDEX IDX_B5A0AB83BAD26311 (tag_id), INDEX IDX_B5A0AB83F8F36872 (groupes_de_competences_id), PRIMARY KEY(tag_id, groupes_de_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, archives TINYINT(1) NOT NULL, photo LONGBLOB NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actions ADD CONSTRAINT FK_548F1EFB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462E65E0C4D3 FOREIGN KEY (profil_de_sortie_id) REFERENCES profil_de_sortie (id)');
        $this->addSql('ALTER TABLE competences_groupes_de_competences ADD CONSTRAINT FK_921877E4A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competences_groupes_de_competences ADD CONSTRAINT FK_921877E4F8F36872 FOREIGN KEY (groupes_de_competences_id) REFERENCES groupes_de_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_de_tag_tag ADD CONSTRAINT FK_86A22ADEF194E202 FOREIGN KEY (groupe_de_tag_id) REFERENCES groupe_de_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_de_tag_tag ADD CONSTRAINT FK_86A22ADEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competences ADD CONSTRAINT FK_3EA14545B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competences ADD CONSTRAINT FK_3EA14545A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupes_de_competences ADD CONSTRAINT FK_B5A0AB83BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupes_de_competences ADD CONSTRAINT FK_B5A0AB83F8F36872 FOREIGN KEY (groupes_de_competences_id) REFERENCES groupes_de_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences_groupes_de_competences DROP FOREIGN KEY FK_921877E4A660B158');
        $this->addSql('ALTER TABLE niveau_competences DROP FOREIGN KEY FK_3EA14545A660B158');
        $this->addSql('ALTER TABLE groupe_de_tag_tag DROP FOREIGN KEY FK_86A22ADEF194E202');
        $this->addSql('ALTER TABLE competences_groupes_de_competences DROP FOREIGN KEY FK_921877E4F8F36872');
        $this->addSql('ALTER TABLE tag_groupes_de_competences DROP FOREIGN KEY FK_B5A0AB83F8F36872');
        $this->addSql('ALTER TABLE actions DROP FOREIGN KEY FK_548F1EFB3E9C81');
        $this->addSql('ALTER TABLE niveau_competences DROP FOREIGN KEY FK_3EA14545B3E9C81');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462E65E0C4D3');
        $this->addSql('ALTER TABLE groupe_de_tag_tag DROP FOREIGN KEY FK_86A22ADEBAD26311');
        $this->addSql('ALTER TABLE tag_groupes_de_competences DROP FOREIGN KEY FK_B5A0AB83BAD26311');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EA76ED395');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE competences_groupes_de_competences');
        $this->addSql('DROP TABLE groupe_de_tag');
        $this->addSql('DROP TABLE groupe_de_tag_tag');
        $this->addSql('DROP TABLE groupes_de_competences');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_competences');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_de_sortie');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_groupes_de_competences');
        $this->addSql('DROP TABLE user');
    }
}
