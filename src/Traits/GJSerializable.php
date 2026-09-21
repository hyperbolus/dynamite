<?php

namespace Hyperbolus\Dynamite\Traits;

use Hyperbolus\Dynamite\Attributes\Serializable;
use ReflectionNamedType;
use ReflectionObject;

trait GJSerializable
{
    /**
     * @param array $map
     * @return static
     */
    public static function deserialize(array $map): static {
        $class = new static();

        $reflection = new ReflectionObject($class);

        $missing = [];

        foreach ($reflection->getProperties() as $attr) {
            $attributes = $attr->getAttributes(Serializable::class);

            if (count($attributes) > 0) {
                // todo: check to make sure right attribute
                $args = $attributes[0]->getArguments();

                $name = $attr->getName();
                $key = $args[0];

                if (!array_key_exists($key, $map)) {
                    // todo: warn, check deprecations, or ignore if nullable
                    continue;
                };

                $value = $map[$key];

                // Apply transforms
                if (count($args) > 1) {
                    if (!is_array($args[1])) $args[1] = [$args[1]];

                    // Reverse transform order because we are deserializing
                    foreach (array_reverse($args[1]) as $arg) $value = $arg->run($value, true);
                }

                // Type casts
                if (is_a($attr->getType(), ReflectionNamedType::class)) {
                    if ($attr->getType()->getName() === 'int') {
                        if ($value !== null) $class->{$name} = intval($value);
                    } else {
                        if ($value !== null) $class->{$name} = $value;
                    }
                } else {
                    throw new \Exception('Not implemented');
                }
            } else {
                // TODO @ if something didnt get unserialized then emit warning and save the server response
            }
        }

        return $class;

    }
}