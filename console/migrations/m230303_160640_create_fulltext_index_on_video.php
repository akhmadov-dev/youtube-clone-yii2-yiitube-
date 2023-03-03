<?php

use yii\db\Migration;

/**
 * Class m230303_160640_create_fulltext_index_on_video
 */
class m230303_160640_create_fulltext_index_on_video extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%video}} ADD FULLTEXT(title, description, tags)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230303_160640_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230303_160640_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }
    */
}
