<?php

return [

    // Gamble commands
    [
        'name' => 'gamble',
        'description' => 'Starts a new gambling session',
        'usage' => '!gamble <amount>',
        'active' => true
    ],
    [
        'name' => 'roll',
        'description' => 'Rolls a random amount when a gambling is in session',
        'usage' => '!roll',
        'active' => true
    ],
    [
        'name' => 'end_gamble',
        'description' => 'Ends the gambling session',
        'usage' => '!end_gamble',
        'active' => true
    ],
    [
        'name' => 'gamble_history',
        'description' => 'Shows the gamble rankings',
        'usage' => '!gamble_history',
        'active' => true
    ],
    
    // Video link commands
    [
        'name' => 'ripcord',
        'description' => 'Link the ripcord video',
        'usage' => '!ripcord',
        'active' => true
    ],
    [
        'name' => 'quiz',
        'description' => 'Link the football quiz video',
        'usage' => '!quiz',
        'active' => true
    ],
    [
        'name' => 'boomer',
        'description' => 'Link the Raz boomer talk video',
        'usage' => '!boomer',
        'active' => true
    ],
    [
        'name' => 'rob',
        'description' => 'Link the Robs sick dodging skills video',
        'usage' => '!rob',
        'active' => true,
        'aliases' => ['Rib']
    ],
    [
        'name' => 'rap',
        'description' => 'Link the best rap ever made video',
        'usage' => '!rap',
        'active' => true
    ],
    
    // Other commands
    [
        'name' => 'ditcher',
        'description' => 'Ping all the ditchers',
        'usage' => '!ditcher',
        'active' => true
    ],
    [
        'name' => 'sl',
        'description' => 'The real shadowlands slang',
        'usage' => '!sl',
        'active' => true
    ],
    [
        'name' => 'fun',
        'description' => 'Link a random Retro famous quote',
        'usage' => '!fun',
        'active' => true
    ],
    [
        'name' => 'au',
        'description' => 'Ping all au gamers',
        'usage' => '!au',
        'active' => true
    ],

    // Alex commands not built on this bot, using this only for the description
    [
        'name' => 'fight',
        'description' => 'Fight your nemesis',
        'usage' => '!fight <opponent>',
        'active' => false
    ]
];
