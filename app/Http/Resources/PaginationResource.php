<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pagination' => [
                'current' => $this->currentPage(),
                'previous' => $this->currentPage() > 1 ? $this->currentPage() - 1 : 0,
                'next' => $this->hasMorePages() ? $this->currentPage() + 1 : 0,
                'perPage' => $this->perPage(),
                'totalPage' => $this->lastPage(),
                'totalItem' => $this->total(),
            ],
            'list' => $this->items()
        ];
    }
}
