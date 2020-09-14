<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Ripcord extends Command
{
    /**
     * The "Ripcord" video url
     * 
     * @var string 
     */
    protected $videoUrl = 'https://twitter.com/_SWofficial/status/1297265974132068353';
    
    /**
     * Init the command
     * 
     * @param DiscordMessage $message
     * @param DiscordCommandClient $discord
     * @return void
     */
    public function __construct(DiscordMessage $message, DiscordCommandClient $discord) 
    {
        parent::__construct($message, $discord);
    }
}
