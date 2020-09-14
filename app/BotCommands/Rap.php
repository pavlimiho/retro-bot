<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Rap extends SendVideo
{
    /**
     * The "Seth" video url
     * 
     * @var string 
     */
    protected $videoUrl = 'https://www.youtube.com/watch?v=4BQrav8uJpE';
    
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
