<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class StatsResponseDto implements Arrayable
{
    public function __construct(
        private readonly int $status,
        private readonly string $message,
        private readonly array $data
    ) {
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getStatsDtoCollection(): Collection
    {
        $result = new Collection();

        foreach ($this->data as $category => $data) {
            foreach ($data as $subCategory => $positions) {
                foreach ($positions as $date => $position) {
                    $result->push(new StatDto(
                        $category,
                        $subCategory,
                        $date,
                        $position
                    ));
                }
            }
        }

        return $result;
    }

    public function toArray(): array
    {
        return [
            'data' => [
                $this->getData(),
            ],
            'meta' => [
                'status' => $this->getStatus(),
                'message' => $this->getMessage(),
            ],
        ];
    }

    public static function makeFromResponse(array $responseBody): self
    {
        return new self(
            Arr::get($responseBody, 'status_code', 500),
            Arr::get($responseBody, 'message', ''),
            Arr::get($responseBody, 'data', [])
        );
    }
}
