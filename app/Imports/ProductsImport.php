<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function __construct(
        protected User $seller,
        protected Category $category,
    ) {
    }

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => 'The uploaded Excel file does not contain any product rows.',
            ]);
        }

        $timestamp = now();
        $productsToInsert = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            $payload = [
                'name' => trim((string) ($row['name'] ?? '')),
                'description' => trim((string) ($row['description'] ?? '')),
                'price' => $row['price'] ?? null,
                'stock' => $row['stock'] ?? null,
                'minimum_stock' => $row['minimum_stock'] ?? 15,
                'discount' => $row['discount'] ?? null,
            ];

            $validator = Validator::make(
                $payload,
                [
                    'name' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                    'price' => ['required', 'numeric', 'min:0'],
                    'stock' => ['required', 'integer', 'min:0'],
                    'minimum_stock' => ['nullable', 'integer', 'min:0'],
                    'discount' => ['required', 'numeric', 'min:0', 'max:100'],
                ]
            );

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => 'Row ' . $rowNumber . ': ' . $validator->errors()->first(),
                ]);
            }

            $productsToInsert[] = [
                'seller_id' => $this->seller->id,
                'category_id' => $this->category->id,
                'name' => $payload['name'],
                'description' => $payload['description'],
                'price' => $payload['price'],
                'stock' => $payload['stock'],
                'minimum_stock' => $payload['minimum_stock'] ?? 15,
                'discount' => $payload['discount'],
                'image_path' => null,
                'is_active' => true,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        Product::query()->insert($productsToInsert);
    }
}
