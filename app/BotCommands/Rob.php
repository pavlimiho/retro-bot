<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Rob extends SendVideo
{
    /**
     * The video url
     * 
     * @var string 
     */
    protected $videoUrl = 'https://www.youtube.com/watch?v=w7yF8zpGrHQ';
    
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
