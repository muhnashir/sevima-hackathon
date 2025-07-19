<?php

namespace App\Services\Image;

use App\Base\ServiceBase;
use App\Repositories\ImageRepository;
use App\Responses\ServiceResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as InterventionImage;

class StoreImageService extends ServiceBase
{
    protected $data;
    protected $imageRepository;
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->imageRepository = new ImageRepository();
    }

    /**
     * Validate the data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validate() {
        return Validator::make($this->data, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:8048',
        ]);
    }

    /**
     * main method of this service
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse {

        // validate the request data
        if ($this->validate()->fails()) {
            return self::error($this->validate()->errors()->getMessages(), implode(',',$this->validate()->errors()->all()),422);
        }

        try{

            $file = $this->data['image'];
            $nameFile = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($nameFile, PATHINFO_FILENAME);
            $originalSize = $file->getSize();


            $directory = 'images/' . date('Y/m/d');
            Storage::disk('public')->makeDirectory($directory);

            $originalPath = $directory . '/' . $filename . '.' . $extension;
            Storage::disk('public')->put($originalPath, file_get_contents($file));
            $originalUrl = config('app.url') . '/storage/' . $originalPath;

            $compressedPath = $directory . '/' . $filename . '_compressed.' . $extension;
            $compressedImage = InterventionImage::make($file)
                ->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode($extension, 60);

            Storage::disk('public')->put($compressedPath, $compressedImage);
            $compressedUrl = config('app.url') . '/storage/' . $compressedPath;
            $compressedSize = Storage::disk('public')->size($compressedPath);

            // Create thumbnail
            $thumbnailPath = $directory . '/' . $filename . '_thumbnail.' . $extension;
            $thumbnailImage = InterventionImage::make($file)
                ->fit(300, 300)
                ->encode($extension, 80);

            Storage::disk('public')->put($thumbnailPath, $thumbnailImage);
            $thumbnailUrl = config('app.url') . '/storage/' . $thumbnailPath;

            $this->imageRepository->create([
                "name"          => $nameFile,
                "url"           => $originalUrl,
                "url_new"       => $compressedUrl,
                "url_compress"  => $compressedUrl,
                "url_thumbnail" => $thumbnailUrl,
                "size_old"      => $originalSize,
                "size_new"      => $compressedSize,
            ]);

            return self::success([
                "name" => $nameFile,
                "original_url" => $originalUrl,
                "compressed_url" => $compressedUrl,
                "thumbnail_url" => $thumbnailUrl,
                "original_size" => $originalSize,
                "compressed_size" => $compressedSize,
                "compression_ratio" => round(($originalSize - $compressedSize) / $originalSize * 100, 2) . '%'
            ], 'Berhasil Menambahkan dan Mengkompresi Gambar');

        }catch (Exception $th) {

            report($th);

            Log::error(self::class . __FUNCTION__, [
                'Message ' => $th->getMessage(),
                'On file ' => $th->getFile(),
                'On line ' => $th->getLine()
            ]);

            return self::error(null, $th->getMessage());

        }

    }
}
