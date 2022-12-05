<?php

namespace App\Extensions\ES;

use Elasticsearch\Namespaces\NamespaceBuilderInterface;
use Elasticsearch\Serializers\SerializerInterface;
use Elasticsearch\Transport;

class SQLBuilder implements NamespaceBuilderInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'sql';
    }

    /**
     * @param  Transport  $transport
     * @param  SerializerInterface  $serializer
     * @return SQLNamespace
     */
    public function getObject(Transport $transport, SerializerInterface $serializer)
    {
        return new SQLNamespace($transport, function () {
        });
    }
}
