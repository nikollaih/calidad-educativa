<?php
// En app/Helpers/SvgHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SvgHelper
{
    public static function getCached($path)
    {
        $fullPath = public_path($path);

        // Usa el path y la fecha de modificación como clave de cache
        $cacheKey = 'svg_' . md5($path . File::lastModified($fullPath));

        return Cache::rememberForever($cacheKey, function () use ($fullPath) {
            return File::get($fullPath);
        });
    }
}
