<?php

namespace App\BotCommands;

use App\Models\Member;
use App\Traits\Emojis;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;

class Command 
{
    use Emojis;
    
    /**
     * Contains the discord message object
     * 
     * @var DiscordMessage object 
     */
    protected $message;
    
    /**
     * Contains the discord object
     * 
     * @var DiscordCommandClient object 
     */
    protected $discord;
    
    /**
     * Contains the author object
     * 
     * @var object 
     */
    protected $author;
    
    /**
     * Contains the roles of the author of the message
     * 
     * @var array 
     */
    protected $roles;
    
    /**
     * The officer role
     * 
     * @var string 
     */
    private $officeRole = 'Officer';
    
    /**
     * The raider role
     * 
     * @var string 
     */
    private $raiderRole = 'Raider';
    
    /**
     * Contains the guild object
     * 
     * @var object 
     */    
    protected $guild;

    /**
     * If the command has params
     * 
     * @var boolean 
     */
    protected $hasParams;

    /**
     * The params of the command
     * 
     * @var array 
     */
    protected $params;

    /**
     * The error code
     * 
     * @var string
     */
    protected $error;
    
    /**
     * The roles that can use the command
     * 
     * @var array 
     */
    protected $permissions = null;
    
    /**
     * Load the discord message object
     * 
     * @param DiscordMessage $message
     */
    protected function __construct(DiscordMessage $message, DiscordCommandClient $discord) 
    {
        $this->message = $message;
        $this->discord = $discord;
        
        $this->setGuild();
        $this->setAuthor();
        $this->setRoles();
        $this->setParams();
    }
    
    /**
     * Get the name of the author of the message
     * 
     * @return string
     */
    protected function getAuthor()
    {
        return $this->message->author->username;
    }
    
    /**
     * Load the author
     * 
     * @return void
     */
    private function setAuthor()
    {
        $this->author = $this->message->author;
    }
    
    /**
     * Load the author roles
     * 
     * @return void
     */
    private function setRoles()
    {
        foreach ($this->message->author->roles as $role) {
            $this->roles[] = $role->name;
        }
    }
    
    /**
     * Check if the author is an officer
     * 
     * @return boolean
     */
    protected function isOfficer() 
    {
        return in_array($this->officeRole, $this->roles);
    }
    
    /**
     * Check if the author is a raider
     * 
     * @return boolean
     */
    protected function isRaider() 
    {
        return in_array($this->raiderRole, $this->roles);
    }
    
    /**
     * Load the guild
     * 
     * @return boolean
     */
    protected function setGuild() 
    {
        foreach ($this->discord->guilds as $guild) {
            if($guild->name === env('GUILD')) {
                $this->guild = $guild;
                break;
            }
        }
    }
    
    /**
     * Send a message to the channel
     * 
     * @param string $message
     */
    protected function info(string $message)
    {
        $this->message->channel->sendMessage($message);
    }
    
    /**
     * Replies back to a message
     * 
     * @param string $message
     */
    protected function reply(string $message)
    {
        $this->message->reply($message);
    }
    
    /**
     * Send an error to the channel
     * 
     * @param string $message
     */
    protected function error(string $message)
    {
        $this->info($this->emoji('peeporetard') . ' Error: ' . $message);
    }
    
    /**
     * Validates the command input
     * 
     * @return boolean
     */
    protected function validate() 
    {
        if (!$this->validatePermissions()) {
            return false;
        } elseif ($this->hasError()) {
            $this->sendError();
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Validates roles
     * Check if the role of the author is within the allowed
     * roles of the command
     * 
     * @return boolean
     */
    private function validatePermissions()
    {
        if ($this->permissions === null) {
            return true;
        } else {
            foreach ($this->roles as $role) {
                if(in_array($role, $this->permissions)) {
                    return true;
                }
            }
            
            return false;
        }
    }
    
    /**
     * Load the params
     * 
     * @return void
     */
    protected function setParams()
    {
        $commandExploded = explode(' ', $this->message->content);
        
        if (count($commandExploded) > 1) {
            $this->hasParams = true;
            $this->putParams($commandExploded);
        } else {
            $this->hasParams = false;
        }
    }
    
    /**
     * Stores the params
     * 
     * @param array $commandExploded
     * @return void
     */
    protected function putParams(array $commandExploded)
    {
        for ($i = 1; $i < count($commandExploded); $i++) {
            $this->params[] = $commandExploded[$i];
        }
    }
    
    /**
     * Check if the command has errors
     * Override this in your child command
     */
    protected function hasError() 
    {
        return false;
    }
    
    /**
     * Send an error message
     * Override this in your child command
     */
    protected function sendError() {}
    
    /**
     * Get all roles of a user
     * 
     * @param object $user
     * @return array
     */
    protected function getRoles($user)
    {
        $roles = [];
        
        foreach ($user->roles as $role) {
            $roles[] = $role;
        }
        
        return $role;
    }
    
    /**
     * Save the author in database if it has not already been stored
     * 
     * @return void
     */
    protected function saveAuthor() 
    {
        if (Member::where('member_id', $this->author->id)->count() === 0) {
            $member = new Member();
            $member->member_id = $this->author->id;
            $member->name = $this->author->username;
            $member->discriminator = $this->author->discriminator;
            $member->save();
        }
    }
    
    /**
     * Retrieve the id of the member when he is tagged
     * 
     * @param string $mention
     * @return string
     */
    protected function getMemberIdFromMention($mention) 
    {
        return ltrim(rtrim($mention, '>'), '<@!'); 
    }
    
    /**
     * Check if a string is a member mention
     * 
     * @param string $mention
     * @return boolean
     */
    protected function isMention($mention) 
    {
        if (
            substr($mention, 0, 2) === '<@' &&
            substr($mention, -1) === '>' &&
            strlen($mention) > 20
        ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save mentioned member
     * 
     * @param string $mention
     * @return Member
     */
    protected function saveMentionedMember($mention) 
    {
        $memberId = $this->getMemberIdFromMention($mention);
        
        $member = Member::where('member_id', $memberId)->get();
        
        if ($member->count() === 0) {
            $newMember = new Member();
            $newMember->member_id = $memberId;
            $newMember->save();
            
            return $newMember;
        } else {
            return $member->first();
        }
    }
    
    /**
     * Mention a member
     * 
     * @param Member $member
     * @return string
     */
    protected function mention(Member $member)
    {
        return '<@!' . $member->member_id . '>';
    }
}
