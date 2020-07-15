<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 23:03
 */

namespace Demroos\Bundle\ApiGatewayBundle\Processor;

use Demroos\Bundle\ApiGatewayBundle\Contracts\Processor;

class WrapProcessor implements Processor
{
    private string $key;

    /**
     * WrapProcessor constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function process(array $data): array
    {
        return [$this->key => $data];
    }
}
