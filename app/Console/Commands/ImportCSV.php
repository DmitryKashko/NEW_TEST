<?php

namespace App\Console\Commands;

use App\Imports\ProductImport;
use Illuminate\Console\Command;

class ImportCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-c-s-v {test?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $argument = $this->argument('test');
        //dd($argument);
        $data = [
          'all' => 0,
          'error' => 0,
          'success' => 0,
        ];
        $import = new ProductImport($data, $argument);

        $import->import('stock.csv', 'public');

        dd($import);

    }
}
