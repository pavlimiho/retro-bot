<?php

namespace App\Traits;

trait Emojis 
{
    /**
     * Register all the emojis here
     * 
     * @var array 
     */
    private $emojis = [
        'kekw' => '<:kekw:626411240012644403>',
        'pepega' => '<:pepega:591965438666342413>',
        'peeporetard' => '<:peeporetard:606136059075756045>',
        'ricardo' => '<:ricardo:618109415450607628>',
    ];
    
    /**
     * Get the emoji id
     * 
     * @param string $name
     * @return string
     */
    protected function emoji(string $name) 
    {
        return in_array($name, array_keys($this->emojis)) ? $this->emojis[$name] : ':' . $name . ':';
    }
}
