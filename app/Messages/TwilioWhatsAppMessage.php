<?php

namespace App\Messages;

class TwilioWhatsAppMessage
{
    public string $content;

    /**
     * @param string $content
     *
     * @return TwilioWhatsAppMessage
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }
}
