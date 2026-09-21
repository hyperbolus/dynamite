<?php

namespace Hyperbolus\Dynamite\Attributes;

use Attribute;
use Hyperbolus\Dynamite\Transform;

#[Attribute]
class Serializable {
    /**
     * @param string $key
     * @param Transform|Transform[] $transforms
     */
    public function __construct(
        public string $key,
        public Transform|array $transforms = [],
        public bool $deprecated = false,
    ) {}
}