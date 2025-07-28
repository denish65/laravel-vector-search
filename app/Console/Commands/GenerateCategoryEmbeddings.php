<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\CategoryEmbedding;
use Illuminate\Support\Facades\Http;

class GenerateCategoryEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embeddings:generate';

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
        $this->info("Generating embeddings for categories...");

        $categories = Category::all();

        foreach ($categories as $category) {
            $fullText = $category->name;

            if (!empty($category->sub_category)) {
                $fullText .= ' ' . $category->sub_category;
            }

            if (!empty($category->service)) {
                $fullText .= ' ' . $category->service;
            }

            if (!empty($category->keywords)) {
                $fullText .= ' ' . $category->keywords;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env("COHERE_KEY"),
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.cohere.ai/v1/embed', [
                'texts' => [$fullText],
                'model' => 'embed-english-v3.0',
                'input_type' => 'search_document',
            ]);

            if ($response->successful()) {
                $embedding = $response['embeddings'][0];

                CategoryEmbedding::updateOrCreate(
                    ['category_id' => $category->id],
                    ['embedding' => $embedding]
                );

                $this->info("✓ Embedded category: {$category->name}");
            } else {
                $this->error("✗ Failed for category: {$category->name}");
            }
        }

        $this->info("✅ Embeddings generated successfully.");
    }
}
