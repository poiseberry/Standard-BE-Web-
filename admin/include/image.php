<?
ini_set('memory_limit', "1024M");

function ImageResize($from_filename, $save_filename, $in_width, $in_height, $quality = 90) {
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width = $img_info['0'];
    $height = $img_info['1'];
    $imgtype = $img_info['2'];
    $imgtag = $img_info['3'];
    $bits = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);
    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    /*
      // $sub_name = jpeg, png, gif
      $function_name = 'imagecreatefrom'.$sub_name;
      $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
     */

    $whiteBackground = imagecolorallocate($image_new, 255, 255, 255);
    imagefill($image_new, 0, 0, $whiteBackground);

    if ($sub_name == "jpeg") {
        $image = imagecreatefromjpeg($from_filename);
    } else if ($sub_name == "gif") {
        $image = imagecreatefromgif($from_filename);
    } else {
        $image = imagecreatefrompng($from_filename);
    }

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagejpeg($image_new, $save_filename, $quality);
}

function getResizePercent($source_w, $source_h, $inside_w, $inside_h) {
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1;
    }
    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;
    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}

function cropimage($path, $des, $thumb_width, $thumb_height, $extention) {
    if ($extention == "jpeg" || $extention == "jpg") {
        $image = imagecreatefromjpeg($path);
    } else if ($extention == "png") {
        $image = imagecreatefrompng($path);
    } else if ($extention == "gif") {
        $image = imagecreatefromgif($path);
    }
    $filename = $des;


    $width = imagesx($image);
    $height = imagesy($image);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ($original_aspect >= $thumb_aspect) {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    } else {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }

    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

// Resize and crop
    imagecopyresampled($thumb, $image, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0, $new_width, $new_height, $width, $height);
    imagejpeg($thumb, $filename, 90);
}

function watermark($path, $fname) {
    header('Content-Type: image/jpeg');
    $image = imagecreatefromjpeg($path);
    $imageSize = getimagesize($path);

    $watermark = imagecreatefrompng('../../img/logo.png');

    $watermark_o_width = imagesx($watermark);
    $watermark_o_height = imagesy($watermark);

    $newWatermarkWidth = ($imageSize[0] - 20) * 0.3;
    $newWatermarkHeight = ($watermark_o_height * 0.3) * ($newWatermarkWidth) / ($watermark_o_width * 0.3);

    imagecopyresized($image, $watermark, ($imageSize[0] - $newWatermarkWidth), (($imageSize[1] - 10) - $newWatermarkHeight), 0, 0, $newWatermarkWidth, $newWatermarkHeight, imagesx($watermark), imagesy($watermark));

    imagejpeg($image, $path, 90);

    imagedestroy($image);
    imagedestroy($watermark);
}

function resize($source_image, $destination, $tn_w, $tn_h, $quality = 92, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 0, 0, 0);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}

?>