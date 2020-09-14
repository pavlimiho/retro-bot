<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeBotCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bot-command {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new bot command';

    /**
     * The path of the stub file
     * 
     * @var string 
     */
    private $stubPath = 'stubs/BotCommand.stub';
    
    /**
     * The path of the bot commands classes
     * 
     * @var string 
     */
    private $botCommandsPath = 'BotCommands/';
    
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'BotCommand';
    
    /**
     * The class name of the command
     *
     * @var string
     */
    private $className;
    
     /**
     * The path of the bot command class.
     *
     * @var string
     */
    private $classPath;
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->setCommandClass();
        
        $path = $this->getPath($this->classPath);
        
        if ($this->alreadyExists($this->classPath)) {
            $this->error($this->type . ' already exists!');
            return false;
        }
        
        $this->makeDirectory($path);
        
        $this->files->put($path, $this->buildClass($this->className));
        
        $this->info($this->type . ' created successfully.');
        
        $this->line('<info>Created Bot Command:</info> ' . $this->className);
    }
    
    /**
     * Set repository class name
     *
     * @return  void
     */
    private function setCommandClass()
    {
        $name = ucwords($this->argument('name'));

        $this->className = $name;

        $this->classPath = $this->parseName($name);
    }
    
    /**
     * Create the fqcn for the bot command class
     * 
     * @param type $name
     * @return type
     */
    public function parseName($name) 
    {
        return $this->botCommandsPath . $name;
    }
    
    /**
     * 
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  base_path($this->stubPath);
    }
}
