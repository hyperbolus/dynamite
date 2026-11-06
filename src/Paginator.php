<?php

namespace Hyperbolus\Dynamite;

use ArrayAccess;
use Hyperbolus\Dynamite\Models\Comment;
use Hyperbolus\Dynamite\Traits\GJSerializable;
use IteratorAggregate;

/**
 * @template T
 * @implements ArrayAccess<int, T>
 * @implements IteratorAggregate<int, T>
 */
class Paginator implements ArrayAccess, IteratorAggregate
{
    public int $start;
    public int $end;
    public int $total;

    public int $perPage = 10;


    /**
     * @var array array<int, T>
     */
    public array $items = [];

    /**
     * @param class-string<T> $class
     * @param array<int, T> $items
     * @return void
     */
    public function __construct(string $class, array $items, int $start, int $end, int $total) {
        $this->start = $start;
        $this->end = $end;
        $this->total = $total;

        $this->items = $items;
    }

    /**
     * @template U
     * @param string $content
     * @param class-string<U> $class
     * @return Paginator<U>
     */
    public static function parse(string $content, string $class, string $separator = ':'): Paginator {
        if (!in_array(GJSerializable::class, class_uses($class))) {
            throw new \Error('Class has no (de)serializer');
        }

        [$content, $pagination] = mb_split('#', $content);

        $items = [];

        foreach (explode('|', $content) as $item) {
            $addition = null;

            if ($class === Comment::class) [$item, $addition] = explode(':', $item);

            $out = $class::deserialize(gj_map($item, $separator));

            if ($class === Comment::class) $out->player = gj_map($addition, $separator);

            $items[] = $out;
        }

        return new Paginator($class, $items, ...mb_split(':', $pagination));
    }

    /**
     * @param $offset
     * @param T $value
     * @return void
     */
    public function offsetSet($offset, $value): void {
        is_null($offset) ? $this->items[] = $value : $this->items[$offset] = $value;
    }

    public function offsetExists($offset): bool {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset): void {
        unset($this->items[$offset]);
    }

    /**
     * @return T
     */
    public function offsetGet($offset): mixed {
        return $this->items[$offset] ?? null;
    }

    public function getIterator()
    {
        yield from $this->items;
    }
}