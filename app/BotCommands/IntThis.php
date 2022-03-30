<?php

namespace App\BotCommands;

use App\Models\Ints;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class IntThis extends Command
{
    /**
     * The roles that can run this command
     * 
     * @var array 
     */
    public $permissions = ['Officer'];
    
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
        if ($this->validate() && $this->params) {
            $this->intName(trim(implode(' ', $this->params)));
        }
    }
    
    public function intName(string $name)
    {
        $int = Ints::where('name', $name)->first();
        
        if ($int) {
            $int->count++;
            $int->save();
        } else {
            $int = new Ints();
            $int->name = $name;
            $int->save();
        }
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
