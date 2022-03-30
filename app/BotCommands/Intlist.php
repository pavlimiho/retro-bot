<?php

namespace App\BotCommands;

use App\Models\Ints;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Intlist extends Command
{
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
        $ints = Ints::orderBy('count', 'desc')->get();
        
        $message = "***Retro top inters***\n";
        
        foreach ($ints as $int) {
            $message.= $int->name.' '.$int->count."\n";
        }
        
        $this->info($message);
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
