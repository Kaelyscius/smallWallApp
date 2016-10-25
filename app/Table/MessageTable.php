<?php

namespace App\Table;

use App\App;
use Core\Table\Table;

class MessageTable extends Table
{
    protected $table = 'messages';

     /**
     * Retrieve last Articles
     *  @return
     */
    public function getAllMessageOrderDesc()
    {
        return $this->Query('SELECT * 
                                FROM messages
                                ORDER BY messages.date DESC');
    }

    
}
