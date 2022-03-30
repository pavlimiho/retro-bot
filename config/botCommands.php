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
        'usage' => '!endgamble',
        'active' => true
    ],
    [
        'name' => 'gamble_history',
        'description' => 'Shows the gamble rankings',
        'usage' => '!gamblehistory',
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
        'aliases' => ['rib']
    ],
    [
        'name' => 'rap',
        'description' => 'Link the best rap ever made video',
        'usage' => '!rap',
        'active' => true
    ],
    [
        'name' => 'loot',
        'description' => 'Link to lootsheet',
        'usage' => '!loot',
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
        'name' => 'int_this',
        'description' => 'Add someone to the intlist',
        'usage' => '!int',
        'active' => true,
        'aliases' => ['int']
    ],
    [
        'name' => 'intlist',
        'description' => 'Show the intlist',
        'usage' => '!intlist',
        'active' => true
    ],


    // Alex commands not built on this bot, using this only for the help command
    [
        'name' => 'fight',
        'description' => 'Fight your nemesis',
        'usage' => '!fight <opponent>',
        'active' => false
    ],
    [
        'name' => 'addgame',
        'description' => 'Adds a new game to the database',
        'usage' => '!addgame [game name]',
        'active' => false
    ],
    [
        'name' => 'addgamers',
        'description' => 'Adds users to a game',
        'usage' => '!addgamers [game name] @user1 @user2 @user3',
        'active' => false
    ],
    [
        'name' => 'lfm',
        'description' => 'Starts a gaming event',
        'usage' => '!lfm [game name] [time]',
        'active' => false
    ],
    [
        'name' => 'seticon',
        'description' => 'Adds an icon to a game',
        'usage' => '!seticon [game name] url',
        'active' => false
    ],
];
