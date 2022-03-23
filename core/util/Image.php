<?php


namespace Core\Util;

trait Image
{
    public function saveImage($image, $path, $name = null)
    {
        $nameImage = $name ? $name.".".substr($image['type'], 6) : date("Y-m-d-H-i-s").".".substr($image['type'], 6);
        $imgTmp = $image['tmp_name'];
        $base = "asset/images/$path/$nameImage";
        if (is_uploaded_file($imgTmp)) {
            if (move_uploaded_file($imgTmp, $base)) {
                return $base;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function removeImage($path)
    {
        $fullPath = fix_path(BASE_PATH."/".trim($path ?? "/", "/"));
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        if (!empty($extension)) unlink($fullPath);
    }
}