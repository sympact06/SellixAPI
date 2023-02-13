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

$API = dirname(__DIR__) . '/API.php';
if (file_exists($API)) {
    require_once $API;
} else {
    die('Config file does not exist. Please create one.');
}

// Secret
$secret = "SECRET_HERE";
// Product ID
$productid = 1;
// If you want to send the customer an email, you can use the following code:
$email = "noreply@yourdomain.com"; // Will send an email to you instead of the customer
// Otherwise, you can use the following code:
$email = "EMAIL_HERE";
// Product Title
$title = "Payment Example";
// Where you want to redirect the customer after the payment succeeded or failed
$redirectionUrl = "https://example.com/"


header("location: " . SellixAPI::getPaymentLink($secret, $productid, $email, $title, $redirectionUrl));