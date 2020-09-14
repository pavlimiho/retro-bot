<?php

namespace App\BotCommands;

use App\Facades\Session;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Roll extends Gamble
{
    /**
     * The amount rolled
     * 
     * @var int 
     */
    public $roll;

    /**
     * Init the command
     * 
     * @param DiscordMessage $message
     * @param DiscordCommandClient $discord
     * @return void
     */
    public function __construct(DiscordMessage $message, DiscordCommandClient $discord) 
    {
        Command::__construct($message, $discord);
        
        $this->run();
    }
    
    /**
     * Run the command
     * 
     * @return void
     */
    public function run() 
    {
        if ($this->validate()) {
            $this->loadAmount();
            $this->roll();
            $this->setGamblers();
            $this->saveAuthor();
            
            $this->reply('rolled ' . $this->roll);
        }
    }
    
    /**
     * Load the gambled amount from the session
     * 
     * @return void
     */
    public function loadAmount()
    {
        $gamble = Session::get('gamble');
        $this->amount = $gamble['amount'];
    }
    
    /**
     * Roll your amount
     * 
     * @return void
     */
    public function roll()
    {
        $this->roll = rand(0, $this->amount);
    }
    
    /**
     * Store your roll in the session
     * 
     * @return void
     */
    public function setGamblers() 
    {
        $gamble = Session::get('gamble');
        $gamble['gamblers'][] = [
            'author' => $this->author,
            'roll' => $this->roll
        ];
        Session::set('gamble', $gamble);
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        if (!$this->gamblingInSession()) {
            $this->error = 'no_gamble';
            return true;
        } elseif ($this->hasGambled()) {
            $this->error = 'has_gambled';
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
        parent::sendError();
        
        switch ($this->error) {
            case 'has_gambled' :
                $this->error($this->author . ' you cannot roll again ' . $this->emoji('pepega'));
                break;
        }
    }
    
    /**
     * Check if author already gambled
     * 
     * @return boolean
     */
    public function hasGambled()
    {
        $gamble = Session::get('gamble');
        foreach ($gamble['gamblers'] as $gambler) {
            if($gambler['author']->id === $this->author->id) {
                return true;
            }
        }
        
        return false;
    }
}
