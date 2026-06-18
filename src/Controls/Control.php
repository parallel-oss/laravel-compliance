<?php

namespace Parallel\Compliance\Controls;

interface Control
{
    public function id(): string;

    public function source(): string;

    public function title(): string;

    public function description(): ?string;

    /**
     * @return array<int, string>
     */
    public function domains(): array;
}
