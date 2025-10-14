<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @psalm-suppress MissingTemplateParam
 */
class BaseExport implements FromCollection, WithHeadings, WithMapping
{

    private $collection;

    private $heading;


    public function __construct(Collection $collection, array $heading = [])
    {
        $this->collection = $collection;
        $this->heading = $heading;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return $this->heading;
    }

    /**
     * @psalm-suppress MissingTemplateParam
     */
    public function map($row): array
    {
        return [];
    }
}
