<?php

if (!function_exists('escape_str')) {
    function escape_str($str, $like = FALSE) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escape_str($val, $like);
            }

            return $str;
        }

        $str = is_resource($this->conn_id) ? mysql_real_escape_string($str, $this->conn_id) : addslashes($str);

        // escape LIKE condition wildcards
        if ($like === TRUE) {
            return str_replace(array($this->_like_escape_chr, '%', '_'), array($this->_like_escape_chr . $this->_like_escape_chr, $this->_like_escape_chr . '%', $this->_like_escape_chr . '_'), $str);
        }

        return $str;
    }

}