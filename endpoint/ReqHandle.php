<?php

/*
Copyright (C) 2023, Olivier Flentge

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/


$config_file = dirname(__DIR__) . '/config.php';
if (file_exists($config_file)) {
    require $config_file;
} else {
    die('Config file does not exist. Please create one.');
}


$payload = file_get_contents("php://input");
$secret = $Sellix_Secret;
$header_signature = $_SERVER["HTTP_X_SELLIX_SIGNATURE"];
$signature = hash_hmac("sha512", $payload, $secret);

class SellixAPI {
    public static function hash_equals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        }
        $res = $str1 ^ $str2;
        $ret = 0;
        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
        return !$ret;
    }
    
    public static function getData() {
        if (!hash_equals($signature, $header_signature)) {
            http_response_code(401);
            die("Unauthorized");
        }
        return json_decode($payload, true);
    }
    
    public static function getCustomerData($key) {
        $data = getData();
        return $data["customer"][$key];
    }
    
    public static function getProductIDBought() {
        return getData()["product_id"];
    }
    
    public static function getCustomerEmail() {
        return getCustomerData("email");
    }
    
    public static function getCustomerName() {
        return getCustomerData("name");
    }
    
    public static function getCustomerID() {
        return getCustomerData("id");
    }
    
    public static function getCustomerIP() {
        return getCustomerData("ip");
    }
    
    public static function getCustomerCountry() {
        return getCustomerData("country");
    }
    
    public static function getCustomerCity() {
        return getCustomerData("city");
    }
    
    public static function getCustomerState() {
        return getCustomerData("state");
    }
    
    public static function getCustomerZip() {
        return getCustomerData("zip");
    }
    
    public static function getCustomerPhone() {
        return getCustomerData("phone");
    }
    
    public static function getCustomerAddress() {
        return getCustomerData("address");
    }
}


// Example Version to use webhook
// This will check if the productid is 1 and if the email is info@test.com 

if (SellixAPI::getProductIDBought() == 1 && SellixAPI::getCustomerEmail() == "info@test.com") {
    // Valid!
} else {
    // Invalid!
}

?>
