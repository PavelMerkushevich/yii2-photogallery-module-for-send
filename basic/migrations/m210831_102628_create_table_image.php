<?php

use yii\db\Migration;

/**
 * Class m210831_102628_create_table_image
 */
class m210831_102628_create_table_image extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'author' => $this->string(50),
            'category' => $this->string(50)->notNull(),
            'title' => $this->string(50)->notNull(),
            'date' => $this->string(50)->notNull(),
            'status' => $this->string(10)->notNull(),
            'extension' => $this->string(50)->notNull(),
            'image' => $this->string(50)->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('image');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210831_102628_create_table_image cannot be reverted.\n";

      return false;
      }
     */
}
