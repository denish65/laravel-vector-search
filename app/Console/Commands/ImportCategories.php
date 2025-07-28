<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import categories from an Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $filePath = storage_path('app/categories.xlsx');

        if (!file_exists($filePath)) {
            $this->error("File not found at: $filePath");
            return;
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header row
            $name = trim($row[0]);
            $sub_category = trim($row[1]);
            $service = trim($row[2]);
            $keywords = trim($row[3]);
            

            if (!empty($name)) {
                Category::firstOrCreate(['name' => $name,'sub_category' => $sub_category,'service' => $service,'keywords' => $keywords]);
            }
        }

        $this->info('Categories imported successfully!');
    }
}
