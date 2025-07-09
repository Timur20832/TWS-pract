<?php

namespace App\DTO\Post;

class PostQueryDto
{
    public ?string $sortBy = 'created_at';
    public ?string $sortOrder = 'desc';
    public ?int $limit = 10;
    public ?int $offset = 0;
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public function __construct(
        ?string $sortBy = 'created_at',
        ?string $sortOrder = 'desc',
        ?int $limit = 10,
        ?int $offset = 0,
        ?string $dateFrom = null,
        ?string $dateTo = null
    ) {
        $this->dateTo = $dateTo;
        $this->dateFrom = $dateFrom;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->sortOrder = $sortOrder;
        $this->sortBy = $sortBy;
    }
}
