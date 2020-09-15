<p align="center"><img src="https://media.discordapp.net/attachments/376076464279388165/746702732077039626/YouTube_Profile_Picture.png" width="200"></p>

## About Retro-bot

Retro-bot is a discord bot built in php

- Easy to install
- Easy to add new commands
- Fun commands to have a good time with your friends

## Dependencies

- Retro bot uses the php framework [Laravel](https://laravel.com/docs/7.x/installation) version 7.x. Basic knowledge of laravel is required.
- Retro bot is built on top of [DiscordPHP](https://github.com/teamreflex/DiscordPHP)

## Installation

Retro-bot requires [Composer](https://getcomposer.org). Make sure you have installed Composer and are used to how it operates. We require a minimum PHP version of PHP 7.2.

1. Clone the code from our repository: <code>git clone https://github.com/pavlimiho/retro-bot.git</code>

2. Run <code>composer install</code> to get all the dependecies.

3. Move into the retro-bot folder and create a .env file. You can copy .env.example as a placeholder.

4. Generate the application key with: <code>php artisan key:generate</code>

5. Run <code>php artisan migrate --seed</code> to build and seed the database.

## Adding new commands

In order to add a new command you must register it first in the <code>config/botCommands.php</code> file.

Then you can create a new bot command class with the following command:

<code>php artisan make:bot-command</code>

## Starting the bot

To initialize the bot run the following command from inside the retro-bot directory:

<code>php artisan bot:start</code>

## License

Retro-bot is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
