<?php

namespace App\Imports;

use App\Models\Lab;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        // Skip header row
        if ($row[0] === 'name' || $row[0] == null) {
            return null;
        }

        // Use same logic as controller for avatar and images
        $avatar = $this->handleUrl($row[11] ?? '');
        $images = $this->handleMultipleUrls($row[12] ?? '');

        return new Lab([
            'name'         => $row[0],
            'desc'         => $row[1],
            'category'     => $row[2],
            'subcategory'  => $row[3],
            'rating'       => $row[4] ?? '0',
            'color'        => $row[5] ?? null,
            'unit'         => $row[6] ?? null,
            'price'        => $row[7],
            'in_stock'     => $row[8] ?? '1',
            'purchaseType' => $row[9] ?? 'purchase',
            'condition'    => $row[10],
            'avatar'       => $avatar,
            'images'       => $images,
        ]);
    }

    private function handleUrl($url)
    {
        $url = trim($url);
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
    }

    private function handleMultipleUrls($urls)
    {
        $urls = trim($urls);
        $urlsArray = preg_split('/[\s,]+/', $urls);
        return array_filter($urlsArray, fn($url) => filter_var($url, FILTER_VALIDATE_URL));
    }
}
