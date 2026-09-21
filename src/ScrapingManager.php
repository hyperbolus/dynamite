<?php

namespace Hyperbolus\Dynamite;

class ScrapingManager
{
    const int MAX_QUEUE = 100;

    public array $options;

    public array $proxies;

    protected array $queue;

    /**
     * @param int|array<int> $levels
     * @return void
     */
    public function queue(int|array $levels): void
    {
        if (!is_array($levels)) $levels = [$levels];

        // Check if amnt of levels added fills the queue, if so flush it
        if (count($levels) + count($this->queue) >= self::MAX_QUEUE) {
            $freeSpace = self::MAX_QUEUE - count($this->queue);

            // off by one?
            array_push($this->queue, ...array_splice($levels, 0, $freeSpace));

            // Flush queue
            $this->flush();

            // Add remainder to queue
            array_splice($this->queue, $freeSpace + 1, count($levels) - $freeSpace);
        } else {
            array_push($this->queue, ...$levels);
        }
    }

    /**
     * Flushes the level queue and fills
     *
     * @return void
     */
    public function fillFlush()
    {

    }

    public function flush(int|array $levels)
    {
        // 0 priority (passed)
        // 1 queues (cached)
        // 2 fill empty space

    }

    public function options(array $options, bool $merge = true): static
    {
        $this->options = $merge ? array_merge($this->options, $options) : $options;

        return $this;
    }

    public function option(string $key, mixed $value): static
    {
        $this->options[$key] = $value;

        return $this;
    }
}