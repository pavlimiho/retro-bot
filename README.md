<p align="center"><img src="https://media.discordapp.net/attachments/376076464279388165/746702732077039626/YouTube_Profile_Picture.png" width="200"></p>

## About Retro-bot

Retro-bot is a discord bot built in php

- Easy to install
- Easy to add new commands
- Fun commands to have a good time with your friends

## Dependencies

- Retro bot is built on top of [DiscordPHP] (https://github.com/teamreflex/DiscordPHP)
- Retro bot uses the php framework [Laravel] (https://laravel.com/docs/7.x/installation) version 7.x. Basic knowledge of laravel is required.

## Installation

Retro-bot requires [Composer](https://getcomposer.org). Make sure you have installed Composer and are used to how it operates. We require a minimum PHP version of PHP 7.2.

1. Clone the code from our repository: git clone https://github.com/pavlimiho/retro-bot.git

2. Move into the retro-bot folder and create a .env file. You can copy .env.example as a placeholder.

3. Run composer install to get all the dependecies.

4. Run php artisan migrate --seed to build and seed the database.

## Adding new commands

In order to add a new command you must register it first in the config/botCommands.php file.

Then you can build it's functionality by creating a new class inside app/BotCommands. This class MUST extend the Command class found in the same namespace.

## Starting the bot

To initialize the bot run the following command from inside the retro-bot directory:

php artisan bot:run to initialize the bot.

## License

Retro-bot is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
