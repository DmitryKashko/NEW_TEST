<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $data;
    protected $argument;

    public function __construct($data, $argument)
    {
        $this->data = $data;
        $this->argument = $argument;
    }
    public function model(array $row)
    {
        $product = Product::query()->where('strProductCode', $row['product_code'])->get()->first();


        if($product == null) {
            if($row['stock'] >= 10 && $row['cost_in_gbp'] >= 5 && $row['cost_in_gbp'] <= 1000) {
                if($this->argument == null) {
                    Product::create([
                        'strProductName' => $row['product_name'],
                        'strProductDesc' => $row['product_description'],
                        'strProductCode' => $row['product_code'],
                        'stock' => $row['stock'],
                        'cost' => $row['cost_in_gbp'],
                        'dtmAdded' => now('+3'),
                        'dtmDiscontinued' => $row['discontinued'] == 'yes',
                    ]);
                }
                $this->data['success'] = ++$this->data['success'];
            } else {
                $this->data['error'] = ++$this->data['error'];
            }
        } else {
            if($row['stock'] >= 10 && $row['cost_in_gbp'] >= 5 && $row['cost_in_gbp'] <= 1000) {
                if($this->argument == null) {
                    $product->update([
                        'stock' => $product->stock + $row['stock'],
                        'cost' => $row['cost_in_gbp'],
                        'dtmDiscontinued' => $row['discontinued'] == 'yes',
                    ]);
                }
                $this->data['success'] = ++$this->data['success'];
            } else {
                $this->data['error'] = ++$this->data['error'];
            }
        }
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
        $this->data['error'] = ++$this->data['error'];
    }

    public function rules(): array
    {
        $this->data['all'] = ++$this->data['all'];
        return [
            'product_code' => ['required'],
            'product_name' => ['string'],
            'product_description' => ['string'],
            'stock' => ['integer'],
            'cost_in_gbp' => ['decimal:0,2'],
            'discontinued' => [],
        ];
    }

}
