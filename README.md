# PHP Discord Webhooks
![](https://img.shields.io/github/license/TASSIA710/PHP-Discord-Webhooks?style=for-the-badge)
![](https://img.shields.io/github/issues/TASSIA710/PHP-Discord-Webhooks?style=for-the-badge)

A simple, single-file PHP library to execute Discord webhooks.

## Example

Firstly, you need to include the `DiscordWebhooks.php` file. Change the path to wherever you store it.
```php
include(__DIR__ . '/DiscordWebhooks.php');
const URL = 'https://discordapp.com/api/webhooks/{webhook.id}/{webhook.token}';
```

You can quickly execute a webhook using a chain syntax:
```php
// Chain Syntax
(new DiscordWebhook())->setContent('A chained webhook!')->execute(URL);
```

You can also execute more complex webhooks like below:
```php
$webhook = new DiscordWebhook();
$webhook->setContent('Hello World!');
$webhook->setUsername('Octocat');
$webhook->setAvatarURL('https://github.githubassets.com/images/modules/logos_page/Octocat.png');

$embed = new DiscordWebhookEmbed();
$embed->setTitle('This is the title!');
$embed->setDescription('And this is the description! It supports **Markdown**!');
$embed->setURL('https://github.com/');
$embed->setTimestamp(time());
$embed->setColor(255, 0, 0);
$embed->setFooter('Posted by the cool Octocat!', 'https://github.githubassets.com/images/modules/logos_page/Octocat.png');
$embed->setThumbnail('https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png');
$embed->setImage('https://github.githubassets.com/images/modules/logos_page/GitHub-Logo.png');
$embed->setAuthor('Pikachuuuu', 'https://github.com/TASSIA710', 'https://avatars1.githubusercontent.com/u/38081490');

$embed->addField(new DiscordWebhookEmbedField('Cool field!', 'This is a very cool field. **Markdown** is supported here aswell.'));
$embed->addField(new DiscordWebhookEmbedField('2nd cool field!', 'These two fields', true));
$embed->addField(new DiscordWebhookEmbedField('3rd cool field!', 'are inline!', true));
$webhook->addEmbed($embed);

echo $webhook->execute(URL);
```
