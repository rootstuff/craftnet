<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180724_195341_create_partners_tables migration.
 */
class m180724_195341_create_partners_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('craftnet_partners', [
            'id' => $this->integer()->notNull(),
            'ownerId' => $this->integer()->notNull(),
            'businessName' => $this->string(),
            'primaryContactName' => $this->string(),
            'primaryContactEmail' => $this->string(),
            'primaryContactPhone' => $this->string(),
            'businessSummary' => $this->text(),
            'minimumBudget' => $this->integer(),
            'msaLink' => $this->text(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
            'PRIMARY KEY(id)',
        ]);

        // Sizes ---------------------------------------------------------------

        // Holds available options
        $this->createTable('craftnet_partnersizes', [
            'id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'PRIMARY KEY(id)',
        ]);

        $this->batchInsert('craftnet_partnersizes', ['id', 'title'], [
            [1, 'Boutique'],
            [2, 'Agency'],
            [3, 'Large Agency'],
        ], false);

        // Join table
        $this->createTable('craftnet_partners_partnersizes', [
            'partnerId' => $this->integer()->notNull(),
            'partnerSizesId' => $this->integer()->notNull(),
            'PRIMARY KEY([[partnerId]], [[partnerSizesId]])',
        ]);

        $this->addForeignKey('craftnet_partners_partnersizes_partnerId_fk', 'craftnet_partners_partnersizes', ['partnerId'], 'craftnet_partners', ['id'], 'CASCADE');

        // Capabilities --------------------------------------------------------

        $this->createTable('craftnet_partnercapabilities', [
            'id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'PRIMARY KEY(id)',
        ]);

        $this->batchInsert('craftnet_partnercapabilities', ['id', 'title'], [
            [1, 'Commerce'],
            [2, 'Full Service'],
            [3, 'Custom Development'],
            [4, 'Contract Work'],
        ], false);

        $this->createTable('craftnet_partners_partnercapabilities', [
            'partnerId' => $this->integer()->notNull(),
            'partnercapabilitiesId' => $this->integer()->notNull(),
            'PRIMARY KEY([[partnerId]], [[partnercapabilitiesId]])',
        ]);

        $this->addForeignKey('partners_capabilities_partnerId_fk', 'craftnet_partners_partnercapabilities', ['partnerId'], 'craftnet_partners', ['id'], 'CASCADE');
        $this->addForeignKey('partners_capabilities_partnercapabilitiesId_fk', 'craftnet_partners_partnercapabilities', ['partnercapabilitiesId'], 'craftnet_partners', ['id'], 'CASCADE');

        // Locations -----------------------------------------------------------

        $this->createTable('craftnet_partnerlocations', [
            'id' => $this->integer()->notNull(),
            'partnerId' => $this->integer()->notNull(),
            'title' => $this->string(),
            'addressLine1' => $this->string(),
            'addressLine2' => $this->string(),
            'city' => $this->string(),
            'state' => $this->string(),
            'zip' => $this->string(),
            'country' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
            'PRIMARY KEY(id)',
        ]);

        $this->addForeignKey('craftnet_partnerlocations_partnerId_fk', 'craftnet_partnerlocations', ['partnerId'], 'craftnet_partners', ['id'], 'CASCADE');

        // Sites ---------------------------------------------------------------

        $this->createTable('craftnet_partnersites', [
            'id' => $this->integer()->notNull(),
            'partnerId' => $this->integer()->notNull(),
            'url' => $this->integer()->notNull(),
            'screenshotId' => $this->integer(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
            'PRIMARY KEY(id)',
        ]);

        $this->addForeignKey('craftnet_partnersites_partnerId_fk', 'craftnet_partnersites', ['partnerId'], 'craftnet_partners', ['id'], 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
//        echo "m180724_195341_create_partners_tables cannot be reverted.\n";
//        return false;

        // TODO: remove droptables when ready
        $this->dropTable('craftnet_partners_partnersizes');
        $this->dropTable('craftnet_partnersizes');
        $this->dropTable('craftnet_partners_partnercapabilities');
        $this->dropTable('craftnet_partnercapabilities');
        $this->dropTable('craftnet_partnerlocations');
        $this->dropTable('craftnet_partnersites');
        $this->dropTable('craftnet_partners');
    }
}
