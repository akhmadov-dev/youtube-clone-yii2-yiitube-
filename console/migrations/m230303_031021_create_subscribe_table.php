<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230303_031021_create_subscribe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribe}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'create_at' => $this->integer(11),
        ]);

        // creates index for column `channel_id`
        $this->createIndex(
            '{{%idx-subscribe-channel_id}}',
            '{{%subscribe}}',
            'channel_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscribe-channel_id}}',
            '{{%subscribe}}',
            'channel_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-subscribe-user_id}}',
            '{{%subscribe}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscribe-user_id}}',
            '{{%subscribe}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscribe-channel_id}}',
            '{{%subscribe}}'
        );

        // drops index for column `channel_id`
        $this->dropIndex(
            '{{%idx-subscribe-channel_id}}',
            '{{%subscribe}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscribe-user_id}}',
            '{{%subscribe}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-subscribe-user_id}}',
            '{{%subscribe}}'
        );

        $this->dropTable('{{%subscribe}}');
    }
}
