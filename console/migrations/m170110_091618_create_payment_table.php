<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m170110_091618_create_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(5)->notNull(),
            'invoice_id' => $this->integer(5)->notNull(),
            'payment_date' => $this->date()->notNull(),
            'payment_time' => $this->time()->notNull(),
            'amount' => $this->double(10,2)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment');
    }
}
