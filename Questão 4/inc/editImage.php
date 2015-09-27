<?php
function editImage($pathToImage, $pathToNewImage, $thumbWidth, $thumbHeight, $ext)
{
    // load image and get image size
    if ($ext == "png" || $ext == "PNG") {
        $img = imagecreatefrompng("$pathToImage");
    } else {
        $img = imagecreatefromjpeg("$pathToImage");
    }
    $width = imagesx($img);
    $height = imagesy($img);

    //plano de fundo da imagem
    $img_fundo = imagecreatetruecolor($thumbWidth, $thumbHeight);
    $white = imagecolorallocate($img_fundo, 255, 255, 255);
    imagefill($img_fundo, 0, 0, $white);

    // calculate size
    $new_width = $thumbWidth;
    $new_height = floor($height * ($thumbWidth / $width));
    if ($new_height > $thumbHeight) {
        $new_width = floor($width * ($thumbHeight / $height));
        $new_height = $thumbHeight;
    }

    // create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);

    if ($ext == "png" || $ext == "PNG") {
        imagecolortransparent($img, imagecolorallocatealpha($img, 0, 0, 0, 127));
        imagealphablending($img, false);
        imagesavealpha($img, true);
        imagecolortransparent($tmp_img, imagecolorallocatealpha($tmp_img, 0, 0, 0, 127));
        imagealphablending($tmp_img, false);
        imagesavealpha($tmp_img, true);
    }

    // copy and resize old image into new image
    imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    imagecopy($img_fundo, $tmp_img, ($thumbWidth - $new_width) / 2, ($thumbHeight - $new_height) / 2, 0, 0, $new_width, $new_height);

    imagejpeg($img_fundo, "$pathToNewImage", 100);


}

?>