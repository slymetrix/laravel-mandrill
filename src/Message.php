<?php

namespace Slymetrix\LaravelMandrill;

use InvalidArgumentException;

class Message
{
    private ?string $html;
    private ?string $text;
    private ?string $subject;
    private ?string $from_email;
    private ?string $from_name;
    private array $to; // TODO
    private Headers $headers;
    private ?bool $important;
    private ?bool $track_opens;
    private ?bool $track_clicks;
    private ?bool $auto_text;
    private ?bool $auto_html;
    private ?bool $inline_css;
    private ?bool $url_strip_qs;
    private ?bool $preserve_recipients;
    private ?string $view_content_link;
    private ?string $tracking_domain;
    private ?string $signing_domain;
    private ?string $return_path_domain;
    private ?bool $merge;
    private ?MergeLanguage $merge_language;
    private CaseInsensitiveKeyValueMap $global_merge_vars;
    private ?array $merge_vars; // TODO
    private array $tags;
    private ?string $subaccount;
    private ?string $google_analytics_domains;
    private ?string $google_analytics_campaign;

    public function __construct()
    {
        $this->to = [];
        $this->headers = new Headers();
        $this->global_merge_vars = new CaseInsensitiveKeyValueMap();
        $this->merge_vars = [];
        $this->tags = [];
    }

    public function &__get(string $name)
    {
        return $this->{$name};
    }

    public function __set(string $name, mixed $value): void
    {
        if (in_array($name, ['to', 'headers', 'global_merge_vars', 'merge_vars', 'tags'])) {
            throw new \RuntimeException('Cannot access private property '.static::class.'::$'.$name);
        }

        $this->{$name} = $value;
    }
}
