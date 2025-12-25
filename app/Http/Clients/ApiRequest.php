<?php

namespace App\Http\Clients;

use App\Enums\HttpMethods;

abstract class ApiRequest
{
    /**
     * @return HttpMethods
     */
    abstract public function method(): HttpMethods;

    /**
     * @return string
     */
    abstract public function url(): string;

    /**
     * @return array
     */
    public function headers(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * @return array|string|null
     */
    public function body(): array|string|null
    {
        return null;
    }
}
