<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation_subtotal`.
 */
class m170103_072328_create_quotation_subtotal_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quotation_subtotal', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(10)->notNull(),
            'item_id' => $this->integer(10)->notNull(),
            'qty' => $this->integer(10)->notNull(),
            'price' => $this->double(10,2)->notNull(),
            'subTotal' => $this->double(10,2)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quotation_subtotal');
    }
}
