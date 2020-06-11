<?php
function uri_segment($string = false)
{
    $ci = &get_instance();

    if ($string === false) {
        return $ci->uri->uri_string();
    }

    $ary = explode(",", $string);
    foreach ($ary as $val) {
        $mix .= $ci->uri->slash_segment($val);
    }
    return trim($mix, "/ ");
}

// usage
// public function index($type, $id)
// {
//     echo uri_segment();             // web/index/article/123
//     echo uri_segment("1");          // web
//     echo uri_segment("1,2,3,4");    // web/index/article/123
//     echo uri_segment("1,4");        // web/123
// }
