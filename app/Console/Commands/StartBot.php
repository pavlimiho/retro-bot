<?php

namespace App\Console\Commands;

use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message as DiscordMessage;
use Illuminate\Console\Command;

class StartBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the bot';

    /**
     * Store the discord instance
     * 
     * @var Discord object  
     */
    private $discord;
    
    /**
     * The command prefix
     * 
     * @var string
     */
    private $commandPrefix = '!';
    
    /**
     * The command namespace
     * 
     * @var string 
     */
    private $commandNamespace = '\App\BotCommands\\';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->discord = new DiscordCommandClient([
            'token' => env('TOKEN'),
            'prefix' => $this->commandPrefix,
            'description' => 'A fun bot for Retro-Silvermoon guild'
        ]);
        
        $this->registerCommands();
        
        $this->discord->run();
    }
    
    /**
     * Register the commands
     * 
     * @return void
     */
    public function registerCommands() 
    {
        foreach (config('botCommands') as $command) {
            if (!isset($command['aliases'])) {
                $command['aliases'] = [];
            }
            
            array_unshift($command['aliases'], $command['name']);
            
            $this->discord->registerCommand(str_replace('_', '', $command['name']), function (DiscordMessage $message) use ($command) {
                $this->initiateCommand($command, $message);
            }, [
                'description' => $command['description'],
                'usage' => $command['usage'],
                'aliases' => $command['aliases']
            ]);
        }
    }
    
    /**
     * Get the classname of the command
     * 
     * @param string $command
     * @return string
     */
    private function getCommandClassName(string $command)
    {
        $commandEx = explode('_', $command);
        
        $comandClassName = $this->commandNamespace;
        
        foreach ($commandEx as $part) {
            $comandClassName .= ucfirst($part);
        }
        
        return $comandClassName;
    }
    
    /**
     * Initiates the command
     * 
     * @param array $command
     * @return void
     */
    public function initiateCommand(array $command, DiscordMessage $message) 
    {
        if ($command['active']) {
            $comandClassName = $this->getCommandClassName($command['name']);
            new $comandClassName($message, $this->discord);
        }
    }
}
