<?php

namespace App\BotCommands;

use App\Models\TrashGame;
use App\Models\Member;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;
use Illuminate\Database\Eloquent\Builder;

class Au extends Command
{
    public $auCode = 'au';
    
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
        if ($this->validate()) {
            if ($this->hasParams && $this->params[0] === 'add') {
                $this->addAuPlayer();
            } else if ($this->hasParams && $this->params[0] === 'remove') {
                $this->removeAuPlayer();
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
     * Register a new au players
     * 
     * @return void
     */
    public function addAuPlayer()
    {
        $members = $this->saveMentionedMembers();
        
        if($members->count() > 0) {
            $mentions = '';
            
            foreach ($members as $member) {
                $member->trashGames()->sync(TrashGame::where('code', $this->auCode)->first());
                $mentions .= $this->mention($member);
            }
            
            $this->reply($mentions . ' has been added to the AU group');
        }
    }
    
    /**
     * Remove au players
     * 
     * @return void
     */
    public function removeAuPlayer()
    {
        $members = $this->saveMentionedMembers();
        
        if($members->count() > 0) {
            $mentions = '';
            
            foreach ($members as $member) {
                $member->trashGames()->detach(TrashGame::where('code', $this->auCode)->first());
                $mentions .= $this->mention($member);
            }
            
            $this->reply($mentions . ' has been removed from the AU group');
        }
    }
    
    /**
     * Check if the command has errors
     * 
     * @return boolean
     */
    public function hasError() 
    {
        if ($this->hasParams && $this->params[0] === 'add' && !$this->hasMentions()) {
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
