<?php

namespace Slymetrix\LaravelMandrill;

use MyCLabs\Enum\Enum;
use JsonSerializable;

class MergeLanguage extends Enum implements JsonSerializable
{
    private const HANDLEBARS = 'handlebars';
    private const MAILCHIMP = 'mailchimp';

    public function jsonSerialize()
    {
        return $this->getValue();
    }
}
