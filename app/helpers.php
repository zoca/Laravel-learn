<?php
if (!function_exists('image_size')) {
    function image_size($path, $size)
    {
        $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
        return str_replace('.' . $fileExtension, $size . '.' . $fileExtension, $path);
    }
}
