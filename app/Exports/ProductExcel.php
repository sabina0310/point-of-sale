<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ProductExcel implements WithHeadings, WithEvents, FromCollection, ShouldAutoSize
{
    protected $categories;

    public function __construct($categories)
    {
        // Retrieve all categories from the database
        $this->categories = $categories;
    }

    public function collection()
    {
        // dd($this->categories);

        $rows = $this->categories->map(function ($category) {
            return [
                '', '', '', '', '', '', '', '', '', '', '',
                $category->category_code,
                $category->name
            ];
        });

        // // Add empty rows if needed to reach 200 rows
        // for ($i = $rows->count(); $i < 200; $i++) {
        //     $rows->push(['', '', '', '', '', '', '', '', '', '', '', '', '']);
        // }

        return new Collection($rows);
    }

    public function headings(): array
    {
        // dd($this->categories);

        return [
            'Kategori',
            'Nama Produk',
            'Satuan Beli',
            'Harga Beli',
            'Isi Per Satuan Beli',
            'Harga Beli Per Isi',
            'Satuan Jual',
            'Harga Jual',
            'Laba',
            '',
            'Daftar',
            'Kode Kategori',
            'Nama Kategori'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // Insert formula in the third column of each row
                // for ($row = 2; $row <= 200; $row++) { // Adjust the range as needed
                //     $sheet->setCellValue(
                //         "F{$row}",
                //         "=IF(OR(D{$row}=\"\", E{$row}=\"\"), \"\", D{$row}/E{$row})"
                //     );
                //     $sheet->setCellValue(
                //         "I{$row}",
                //         "=IF(OR(F{$row}=\"\", H{$row}=\"\"), \"\", H{$row}-F{$row})"
                //     );
                // }
                $sheet->setCellValue(
                    "F2",
                    "=IF(OR(D2=\"\", E2=\"\"), \"\", D2/E2)"
                );
                $sheet->setCellValue(
                    "I2",
                    "=IF(OR(F2=\"\", H2=\"\"), \"\", H2-F2)"
                );

                // Automatically adjust column width
                foreach (range('A', 'M') as $column) { // Adjust range as needed
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
