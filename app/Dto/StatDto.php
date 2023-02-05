<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Contracts\Support\Arrayable;

class StatDto implements Arrayable
{
    public function __construct(
        private readonly int $categoryId,
        private readonly int $subCategoryId,
        private readonly string $date,
        private readonly ?int $position
    ) {
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getSubCategoryId(): int
    {
        return $this->subCategoryId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function toArray(): array
    {
        return [
            'category_id' => $this->getCategoryId(),
            'sub_category_id' => $this->getSubCategoryId(),
            'stat_date' => $this->getDate(),
            'position' => $this->getPosition(),
        ];
    }
}
