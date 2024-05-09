<?php
if (! function_exists('remove_country_code')) {
    function remove_country_code($mobile_number) {
        // remove all non-numeric characters from the phone number
        $mobile_number = preg_replace('/[^0-9]/', '', $mobile_number);

        // get the length of the phone number
        $length = strlen($mobile_number);

        // iterate over the phone number to find the start of the local part
        for ($i = 1; $i <= $length; $i++) {
            $local_part = substr($mobile_number, $i);

            // check if the local part is a valid phone number
            if (preg_match('/^\d{7,14}$/', $local_part)) {
                return $local_part;
            }
        }

        // if no valid local part was found, return the original phone number
        return $mobile_number;
    }
}

?>