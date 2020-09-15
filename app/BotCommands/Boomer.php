<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Boomer extends SendVideo
{
    /**
     * The video url
     * 
     * @var string 
     */
    protected $videoUrl = 'https://clips.twitch.tv/PreciousCrepuscularAdminCoolStoryBob';
    
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
