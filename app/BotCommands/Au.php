<?php

namespace App\BotCommands;

use App\Models\TrashGame;
use App\Models\Member;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;
use Illuminate\Database\Eloquent\Builder;

class Au extends Command
{
    public $auCode = 'au';
    
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
            if ($this->hasParams && $this->params[0] === 'add') {
                $this->addAuPlayer();
            } elseif (!$this->hasParams) {
                $this->mentionAuPlayers();
            }
        }
    }
    
    /**
     * Get all the au players
     * 
     * @return Member
     */
    public function getAuPlayers() 
    {
        return Member::whereHas('trashGames', function(Builder $query) {
            $query->where('code', $this->auCode);
        })->get();
    }
    
    /**
     * Mention all au players
     * 
     * @return void
     */
    public function mentionAuPlayers() 
    {
        $auPlayers = $this->getAuPlayers();

        if ($auPlayers->count() > 0) {
            $message = '';

            foreach ($auPlayers as $player) {
                $message .= $this->mention($player);
            }

            $this->info($message);
        }
    }
    
    /**
     * Register a new au player
     * 
     * @return void
     */
    public function addAuPlayer()
    {
        $member = $this->saveMentionedMember($this->params[1]);
        
        $member->trashGames()->sync(TrashGame::where('code', $this->auCode)->first());
        
        $this->reply($this->mention($member) . ' has been added to the AU group');
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        if ($this->hasParams && $this->params[0] === 'add' && !$this->isMention($this->params[1])) {
            $this->error = 'no_mention';
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
            case 'no_mention' :
                $this->error('Please tag a member.');
                break;
        }
    }
}
