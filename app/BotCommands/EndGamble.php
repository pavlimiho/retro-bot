<?php

namespace App\BotCommands;

use Illuminate\Support\Facades\Session;
use App\Models\Gamble as GambleModel;
use App\Models\Member;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class EndGamble extends Gamble
{
    /**
     * Store the winner
     * 
     * @var object
     */
    public $winner;
    
    /**
     * Store the loser
     * 
     * @var object
     */
    public $loser;
    
    /**
     * Store the difference in gold
     * 
     * @var int
     */
    public $diff;

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
            $this->getResults();
            $this->saveGamble();
            Session::forget('gamble');
            
            $this->info('Gambling results:' . PHP_EOL
                . $this->emoji('star') . ' Winner ' . $this->emoji('star') . ' ' . $this->winner . PHP_EOL
                . $this->emoji('pepega') . ' ' . $this->loser . ' ' . $this->emoji('pepega') . ' owes ' . $this->diff . ' gold');
        }
    }
    
    /**
     * Calculate the results of the gamble
     * 
     * @return void
     */
    public function getResults()
    {
        $gamble = Session::get('gamble');
        
        $highest = 0;
        $lowest = $gamble['amount'];
        
        foreach ($gamble['gamblers'] as $gambler) {
            if($gambler['roll'] > $highest) {
                $highest = $gambler['roll'];
                $this->winner = $gambler['author'];
            }
            
            if($gambler['roll'] < $lowest) {
                $lowest = $gambler['roll'];
                $this->loser = $gambler['author'];
            }
        }
        
        $this->diff = $highest - $lowest;
    }
    
    /**
     * Save the gamble results in the database
     * 
     * @return void
     */
    public function saveGamble()
    {
        $gamble = Session::get('gamble');
        
        $gambleModel = new GambleModel();
        $gambleModel->starter_id = Member::where('member_id', $gamble['starter']->id)->first()->id;
        $gambleModel->amount = $gamble['amount'];
        $gambleModel->winner_id = Member::where('member_id', $this->winner->id)->first()->id;
        $gambleModel->loser_id = Member::where('member_id', $this->loser->id)->first()->id;
        $gambleModel->amount_won = $this->diff;
        $gambleModel->save();
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        $gamble = Session::get('gamble');
        
        if (!$this->gamblingInSession()) {
            $this->error = 'no_gamble';
            return true;
        } elseif ($gamble['starter']->id !== $this->author->id) {
            $this->error = 'not_starter';
            return true;
        } elseif (count($gamble['gamblers']) < 2) {
            $this->error = 'no_rolls';
            Session::forget('gamble');
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
            case 'not_starter' :
                $this->error(
                    'The one who started the gambling should also end it. '
                    . 'If no action taken the gambling will expire in ' . $this->lifespan . ' seconds.'
                );
                break;
            case 'no_rolls' :
                $this->error('Gambling canceled, not enough participants.');
                break;
        }
    }
}
