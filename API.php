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

class SellixAPI
{
    public static function getPaymentLink($secret, $productid, $email, $title, $redirectionUrl)
    {
        if (empty($email) || empty($title) || empty($redirectionUrl)) {
            throw new Exception('Email address, title, and redirection URL are all required.');
        }

        $data = [
            "title" => $title,
            "product_id" => $productId,
            "quantity" => 1,
            "email" => $email,
            "white_label" => false,
            "return_url" => $redirectionUrl,
        ];

        $options = [
            "http" => [
                "header" =>
                    "Content-type: application/json\r\n" .
                    "Authorization: Bearer $secret",
                "method" => "POST",
                "content" => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents(
            "https://dev.sellix.io/v1/payments",
            false,
            $context
        );
        return $result;
    }
}