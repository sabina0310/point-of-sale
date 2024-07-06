<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public $importedData = [];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['kategori'] == '') {
            return null;
        }
        
        $category = Category::where('category_code', $row['kategori'])->first();

        $product = new Product([
            'name' => $row['nama_produk'],
            'category_id' => $category->id,
            'purchase_unit' => $row['satuan_beli'],
            'purchase_price' => $row['harga_beli'],
            'quantity_per_purchase_unit' => $row['isi_per_satuan_beli'],
            'price_per_purchase_item' => $row['harga_beli'] / $row['isi_per_satuan_beli'],
            'sale_unit' => $row['satuan_jual'],
            'sale_price' => $row['harga_jual'],
            'stock' => 0
        ]);
        // Save imported data for logging
        $this->importedData[] = $product->toArray();

        return $product;
    }

    public function getImportedData()
    {
        return $this->importedData;
    }
}
