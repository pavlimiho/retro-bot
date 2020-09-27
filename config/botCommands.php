<?php

return [

    // Gamble commands
    [
        'name' => 'gamble',
        'description' => 'Starts a new gambling session, takes a numeric value as a parameter',
        'active' => true
    ],
    [
        'name' => 'roll',
        'description' => 'Rolls a random amount when a gambling is in session',
        'active' => true
    ],
    [
        'name' => 'end_gamble',
        'description' => 'Ends the gambling session',
        'active' => true
    ],
    [
        'name' => 'gamble_history',
        'description' => 'Shows the gamble rankings',
        'active' => true
    ],
    
    // Video link commands
    [
        'name' => 'ripcord',
        'description' => 'Link the ripcord video',
        'active' => true
    ],
    [
        'name' => 'quiz',
        'description' => 'Link the football quiz video',
        'active' => true
    ],
    [
        'name' => 'boomer',
        'description' => 'Link the Raz boomer talk video',
        'active' => true
    ],
    [
        'name' => 'rob',
        'description' => 'Link the Robs sick dodging skills video',
        'active' => true
    ],
    [
        'name' => 'rap',
        'description' => 'Link the best rap ever made video',
        'active' => true
    ],
    
    // Other commands
    [
        'name' => 'ditcher',
        'description' => 'Ping all the ditchers',
        'active' => true
    ],
    [
        'name' => 'sl',
        'description' => 'The real shadowlands slang',
        'active' => true
    ],
    [
        'name' => 'fun',
        'description' => 'Link a random Retro famous quote',
        'active' => true
    ],
    [
        'name' => 'au',
        'description' => 'Ping all au gamers',
        'active' => true
    ],

    // Alex commands not built on this bot, using this only for the description
    [
        'name' => 'fight',
        'description' => 'Description:' . PHP_EOL, 
                        'Fight your nemesis' . PHP_EOL
                        . PHP_EOL
                        . 'Usage:' . PHP_EOL
                        . '!fight @Retro-bot'
                        . PHP_EOL
                        . 'Arguments:' . PHP_EOL
                        . 'opponent',
        'active' => false
    ]
];
