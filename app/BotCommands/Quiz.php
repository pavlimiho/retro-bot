<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Quiz extends SendVideo
{
    /**
     * The video url
     * 
     * @var string 
     */
    protected $videoUrl = 'https://www.twitch.tv/videos/558407857';
    
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
