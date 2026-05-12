<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ConvertThumbnailsToWebP extends Command
{
    protected $signature = 'products:webp';
    protected $description = 'Convert all product thumbnails to WebP';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::all();
        $this->info('Total products: ' . $products->count());

        foreach ($products as $product) {
    if (!$product->thumbnail_img) continue;

    $originalPath = public_path($product->thumbnail_img);
    if (!File::exists($originalPath)) continue;

    $webpName = pathinfo($product->thumbnail_img, PATHINFO_FILENAME) . '.webp';
    $webpPath = 'uploads/products/thumbnail/webp/' . $webpName;
    $fullWebpPath = public_path($webpPath);

    if (convertToWebP($originalPath, $fullWebpPath)) {
        $product->thumbnail_webp = $webpPath;
        $product->save();
        $this->info("Converted: {$product->thumbnail_img} -> {$webpPath}");
    } else {
        $this->warn("Skipped: {$product->thumbnail_img}");
    }
}

        $this->info('All thumbnails converted to WebP!');
        return 0;
    }
}
