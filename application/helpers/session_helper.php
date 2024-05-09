
<?php
if (!function_exists('get_session_model_data')) {
    function get_session_model_data() {
        $CI =& get_instance();
        return $CI->session->userdata('session_model');
    }
}

if (!function_exists('get_session_model_variant_data')) {
    function get_session_model_variant_data() {
        $CI =& get_instance();
        return $CI->session->userdata('session_model_variant');
    }
}
