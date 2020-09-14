<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Rob extends Command
{
    /**
     * The "Seth" video url
     * 
     * @var string 
     */
    private $videoUrl = 'https://www.youtube.com/watch?v=w7yF8zpGrHQ';
    
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
