<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 17:40
 */

namespace Demroos\Bundle\ApiGatewayBundle;

class Endpoint
{
    private string $name;
    private string $path;
    private string $method;
    protected array $config = [];

    public function __construct($name, $path, $method, $config = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->method = $method;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
