<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Nuke extends Command
{
    /**
     * The roles that can run this command
     * 
     * @var array 
     */
    public $permissions = ['Officer'];
    
    private $maxNukes = 100;
    
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
        
        $this->run();
    }
    
    /**
     * Run the command
     * 
     * @return void
     */
    public function run() 
    {
        $limit = 2;
        
        if ($this->params && $this->params[0] < 100) {
            $limit = $this->params[0] + 1;
        } elseif ($this->params && $this->params[0] == 100) {
            $limit = $this->params[0];
        }
        
        if ($this->validate()) {
            $this->message->channel->getMessageHistory(['limit' => $limit])->done(function ($messages) {
                $this->message->channel->deleteMessages($messages);
            });
        }
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        if($this->hasParams && !is_numeric($this->params[0])) {
            $this->error = 'not_numeric';
            return true;
        }  elseif ($this->hasParams && $this->params[0] > $this->maxNukes) {
            $this->error = 'bad_number';
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Send an error message
     * 
     * @return void
     */
    public function sendError() 
    {
        switch ($this->error) {
            case 'not_numeric':
                $this->error('Please enter a numeric value.');
                break;
            case 'bad_number' :
                $this->error('You can only delete a maximum of '.$this->maxNukes.' messages at a time.');
                break;
        }
    }
}
