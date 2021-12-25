<?php

use yii\db\Migration;

/**
 * Class m210831_102708_create_table_category
 */
class m210831_102708_create_table_category extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'slug' => $this->string(50)->notNull()->unique(),
            'status' => $this->string(10)->notNull(),
            'count' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('category');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m210831_102708_create_table_category cannot be reverted.\n";

      return false;
      }
     */
}
