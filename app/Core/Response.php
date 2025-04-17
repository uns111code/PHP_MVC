<?php 

namespace App\Core;

class Response
{

    public function __construct(
        private string $content = "",
        private int $status = 200,
        private array $headers = [],
    ) {
    }

    public function send(): void
    {
        http_response_code($this->status);

        /**
         * [
         * 'Content-Type' => 'text/html; charset=UTF-8',
         * 'Location' => '/login',]
         */

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
            // c'est comme on a coder header("Location: /login");
        }

        echo $this->content;
    }
}