<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Hello extends Command
{
    /**
     * Init the command
     * 
     * @param Message $message
     * @param DiscordCommandClient $discord
     * @return void
     */
    public function __construct(Message $message, DiscordCommandClient $discord) 
    {
        parent::__construct($message, $discord);
        
        $this->run();
    }
    
    /**
     * Run the command
     * 
     * @return void
     */
    public function run() 
    {
        $this->reply('Hello! How are you?');
    }
}
