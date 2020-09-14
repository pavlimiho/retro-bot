<?php

namespace App\BotCommands;

use App\Models\Member;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class GambleHistory extends Command
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
        $members = Member::with(['gamblesWon', 'gamblesLost'])
            ->withCount(['gamblesWon', 'gamblesLost'])
            ->get()
            ->filter(function ($member) {
                return $member->gambles_won_count > 0 || $member->gambles_lost_count > 0;
            })
            ->map(function ($member) {
                $member->amount_won = (int)($member->gamblesWon->sum('amount_won') - $member->gamblesLost->sum('amount_won'));
                return $member;
            })
            ->sortByDesc('amount_won')
            ->values();

        $message = $this->emoji('star') . $this->emoji('dollar') . ' GAMBLING HISTORY ' . $this->emoji('dollar') . $this->emoji('star') . PHP_EOL;
        
        for ($i = 0; $i < $members->count(); $i++) {
            $message .= ($i + 1) . '    ' . $members[$i]->name . '    ' . number_format($members[$i]->amount_won) . PHP_EOL;
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
