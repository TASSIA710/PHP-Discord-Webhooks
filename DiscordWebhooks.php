<?php

/*
MIT License

Copyright (c) 2020 Tassilo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */



// See: https://discord.com/developers/docs/resources/channel#embed-limits
const DISCORD_WEBHOOK_LIMIT_CONTENT = 4000;
const DISCORD_WEBHOOK_LIMIT_EMBED_TITLE = 256;
const DISCORD_WEBHOOK_LIMIT_EMBED_DESCRIPTION = 2048;
const DISCORD_WEBHOOK_LIMIT_EMBED_FIELDS = 25;
const DISCORD_WEBHOOK_LIMIT_FIELD_NAME = 256;
const DISCORD_WEBHOOK_LIMIT_FIELD_VALUE = 1024;
const DISCORD_WEBHOOK_LIMIT_FOOTER = 2048;
const DISCORD_WEBHOOK_LIMIT_AUTHOR = 256;
const DISCORD_WEBHOOK_LIMIT_EMBEDS = 10;
const DISCORD_WEBHOOK_LIMIT_TOTAL = 6000;





/**
 * This class represents an executable Discord webhook.
 */
class DiscordWebhook {
    private $content, $username, $avatar_url, $tts, $file, $embeds;

    /* Constructor */
    /**
     * DiscordWebhook constructor.
     */
    public function __construct() {
        $this->content = null;
        $this->username = null;
        $this->avatar_url = null;
        $this->tts = false;
        $this->file = null;
        $this->embeds = [];
    }
    /* Constructor */



    /* Content */
    /**
     * @return string|null the webhook's content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Sets the content for this webhook.
     * @param string|null $content the content of the message, or null if file or embed is used instead
     * @return DiscordWebhook this
     */
    public function setContent($content = null) {
        $this->content = $content;
        return $this;
    }
    /* Content */



    /* Username */
    /**
     * @return string|null the webhook's username override
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Sets the username override for this webhook.
     * @param string|null $username the username for this webhook, or null to use the default one
     * @return DiscordWebhook this
     */
    public function setUsername($username = null) {
        $this->username = $username;
        return $this;
    }
    /* Username */



    /* Avatar URL */
    /**
     * @return string|null the webhook's avatar override
     */
    public function getAvatarURL() {
        return $this->avatar_url;
    }

    /**
     * Sets the avatar override for this webhook.
     * @param string|null $avatar_url the avatar URL for this webhook, or null to use the default one
     * @return DiscordWebhook this
     */
    public function setAvatarURL($avatar_url = null) {
        $this->avatar_url = $avatar_url;
        return $this;
    }
    /* Avatar URL */



    /* Text-To-Speech */
    /**
     * @return bool whether the webhook will execute with TTS (text-to-speech) enabled
     */
    public function isTTS() {
        return $this->tts;
    }

    /**
     * Enables/Disables TTS (text-to-speech) for this webhook.
     * @param bool $tts
     * @return DiscordWebhook this
     */
    public function setTTS($tts = false) {
        $this->tts = $tts;
        return $this;
    }
    /* Text-To-Speech */



    /* File */
    // TODO
    /* File */



    /* Embeds */
    // TODO
    /* Embeds */



    /* Internal */
    protected function toDiscordObject() {
        $obj = [];
        if ($this->content != null) $obj['content'] = $this->content;
        if ($this->username != null) $obj['username'] = $this->username;
        if ($this->avatar_url != null) $obj['avatar_url'] = $this->avatar_url;
        if ($this->tts != false) $obj['tts'] = $this->tts;
        // TODO: embeds
        return $obj;
    }
    /* Internal */



    /* Execute */
    /**
     * Executes this wehook to the given endpoint url. Usual Discord webhook URLs look like this:
     * https://discordapp.com/api/webhooks/{webhook.id}/{webhook.token}
     * @param string $url
     * @return bool|int false on failure, the HTTP response code otherwise
     */
    public function execute($url) {
        $json = $this->toDiscordObject();
        $json = json_encode($json);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);

        if (!$result) {
            curl_close($ch);
            return false;
        } else {
            $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);
            return $response_code;
        }
    }
    /* Execute */

}


/**
 * A WebhookEmbed represents an embed within a webhook payload.
 */
class WebhookEmbed {
    private $title, $description, $url, $timestamp, $color, $fields;
    private $footer_text, $footer_icon_url;
    private $image_url;
    private $thumbnail_url;
    private $author_name, $author_url, $author_icon_url;

    /* Constructor */
    public function __construct() {
        $this->title = null;
        $this->description = null;
        $this->url = null;
        $this->timestamp = null;
        $this->color = null;
        $this->fields = [];
        $this->footer_text = null;
        $this->footer_icon_url = null;
        $this->image_url = null;
        $this->thumbnail_url = null;
        $this->author_name = null;
        $this->author_url = null;
        $this->author_icon_url = null;
    }
    /* Constructor */

}





/**
 * A WebhookEmbedField represents a field within an embed.
 */
class WebhookEmbedField {
    private $name, $value, $inline;

    /* Constructor */
    /**
     * Creates a new WebhookEmbedField.
     * @param string $name the field's name
     * @param string $value the field's value
     * @param bool $inline whether this field is an inline field
     */
    public function __construct($name = '', $value = '', $inline = false) {
        $this->name = $name;
        $this->value = $value;
        $this->inline = $inline;
    }
    /* Constructor */



    /* Field Name */
    /**
     * @return string the field's name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return WebhookEmbedField this
     */
    public function setName($name = '') {
        $this->name = $name;
        return $this;
    }
    /* Field Name */



    /* Field Value */
    /**
     * @return string the field's value
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $value
     * @return WebhookEmbedField this
     */
    public function setValue($value = '') {
        $this->value = $value;
        return $this;
    }
    /* Field Value */



    /* Inline */
    /**
     * @return bool whether this field is an inline field
     */
    public function isInline() {
        return $this->inline;
    }

    /**
     * @param bool $inline
     * @return WebhookEmbedField this
     */
    public function setInline($inline = false) {
        $this->inline = $inline;
        return $this;
    }
    /* Inline */



    /* Internal */
    protected function toDiscordObject() {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'inline' => $this->inline
        ];
    }
    /* Internal */

}
