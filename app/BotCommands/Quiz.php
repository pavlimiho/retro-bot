<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Quiz extends Command
{
    /**
     * The "Seth" video url
     * 
     * @var string 
     */
    private $videoUrl = 'https://www.twitch.tv/videos/558407857';
    
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
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        // put your error logic here
    }
    
    /**
     * Send an error message
     * 
     * @return void
     */
    public function sendError() 
    {
        // send your error messages here
    }
}
