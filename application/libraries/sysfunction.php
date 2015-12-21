<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Arterisys_Function {

    private $_ci;

    public function __construct() {
        $this->_ci = & get_instance();
    }

    public function array_remove_empty($haystack) {
        foreach ($haystack as $key => $value) :
            if (is_array($value)) :
                $haystack[$key] = array_remove_empty($haystack[$key]);
            endif;

            if (empty($haystack[$key])) :
                unset($haystack[$key]);
            endif;
        endforeach;

        return $haystack;
    }

    public function str_respace($name) {
        $string = str_replace("-", " ", "$name");
        return $string;
    }

    public function character_url($string) {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), '-', $string);

        return trim($string, '-');
    }

    public function character_underline($string) {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), '-', $string);

        return trim($string, '_');
    }

    public function character_normal($string) {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), ' ', $string);
        return trim($string, ' ');
    }

    public function remove_image($image = null, $thumbnail = null) {
      if($image != null) {
          if(file_exists($image)) {
            unlink($image);
          }
      }
      if($thumbnail != null) {
          if(file_exists($thumbnail)) {
            unlink($thumbnail);
          }
      }
    }

    public function upload_regex_character($url, $name_image, $mode = null) {
        $name               = str_replace(" ", "_", "$name_image");
        $names              = str_replace(",", "", "$name");
        $explode_string     = explode(".", $name);
        $name_old_original  = preg_replace("/^(.+?);.*$/", "\\1", $names);
        $name_original      = strtolower($name_old_original);
        $extension_unclear  = $explode_string[count($explode_string)-1];
        $file_type          = preg_replace("/^(.+?);.*$/", "\\1", $extension_unclear);
        $new_name_change    = $name_original;

        if ($mode == 'thumbs') :
            return $url . "thumbs/" . strtolower(str_replace(' ', '_', 'small-' . $new_name_change));
        else :
            return $url . strtolower(str_replace(' ', '_', $new_name_change));
        endif;
    }

    public function upload_single_image($url, $name_image) {
        $name               = str_replace(" ", "_", "$name_image");
        $names              = str_replace(",", "", "$name");
        $explode_string     = explode(".", $name);
        $name_old_original  = preg_replace("/^(.+?);.*$/", "\\1", $names);
        $name_original      = strtolower($name_old_original);
        $extension_unclear  = $explode_string[count($explode_string)-1];
        $file_type          = preg_replace("/^(.+?);.*$/", "\\1", $extension_unclear);
        $new_name_change    = $name_original;
        $original_src       = $url . strtolower(str_replace(' ', '_', $new_name_change));
        $thumbnail_src      = $url . "thumbs/" . strtolower(str_replace(' ', '_', 'small-' . $new_name_change));

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $original_src)) :
            chmod("$original_src", 0777);
        else :
            $validate = "Gagal melakukan proses upload file.Hal ini biasanya disebabkan ukuran file yang terlalu besar atau koneksi jaringan anda sedang bermasalah";
            echo "<script type='text/javascript'> alert('" . $validate . "'); </script>";
            exit;
        endif;

        list($width, $height) = getimagesize($original_src);
        $x_height   = ($height >= 1024) ? 1024 : $height;
        $diff       = $height / $x_height;
        $x_width    = $width / $diff;

        $n_height   = 220;
        $diff       = $height / $n_height;
        $n_width    = $width / $diff;

        if (($_FILES['userfile']['type'] == "image/jpeg") ||
            ($_FILES['userfile']['type'] == "image/png") ||
            ($_FILES['userfile']['type'] == "image/gif")) :
            $im = @ImageCreateFromJPEG($original_src) or    // Read JPEG Image
            $im = @ImageCreateFromPNG($original_src) or     // or PNG Image
            $im = @ImageCreateFromGIF($original_src) or     // or GIF Image
            $im = false;                                    // If image is not JPEG, PNG, or GIF


            if (!$im) :
                $validate = "Gagal membuat thumbnail";
                echo "<script type='text/javascript'> alert('" . $validate . "'); </script>";
                exit;
            else :
                $newimage2 = @imagecreatetruecolor($x_width, $x_height);
                @imageCopyResized($newimage2, $im, 0, 0, 0, 0, $x_width, $x_height, $width, $height);
                @ImageJpeg($newimage2, $original_src);
                chmod("$original_src", 0777);

                $newimage = @imagecreatetruecolor($n_width, $n_height);
                @imageCopyResized($newimage, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
                @ImageJpeg($newimage, $thumbnail_src);
                chmod($thumbnail_src, 0777);
            endif;
        endif;
    }

    public function upload_multiple_image($url, $name_image, $index) {
        $name               = str_replace(" ", "_", "$name_image");
        $names              = str_replace(",", "", "$name");
        $explode_string     = explode(".", $name);
        $name_old_original  = preg_replace("/^(.+?);.*$/", "\\1", $names);
        $name_original      = strtolower($name_old_original);
        $extension_unclear  = $explode_string[count($explode_string)-1];
        $file_type          = preg_replace("/^(.+?);.*$/", "\\1", $extension_unclear);
        $new_name_change    = $name_original;
        $original_src       = $url . strtolower(str_replace(' ', '_', $new_name_change));
        $thumbnail_src      = $url . "thumbs/" . strtolower(str_replace(' ', '_', 'small-' . $new_name_change));

        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$index], $original_src)) :
            chmod("$original_src", 0777);
        else :
            $validate = "Gagal melakukan proses upload file.Hal ini biasanya disebabkan ukuran file yang terlalu besar atau koneksi jaringan anda sedang bermasalah";
            echo "<script type='text/javascript'> alert('" . $validate . "'); </script>";
            exit;
        endif;

        list($width, $height) = getimagesize($original_src);
        $x_height   = ($height >= 5000) ? 5000 : $height;
        $diff       = $height / $x_height;
        $x_width    = $width / $diff;

        $n_height   = 220;
        $diff       = $height / $n_height;
        $n_width    = $width / $diff;

        if (($_FILES['userfile']['type'][$index] == "image/jpeg") ||
            ($_FILES['userfile']['type'][$index] == "image/png") ||
            ($_FILES['userfile']['type'][$index] == "image/gif")) :
            $im = @ImageCreateFromJPEG($original_src) or  // Read JPEG Image
            $im = @ImageCreateFromPNG($original_src) or   // or PNG Image
            $im = @ImageCreateFromGIF($original_src) or   // or GIF Image
            $im = false;                                  // If image is not JPEG, PNG, or GIF

            if (!$im) :
                $validate = "Gagal membuat thumbnail";
                echo "<script type='text/javascript'> alert('" . $validate . "'); </script>";
                exit;
            else :
                $newimage2 = @imagecreatetruecolor($x_width, $x_height);
                @imageCopyResized($newimage2, $im, 0, 0, 0, 0, $x_width, $x_height, $width, $height);
                @ImageJpeg($newimage2, $original_src);
                chmod("$original_src", 0777);

                $newimage = @imagecreatetruecolor($n_width, $n_height);
                @imageCopyResized($newimage, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
                @ImageJpeg($newimage, $thumbnail_src);
                chmod($thumbnail_src, 0777);
            endif;
        endif;
    }

    public function upload_file($url, $name_file) {
        $name               = str_replace(" ", "_", "$name_file");
        $explode_string     = explode(".", $name);
        $name_old_original  = preg_replace("/^(.+?);.*$/", "\\1", $explode_string[0]);
        $name_original      = strtolower($name_old_original);
        $extension_unclear  = $explode_string[count($explode_string)-1];

        $file_type        = preg_replace("/^(.+?);.*$/", "\\1", $extension_unclear);
        $file_type_new    = strtolower($file_type);
        $name_change      = $name_original;
        $new_name_change  = $name_change . '.' . $file_type_new;
        $original_src     = $url;

        $config["file_name"]      = $new_name_change; //dengan eekstensi
        $config['upload_path']    = $original_src; //link folder upload
        $config['allowed_types']  = "*";
        /*
        $config['allowed_types']  = "exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|rar|zip|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xls|xlsx|csv";
        $config['max_size']       = "5000000";
        $config['max_width']      = "1200";
        $config['max_height']     = "1200";
        */
        $this->_ci->load->library("upload", $config);

        if (!$this->_ci->upload->do_upload()) {
          echo $this->_ci->upload->display_errors();
        }
    }

}

/* End of file my_function.php */
/* Location: ./application/libraries/my_function.php */
