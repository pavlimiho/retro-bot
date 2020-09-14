<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Seth extends Command
{
    /**
     * The "Seth" video url
     * 
     * @var string 
     */
    private $videoUrl = 'https://www.youtube.com/watch?v=2ILRYT8Mc80';
    
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
        $this->info($this->emoji('kekw') . ' ' . $this->videoUrl);
    }
}
