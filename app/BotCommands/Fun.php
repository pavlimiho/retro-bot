<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Fun extends Command
{
    /**
     * Contains famous quotes
     * 
     * @var array 
     */
    public $quotes = [
        'You would not last one day in Delhi mate',
        'Don\'t talk to me like that pal',
        'Sorry, gotta run',
        'I\'m out, GL in SL',
        'Can my DH come on Behemoth?',
        'Cocoon on Husby',
        'I don\'t get all these me and the bois memes',
        'I like scotch and bourbon',
        'Pretty sure the pillar moved',
        'Bulsit',
        'I don\'t do bench mate',
        'You already have two very strong warlocks',
        'Me and Jack are like fire and water',
        'Have you tried logging into another character?',
        'Headphones will make you go bald',
        'If we get top 20 Silvermoon, I will buy everyone a longboi',
    ];


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
        $this->reply($this->getQuote());
    }
    
    /**
     * Get a random quote
     * 
     * @return string
     */
    public function getQuote() 
    {
        return $this->quotes[rand(0, count($this->quotes))];
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
