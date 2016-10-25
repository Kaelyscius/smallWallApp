<?php

namespace App\Table;

use App\App;
use Core\Table\Table;

class MessageCategoryTable extends Table
{
    protected $table = 'messages_categories';

    public function getCategoriesByMessages()
    {
        $messages = $this->Query('SELECT m.id_message, c.id_category, c.title
                                FROM messages as m
                                INNER JOIN messages_categories AS m_c ON m_c.id_message = m.id_message
                                INNER JOIN categories AS c ON m_c.id_category = c.id_category
                                ');

        $categoriesByMessages = [];

        foreach ($messages as $message) {
            $categoriesByMessages[$message->id_message][] = $message->title;
        }

        return $categoriesByMessages;
    }

}
