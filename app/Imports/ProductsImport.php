<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        // Skip header row
        if ($row[0] === 'name' || $row[0] == null) {
            return null;
        }

        return new Product([
            'name'         => $row[0],
            'unit'         => $row[1],
            'price'        => $row[2],
            'in_stock'     => $row[3],
            'purchaseType' => $row[4],
            'condition'    => $row[5],
            'avatar_url'   => $row[6],
            'images_url'   => $row[7],
            'rating'       => $row[8],
            'color'        => $row[9],
            'desc'         => $row[10],
            'category'     => $row[11],
            'subcategory'  => $row[12],
        ]);
    }
}
