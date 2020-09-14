<?php

namespace App\BotCommands;

use App\Facades\Session;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Gamble extends Command
{
    /**
     * The amount gambled
     * 
     * @var string 
     */
    public $amount;

    /**
     * The gambling session lifetime in seconds
     * 
     * @var int 
     */
    public $lifespan = 60;
    
    /**
     * Minimal amount required to start gambling
     * 
     * @var int 
     */
    public $minAmount = 10;

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
        if ($this->validate()) {
            $this->setAmount();
            
            Session::set('gamble', [
                'amount' => $this->amount,
                'starter' => $this->author,
                'gamblers' => [],
                'start' => date('Y-m-d H:i:s')
            ]);
            
            $this->saveAuthor();
            
            $this->reply(
                'has started a ' . $this->amount . ' gold ' . $this->emoji('pepega') . ' gambling session. '
                . 'Please !roll to participate and !endgamble to end the session.'
            );
        }
    }
    
    /**
     * Load the amount from the params
     * 
     * @return void
     */
    public function setAmount() 
    {
        $this->amount = (int)$this->params[0];
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError()
    {
        if ($this->gamblingInSession()) {
            $this->error = 'in_session';
            return true;
        } elseif (!$this->hasParams || !is_numeric($this->params[0])) {
            $this->error = 'wrong_amount';
            return true;
        } elseif ($this->params[0] < $this->minAmount) {
            $this->error = 'small_amount';
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
            case 'in_session' :
                $this->error('There is already a gambling in session.');
                break;
            
            case 'wrong_amount' :
                $this->error('Incorrect amount. Please make sure you input a numeric value');
                break;
            
            case 'small_amount' :
                $this->error('Amount too small. Minimal amount accepted is ' . $this->minAmount);
                break;
            
            case 'no_gamble' :
                $this->error('There is no gambling in session.');
                break;
        }
    }
    
    /**
     * Check if there is a gambling in session
     * 
     * @return boolean
     */
    public function gamblingInSession() 
    {
        if (Session::missing('gamble')) {
            return false;
        }
        
        return !$this->gamblingExpired();
    }
    
    /**
     * Check if gamble has expired
     * Unset the gamble from the session
     * 
     * @return boolean
     */
    public function gamblingExpired() 
    {
        $gamble = Session::get('gamble');
        
        if (strtotime(date('Y-m-d H:i:s')) - strtotime($gamble['start']) <= $this->lifespan) {
            return false;
        } else {
            Session::unset('gamble');
            return true;
        }
    }
}
