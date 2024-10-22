<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Image;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $products = Product::join('attributes', 'products.id', '=', 'attributes.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('images', 'products.id', '=', 'images.product_id')
            ->select(
                'products.*',
                'attributes.movement as movement',
                'attributes.case as case',
                'attributes.strap as strap',
                'attributes.water_resistance as water_resistance',
                'categories.name as category',
                \DB::raw("CONCAT('" . \URL::to('/') . "/storage/', images.image_path) AS image_path")
            )
            ->where('products.id', '=', $id)
            ->paginate();
        // return response()->json($products); 
        // Chuyển đổi dữ liệu để có cấu trúc như mong muốn
        $formattedProducts = $products->groupBy('id')->map(function ($productGroup) {
            $product = $productGroup->first();
            $images = $productGroup->pluck('image_path')->toArray();

            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'category_id' => $product->category_id,
                'category' => $product->category,
                'movement' => $product->movement,
                'case' => $product->case,
                'strap' => $product->strap,
                'water_resistance' => $product->water_resistance,
                'images' => $images,
            ];
        })->values();

        return response()->json($formattedProducts);
    }
    public function index()
    {
        $products = Product::join('attributes', 'products.id', '=', 'attributes.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('images', 'products.id', '=', 'images.product_id')
            ->select(
                'products.*',
                'attributes.movement as movement',
                'attributes.case as case',
                'attributes.strap as strap',
                'attributes.water_resistance as water_resistance',
                'categories.name as category',
                \DB::raw("CONCAT('" . \URL::to('/') . "/storage/', images.image_path) AS image_path")
            )
            ->orderBy('products.id')
            ->get();
        // return response()->json($products); 
        // Chuyển đổi dữ liệu để có cấu trúc như mong muốn
        $formattedProducts = [];
        foreach ($products as $product) {
            $productId = $product->id;
            if (!isset($formattedProducts[$productId])) {
                $formattedProducts[$productId] = [
                    'id' => $productId,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'category_id' => $product->category_id,
                    'category' => $product->category,
                    'movement' => $product->movement,
                    'case' => $product->case,
                    'strap' => $product->strap,
                    'water_resistance' => $product->water_resistance,
                    'images' => [],
                ];
            }

            // Thêm ảnh vào mảng images của sản phẩm
            if (!in_array($product->image_path, $formattedProducts[$productId]['images'])) {
                $formattedProducts[$productId]['images'][] = $product->image_path;
            }
        }

        return response()->json(array_values($formattedProducts));
    }

    public function create()
    {
        $categories = \DB::table('categories')
            ->select(
                "id as value",
                "name as label"
            )
            ->get();
        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function getProductsByCategoryId($id) {
        $products = Product::join('attributes', 'products.id', '=', 'attributes.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('images', 'products.id', '=', 'images.product_id')
            ->select(
                'products.*',
                'attributes.movement as movement',
                'attributes.case as case',
                'attributes.strap as strap',
                'attributes.water_resistance as water_resistance',
                'categories.name as category',
                \DB::raw("CONCAT('" . \URL::to('/') . "/storage/', images.image_path) AS image_path")
            )
            // ->where('products.id', '=', $id)
            ->where('products.category_id', '=', $id)
            ->paginate();
        // return response()->json($products); 
        // Chuyển đổi dữ liệu để có cấu trúc như mong muốn
        $formattedProducts = $products->groupBy('id')->map(function ($productGroup) {
            $product = $productGroup->first();
            $images = $productGroup->pluck('image_path')->toArray();

            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'category_id' => $product->category_id,
                'category' => $product->category,
                'movement' => $product->movement,
                'case' => $product->case,
                'strap' => $product->strap,
                'water_resistance' => $product->water_resistance,
                'images' => $images,
            ];
        })->values();

        return response()->json($formattedProducts);
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'images.*' => 'required|file', // Xác nhận các tệp tin (tối đa 2MB)
        ]);

        $uploadedFiles = [];

        \Log::info('Received request data:', $request->all());
        // Handle uploaded files
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach ($files as $file) {
                $path = $file->store('public/images');
                $uploadedFiles[] = $path;
            }
        }
        \Log::info('Uploaded files:', $uploadedFiles);
        return response()->json(['uploaded_files' => $uploadedFiles]);
    }
    public function store(Request $request)
    {
        \Log::info('Received request data:', $request->all());
        // Validate and store the blog post...
        $validated = $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'movement' => 'required|string',
            'case' => 'required|string',
            'strap' => 'required|string',
            'water_resistance' => 'required|string',
            'images.*' => '', // Validate images
        ]);

        // Create new product
        $product = new Product();
        $product->name = $validated['name'];
        $product->brand = $validated['brand'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];

        // Save product
        $product->save();

        // Create new product attributes
        $attribute = new Attribute();
        $attribute->product_id = $product->id;
        $attribute->movement = $validated['movement'];
        $attribute->case = $validated['case'];
        $attribute->strap = $validated['strap'];
        $attribute->water_resistance = $validated['water_resistance'];

        // Save product attributes
        $attribute->save();

        // Handle product images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                // Save image to storage
                $path = $image->store('images');

                // Create product image record in database
                $productImage = new Image();
                $productImage->image_path = $path;
                $productImage->product_id = $product->id;
                $productImage->save();
            }
        }

        return response()->json([
            'message' => 'Product created successfully',
            'success' => true,
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        \Log::info('Received request data:', $request->all());

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'movement' => 'required|string',
            'case' => 'required|string',
            'strap' => 'required|string',
            'water_resistance' => 'required|string',
            // 'images.*' => 'file|mimes:jpeg,png,jpg,gif', // Validate images
        ]);

        // Find the product to be updated
        $product = Product::findOrFail($id);

        // Update product details
        $product->name = $validated['name'];
        $product->brand = $validated['brand'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];
        $product->save();

        // Update product attributes
        $attribute = Attribute::updateOrCreate(
            ['product_id' => $product->id],
            [
                'movement' => $validated['movement'],
                'case' => $validated['case'],
                'strap' => $validated['strap'],
                'water_resistance' => $validated['water_resistance'],
            ]
        );

        // Handle product images
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            // Delete existing images
            $product->images()->delete();

            foreach ($images as $image) {
                // Save image to storage
                $path = $image->store('images');

                // Create product image record in database
                $productImage = new Image();
                $productImage->image_path = $path;
                $productImage->product_id = $product->id;
                $productImage->save();
            }
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'success' => true,
        ]);
    }

    public function deleteProduct($id)
    {
        // Tìm sản phẩm cần xóa
        $product = Product::findOrFail($id);

        // Xóa ảnh liên quan đến sản phẩm
        $product->images()->delete();

        // Xóa thuộc tính của sản phẩm
        $product->attribute()->delete();

        // Xóa bản ghi sản phẩm
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'success' => true,
        ]);
    }
}
