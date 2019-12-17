<?php
if (!function_exists('image_size')) {
    function imageSize($path, $size)
    {
        $fileExtension = '.' . pathinfo($path, PATHINFO_EXTENSION);
        $imgPath = str_replace($fileExtension, '-' . $size . $fileExtension, $path);
        return $imgPath;
    }
}
