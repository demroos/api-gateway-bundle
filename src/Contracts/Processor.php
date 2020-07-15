<?php
/**
 * Created by PhpStorm.
 * @author Ewgeniy Kiselev <demroos@gmail.com>
 * Date: 11.07.2020
 * Time: 23:03
 */

namespace Demroos\Bundle\ApiGatewayBundle\Contracts;


interface Processor
{
    /**
     * Process data and return
     *
     * @param array $data
     * @return array
     */
    public function process(array $data): array;
}
