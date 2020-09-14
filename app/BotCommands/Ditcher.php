<?php

namespace App\BotCommands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;

class Ditcher extends Command
{
    /**
     * Store all the ditchers
     * 
     * @var array
     */
    public $ditchers = [];
    
    /**
     * The roles that can run this command
     * 
     * @var array 
     */
    public $permissions = ['Officer'];
    
    /**
     * The ditcher role
     * 
     * @var type 
     */
    public $ditcherRole = 'Ditcher';

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
            $this->getDitchers();

            foreach ($this->ditchers as $ditcher) {
                $this->info($ditcher . ' ' . $this->emoji('ricardo'));
            }
        }
    }
    
    /**
     * Get all ditchers in guild
     * 
     * @return void
     */
    public function getDitchers()
    {
        $members = $this->guild->members;
        
        foreach ($members as $member) {
            foreach($member->roles as $role) {
                if ($role->name === $this->ditcherRole) {
                    $this->ditchers[] = $member;
                    break;
                }
            }
        }
    }
}
