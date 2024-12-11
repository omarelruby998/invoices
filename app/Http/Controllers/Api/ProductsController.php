<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\products;
use App\sections;
use App\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    public function index()
    {
        $products = products::paginate(10);
        return response()->json($products);
    }
    public function add_remove_wishlist(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid user ID',
                'details' => $validator->errors()
            ], 400);
        }
        $products = products::findOrFail($id);
        $wishlist = WishList::where('product_id', $products->id)
                             ->where('user_id',$request->user_id)
                             ->first();
        if($wishlist){
            $wishlist->delete();
            return response()->json(['message' => 'Removed from wishlist'], 200);
        }
        else
        {
            WishList::create([
                'product_id' => $products->id,
                'user_id' => $request->user_id
            ]);
            return response()->json(['message' => 'Added to wishlist'], 200);
        }

    }
    public function searchByName(Request $request)
    {
        $lang = $request->header('Accept-Language', 'en');
        $supportedLanguages = ['en', 'ar'];
        if (!in_array($lang, $supportedLanguages)) {
            return response()->json(['error' => 'Language not supported'], 400);
        }
        $slug = Str::slug($request->input('name'));
        $products = products::where('slug',$slug)->first();
        if($products){
            return new ProductResource($products);
        }
        else{
            return response()->json(['error' => 'Product not found'], 404);
        }
     }
}
