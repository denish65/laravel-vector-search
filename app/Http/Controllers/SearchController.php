<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryEmbedding;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{

   public function index(Request $request)
    {
      
        $query = $request->input('query');

        if (!$query) {
            return  view('search');
        }



        // Step 1: Generate vector for user query
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env("COHERE_KEY"),
            'Content-Type' => 'application/json',
        ])->post('https://api.cohere.ai/v1/embed', [
            'texts' => [$query],
            'model' => 'embed-english-v3.0',
            'input_type' => 'search_query',
        ]);

        if (!$response->ok()) {
            return response()->json(['error' => 'Embedding failed'], 500);
        }

        $queryVector = $response['embeddings'][0];

        // Step 2: Compare with stored embeddings
        $embeddings = CategoryEmbedding::with('category')->get();
        $bestScore = -1;
        $bestMatch = null;

        // echo "<PRe>"; print_r($embeddings);exit();
        foreach ($embeddings as $embedding) {
        // echo "<PRe>"; print_r(json_decode($embedding->embedding));exit();
        // var_dump($embedding->embedding);exit();
    
            $score = $this->cosineSimilarity($queryVector, $embedding->embedding);
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $embedding;
            }
        }

        // Step 3: Return result
        if ($bestScore > 0.45) {
           return view('search', [
            'result'=>true,
            'category' => $bestMatch->category->name,
            'sub_category' => $bestMatch->category->sub_category,
            'service' => $bestMatch->category->service,
            'keywords' => $bestMatch->category->keywords,
            'score' => round($bestScore, 4),
        ]);

        } else {
            return view('search',['message' => 'No relevant match found.'], 404);
        }
    }


    private function cosineSimilarity(array $vec1, array $vec2): float
    {
        $dot = 0;
        $normA = 0;
        $normB = 0;

        for ($i = 0; $i < count($vec1); $i++) {
            $dot += $vec1[$i] * $vec2[$i];
            $normA += $vec1[$i] ** 2;
            $normB += $vec2[$i] ** 2;
        }

        return $normA && $normB ? $dot / (sqrt($normA) * sqrt($normB)) : 0;
    }
}
