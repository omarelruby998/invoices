<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->header('Accept-Language', 'en');
        $supportedLanguages = ['en', 'ar'];
        if (!in_array($lang, $supportedLanguages)) {
            return response()->json(['error' => 'Language not supported'], 400);
        }
        if ($lang === 'ar') {
            return [
                'id' => $this->id,
                'name' => $this->getTranslation('name', 'ar'),  // Get Arabic translation
                'slug' => $this->slug,
                'price' => $this->price,
            ];
        }
        return [
            'id' => $this->id,
            'name' => [
                'en' => $this->getTranslation('name', 'en'),  // Get English translation// Get Arabic translation
            ],
            'slug' => $this->slug,
            'price' => $this->price,

        ];
    }
}
