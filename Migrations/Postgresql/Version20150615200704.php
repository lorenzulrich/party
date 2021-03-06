<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Add the needed dtype columns to make ElectronicAddress and PersonName
 * extensible in userland code.
 */
class Version20150615200704 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql");
		
		$this->addSql("ALTER TABLE typo3_party_domain_model_electronicaddress ADD dtype VARCHAR(255) NULL");
		$this->addSql("UPDATE typo3_party_domain_model_electronicaddress SET dtype = 'typo3_party_electronicaddress' WHERE dtype IS NULL");
		$this->addSql("ALTER TABLE typo3_party_domain_model_electronicaddress ALTER COLUMN dtype SET NOT NULL");
		$this->addSql("ALTER TABLE typo3_party_domain_model_personname ADD dtype VARCHAR(255) NULL");
		$this->addSql("UPDATE typo3_party_domain_model_personname SET dtype = 'typo3_party_personname' WHERE dtype IS NULL");
		$this->addSql("ALTER TABLE typo3_party_domain_model_personname ALTER COLUMN dtype SET NOT NULL");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql");
		
		$this->addSql("ALTER TABLE typo3_party_domain_model_personname DROP dtype");
		$this->addSql("ALTER TABLE typo3_party_domain_model_electronicaddress DROP dtype");
	}
}