<?php

use App\Models\User;
use ArmanTadbir\Score\Models\Cost;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Propaganistas\LaravelPhone\PhoneNumber;
use ArmanTadbir\Setting\Models\Definition;


if (!function_exists('clearCache')) {
    function clearCache()
    {
        if (auth()->check()) {
            try {
                $token = cache()->get("token_site_" . auth()->id());
                Log::info("totken", [$token, \Illuminate\Support\Facades\Cookie::get("token")]);
                $headers = [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ];
                $client = new \GuzzleHttp\Client([
                    "base_uri" => env("APP_URL_API"),
                    'timeout' => 6,
                    'connect_timeout' => 6,
                    'headers' => $headers]);
                $response = $client->get("api/v1/clearCache", []);
            } catch (Exception $exception) {
                Log::info("error clear Cache", [
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception->getLine(),
                ]);
            }
        }
    }
}


if (!function_exists('getLayout')) {
    function getLayout()
    {
        $domain = substr(request()->root(), 7);
        if (Str::contains(env("APP_URL_PANEL"), $domain))
            return "layouts.app";
        return "layouts.panel";
    }
}

if (!function_exists('sitackCall')) {
    function sitackCall($type, $id)
    {
        $response = [];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env("BASE_URL_SITAK") ,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('type' => $type, 'value' => $id),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . env("TOKENSITAK")
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            logger("result request", [$response]);
        } catch
        (\Exception $exception) {
            logger("exption 2", [$exception, $exception->getCode(), $exception->getMessage(), $exception->getTrace()]);
            $result['status'] = $exception->getCode();
            return [
                $exception->getMessage(),
                $exception->getLine()
            ];
        }
        return $response;
    }

}

if (!function_exists('getPriceFormat')) {
    function getPriceFormat($money)
    {
        return number_format($money, 0);

    }
}
if (!function_exists('getBetweenMonth')) {
    function getBetweenMonth($month): array
    {
        if ($month == 12)
            $year = convertNumber(toJalali(now()->subYear(1), "Y"));
        else
            $year = convertNumber(toJalali(now(), "Y"));
        $days = (new Jalalian($year, $month, 15))->getMonthDays();
        $date_between[] = (new Jalalian($year, $month, 1))->toCarbon()->format("Y-m-d"); // [2016, 5, 7]
        $date_between[] = (new Jalalian($year, $month, $days))->toCarbon()->format("Y-m-d"); // [2016, 5, 7]
        return $date_between;
        switch ($month) {
            case 1;
                return ["2021-03-21", "2021-04-20"];
                break;
            case 2;
                return ["2021-04-21", "2021-05-21"];
                break;
            case 3;
                return ["2021-05-22", "2021-06-21"];
                break;
            case 4;
                return ["2021-06-22", "2021-07-22"];
                break;
            case 5;
                return ["2021-07-23", "2021-08-22"];
                break;
            case 6;
                return ["2021-08-23", "2021-09-22"];
                break;
            case 7;
                return ["2021-09-23", "2021-10-22"];
                break;
            case 8;
                return ["2021-10-23", "2021-11-21"];
                break;
            case 9;
                return ["2021-11-22", "2021-12-21"];
                break;
            case 10;
                return ["2021-12-21", "2022-01-20"];
                break;
            case 11;
                return ["2022-01-21", "2021-02-19"];
                break;
            case 12;
                return ["2022-02-20", "2022-03-20"];
                break;

        }
    }
}

if (!function_exists('getNameMonth')) {
    function getNameMonth($month): string
    {
        switch ($month) {
            case 1;
                return "فروردین";
                break;
            case 2;
                return "اردیبهشت";
                break;
            case 3;
                return "خرداد";
                break;
            case 4;
                return "تیر";
                break;
            case 5;
                return "مرداد";
                break;
            case 6;
                return "شهریور";
                break;
            case 7;
                return "مهر";
                break;
            case 8;
                return "آبان";
                break;
            case 9;
                return "آذر";
                break;
            case 10;
                return "دی";
                break;
            case 11;
                return "بهمن";
                break;
            case 12;
                return "اسفند";
                break;

        }
    }
}

if (!function_exists('getUnitNumber')) {
    function getUnitNumber($number)
    {
        $unit = "";
        $number = convertNumber($number);
        if ($number >= 99999999999)
            $unit = "تریلیون";
        elseif ($number >= 999999999)
            $unit = "میلیارد";
        elseif ($number >= 99999)
            $unit = "میلیون";
        elseif ($number >= 999)
            $unit = "هزار";
        return number_format($number, 0) . " " . $unit;

    }
}

if (!function_exists('getContents')) {
    function getContents($str, $startDelimiter, $endDelimiter)
    {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $contents;
    }
}

if (!function_exists('getCost')) {
    function getCost($wage, $type)
    {
        $cost_return = 0;
        $costs = cache()->rememberForever('cost_list_by_price_asc', function () {
            return Cost::orderBy("price", "asc")->get()->groupBy("type");
        });
        $marketer_costs = $costs[$type];
        $cost = collect($marketer_costs)->where("price", "<=", $wage)->sortByDesc("price")->first();
        if ($cost) {
            $befor_curent_level = collect($marketer_costs)->where("price", "<", $cost->price)->sortByDesc("price")->first();
            $cost_broker = 0;
            if ($befor_curent_level && $befor_curent_level->percent == 0) {
                $cost_broker = $wage * ($cost->percent / 100);
            } elseif ($cost->percent) {
                if ($befor_curent_level)
                    $cost_broker = $befor_curent_level->price_cost;
                $cost_broker += (($wage - ($cost->price - 1)) * ($cost->percent / 100));
            } else {
                $cost_broker = 0;
            }

            $cost_return = $cost_broker;

        }
        return $cost_return;
    }
}

if (!function_exists('getScore')) {
    function getScore($cost)
    {
        $point = 0;
        $every_score = cache()->rememberForever("definition_ny0GB4xT3e", function () {
            return Definition::where("key", env("cost_public_marketer", "ny0GB4xT3e"))->first();
        });
        $point = $cost / $every_score->value;

        return $point;
    }
}

if (!function_exists('getCurl')) {
    function getCurl($base_url, $url, $data = [], $method = "GET", $port = null)
    {
        $res = [];
        $client = new Client(['base_uri' => $base_url]);
        try {
            $res = $client->request($method, $url, $data);
        } catch (GuzzleException $e) {
            logger($e->getMessage());
        }

        return $res ? json_decode($res->getBody()) : $res;
    }
}


if (!function_exists('number_format')) {
    function number_format($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',')
    {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
            $number[1] = round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }
}

if (!function_exists('groupToWords')) {
    function groupToWords($group)
    {
        $digit1 = array(
            0 => 'صفر',
            1 => 'یک',
            2 => 'دو',
            3 => 'سه',
            4 => 'چهار',
            5 => 'پنج',
            6 => 'شش',
            7 => 'هفت',
            8 => 'هشت',
            9 => 'نه',
        );
        $digit1_5 = array(
            1 => 'یازده',
            2 => 'دوازده',
            3 => 'سیزده',
            4 => 'چهارده',
            5 => 'پانزده',
            6 => 'شانزده',
            7 => 'هفده',
            8 => 'هجده',
            9 => 'نوزده',
        );
        $digit2 = array(
            1 => 'ده',
            2 => 'بیست',
            3 => 'سی',
            4 => 'چهل',
            5 => 'پنجاه',
            6 => 'شصت',
            7 => 'هفتاد',
            8 => 'هشتاد',
            9 => 'نود'
        );
        $digit3 = array(
            1 => 'صد',
            2 => 'دویست',
            3 => 'سیصد',
            4 => 'چهارصد',
            5 => 'پانصد',
            6 => 'ششصد',
            7 => 'هفتصد',
            8 => 'هشتصد',
            9 => 'نهصد',
        );
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;

        $group_array = array();

        if ($d3 != 0) {
            $group_array[] = $digit3[$d3];
        }

        if ($d2 == 1 && $d1 != 0) { // 11-19
            $group_array[] = $digit1_5[$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            $group_array[] = $digit2[$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 00
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            $group_array[] = $digit1[$d1];
        } else { // Others
            $group_array[] = $digit2[$d2];
            $group_array[] = $digit1[$d1];
        }

        if (!count($group_array)) {
            return FALSE;
        }

        return $group_array;
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $formated = number_format($number, 0, '.', ',');
        $groups = explode(',', $formated);
        $steps = array(
            1 => 'هزار',
            2 => 'میلیون',
            3 => 'بیلیون',
            4 => 'تریلیون',
            5 => 'کادریلیون',
            6 => 'کوینتریلیون',
            7 => 'سکستریلیون',
            8 => 'سپتریلیون',
            9 => 'اکتریلیون',
            10 => 'نونیلیون',
            11 => 'دسیلیون',
        );
        $steps = count($groups);

        $parts = array();
        foreach ($groups as $step => $group) {
            $t = array(
                'and' => 'و',
            );
            $group_words = groupToWords($group);
            if ($group_words) {
                $part = implode(' ' . $t['and'] . ' ', $group_words);
                if (isset($steps[$steps - $step - 1])) {
                    $part .= ' ' . $steps[$steps - $step - 1];
                }
                $parts[] = $part;
            }
        }
        return implode(' ' . $t['and'] . ' ', $parts);
    }
}

if (!function_exists('faker_url')) {
    function faker_url($type = null, $format = null, $size = null)
    {
        $type = is_array($type) ? Arr::random($type) : $type;
        $type = $type ?: Arr::random(["images", "videos", "sounds", "xml", "csv", "doc", "ppt", "pdf", "txt", "zip"]);
        if ($type == "images" && !$format) {
            $format = $format ?: Arr::random(["jpg", "png", "gif", "svg"]);
        }
        if ($type == "videos" && !$format) {
            $format = $format ?: Arr::random(["mp4", "flv", "mkv", "3gp"]);
        }
        switch ($type) {
            case "avatar":
                $url = "https://i.pravatar.cc/" . $size;
                break;
            case "images":
                if ($format == "jpg" || $format == "png") {
                    //images jpg
                    //https://sample-videos.com/img/Sample-jpg-image-100kb.jpg
                    //images png
                    //https://sample-videos.com/img/Sample-png-image-100kb.png
                    //images gif
                    //https://sample-videos.com/gif/1.gif
                    //images svg
                    //https://sample-videos.com/svg/1.svg
                    $size_array = [
                        "jpg" => ["50kb", "100kb", "200kb", "500kb", "1mb", "2mb", "5mb", "10mb"],
                        "png" => ["100kb", "200kb", "500kb", "1mb", "3mb", "5mb", "10mb"]
                    ];
                    $size = in_array($size, $size_array[$format]) ? $size : Arr::random($size_array[$format]);
                    $url = "https://sample-videos.com/img/Sample-" . $format . "-image-" . $size . "." . $format;
                } elseif ($format == "gif" || $format == "svg") {
                    $url = "https://sample-videos.com/" . $format . "/1." . $format;
                } else {
                    $url = original_url("/images/avatar/default.jpg");
                }
                break;
            //videos mp4
            //https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4
            //https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4
            //videos flv
            //https://sample-videos.com/video123/flv/720/big_buck_bunny_720p_1mb.flv
            //videos mkv
            //https://sample-videos.com/video123/mkv/720/big_buck_bunny_720p_1mb.mkv
            //videos 3gp
            //https://sample-videos.com/video123/3gp/144/big_buck_bunny_144p_1mb.3gp
            case "videos":
                $resolution = [720, 480, 360, 240];
                $size_array = [1, 2, 5, 20, 30];
                $size = in_array($size, $size_array) ? $size : Arr::random($size_array);
                $url = "https://sample-videos.com/video123/" . $format . "/" . $resolution . "/big_buck_bunny_" . $resolution . "_" . $size . "." . $format;
                break;
            case "sounds":
                $list_sound = [
                    "https://sample-videos.com/audio/mp3/crowd-cheering.mp3",
                    "https://sample-videos.com/audio/mp3/wave.mp3"
                ];
                $url = Arr::random($list_sound);
                break;
            case "xml":
                $url = "https://sample-videos.com/xls/Sample-Spreadsheet-10-rows.xls";
                break;
            case "csv":
                $url = "https://sample-videos.com/csv/Sample-Spreadsheet-10-rows.csv";
                break;

            case "doc":
                $url = "https://sample-videos.com/doc/Sample-doc-file-100kb.doc";
                break;

            case "ppt":
                $url = "https://sample-videos.com/ppt/Sample-PPT-File-500kb.ppt";
                break;

            case "pdf";
                $url = "https://sample-videos.com/pdf/Sample-pdf-5mb.pdf";
                break;

            case "txt":
                $url = "https://sample-videos.com/text/Sample-text-file-10kb.txt";
                break;

            case "zip":
                $url = "https://sample-videos.com/zip/10mb.zip";
                break;

        }
        return $url;
    }
}

if (!function_exists('faker_url')) {
    function faker_url($type = null, $format = null, $size = null)
    {
        $type = is_array($type) ? Arr::random($type) : $type;
        $type = $type ?: Arr::random(["images", "videos", "sounds", "xml", "csv", "doc", "ppt", "pdf", "txt", "zip"]);
        if ($type == "images" && !$format) {
            $format = $format ?: Arr::random(["jpg", "png", "gif", "svg"]);
        }
        if ($type == "videos" && !$format) {
            $format = $format ?: Arr::random(["mp4", "flv", "mkv", "3gp"]);
        }
        switch ($type) {
            case "avatar":
                $url = "https://i.pravatar.cc/" . $size;
                break;
            case "images":
                if ($format == "jpg" || $format == "png") {
                    //images jpg
                    //https://sample-videos.com/img/Sample-jpg-image-100kb.jpg
                    //images png
                    //https://sample-videos.com/img/Sample-png-image-100kb.png
                    //images gif
                    //https://sample-videos.com/gif/1.gif
                    //images svg
                    //https://sample-videos.com/svg/1.svg
                    $size_array = [
                        "jpg" => ["50kb", "100kb", "200kb", "500kb", "1mb", "2mb", "5mb", "10mb"],
                        "png" => ["100kb", "200kb", "500kb", "1mb", "3mb", "5mb", "10mb"]
                    ];
                    $size = in_array($size, $size_array[$format]) ? $size : Arr::random($size_array[$format]);
                    $url = "https://sample-videos.com/img/Sample-" . $format . "-image-" . $size . "." . $format;
                } elseif ($format == "gif" || $format == "svg") {
                    $url = "https://sample-videos.com/" . $format . "/1." . $format;
                } else {
                    $url = original_url("/images/avatar/default.jpg");
                }
                break;
            //videos mp4
            //https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4
            //https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4
            //videos flv
            //https://sample-videos.com/video123/flv/720/big_buck_bunny_720p_1mb.flv
            //videos mkv
            //https://sample-videos.com/video123/mkv/720/big_buck_bunny_720p_1mb.mkv
            //videos 3gp
            //https://sample-videos.com/video123/3gp/144/big_buck_bunny_144p_1mb.3gp
            case "videos":
                $resolution = [720, 480, 360, 240];
                $size_array = [1, 2, 5, 20, 30];
                $size = in_array($size, $size_array) ? $size : Arr::random($size_array);
                $url = "https://sample-videos.com/video123/" . $format . "/" . $resolution . "/big_buck_bunny_" . $resolution . "_" . $size . "." . $format;
                break;
            case "sounds":
                $list_sound = [
                    "https://sample-videos.com/audio/mp3/crowd-cheering.mp3",
                    "https://sample-videos.com/audio/mp3/wave.mp3"
                ];
                $url = Arr::random($list_sound);
                break;
            case "xml":
                $url = "https://sample-videos.com/xls/Sample-Spreadsheet-10-rows.xls";
                break;
            case "csv":
                $url = "https://sample-videos.com/csv/Sample-Spreadsheet-10-rows.csv";
                break;

            case "doc":
                $url = "https://sample-videos.com/doc/Sample-doc-file-100kb.doc";
                break;

            case "ppt":
                $url = "https://sample-videos.com/ppt/Sample-PPT-File-500kb.ppt";
                break;

            case "pdf";
                $url = "https://sample-videos.com/pdf/Sample-pdf-5mb.pdf";
                break;

            case "txt":
                $url = "https://sample-videos.com/text/Sample-text-file-10kb.txt";
                break;

            case "zip":
                $url = "https://sample-videos.com/zip/10mb.zip";
                break;

        }
        return $url;
    }
}

if (!function_exists('faker_file')) {
    function faker_file($dir = null, $type = "images", $format = "jpg", $size = "random", $fullPath = true)
    {
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name . '.' . $format;
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $url = faker_url($type, $format, $size);

        // save file
        if (function_exists('curl_exec')) {
            // use cURL
            $fp = fopen($filepath, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
            fclose($fp);
            curl_close($ch);

            if (!$success) {
                unlink($filepath);

                // could not contact the distant URL or HTTP error - fail silently.
                return false;
            }
        } elseif (ini_get('allow_url_fopen')) {
            // use remote fopen() via copy()
            $success = copy($url, $filepath);
        } else {
            return new RuntimeException('The image formatter downloads an image from a remote HTTP server. Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
        }

        return $fullPath ? $filepath : $filename;
    }
}

if (!function_exists('supportedRegions')) {
    function supportedRegions()
    {
        $supportedRegions = [
            "IR", "US", "AG", "AI", "AS", "BB", "BM", "BS", "CA", "DM", "DO", "GD", "GU", "JM", "KN", "KY", "LC",
            "MP", "MS", "PR", "SX", "TC", "TT", "VC", "VG", "VI", "RU", "KZ", "EG", "ZA", "GR", "NL", "BE", "FR", "ES", "HU",
            "IT", "VA", "RO", "CH", "AT", "GB", "GG", "IM", "JE", "DK", "SE", "NO", "SJ", "PL", "DE", "PE", "MX", "CU", "AR",
            "BR", "CL", "CO", "VE", "MY", "AU", "CC", "CX", "ID", "PH", "NZ", "SG", "TH", "JP", "KR", "VN", "CN", "TR", "IN",
            "PK", "AF", "LK", "MM", "SS", "MA", "EH", "DZ", "TN", "LY", "GM", "SN", "MR", "ML", "GN", "CI", "BF", "NE",
            "TG", "BJ", "MU", "LR", "SL", "GH", "NG", "TD", "CF", "CM", "CV", "ST", "GQ", "GA", "CG", "CD", "AO", "GW", "IO",
            "AC", "SC", "SD", "RW", "ET", "SO", "DJ", "KE", "TZ", "UG", "BI", "MZ", "ZM", "MG", "RE", "YT", "ZW", "NA", "MW",
            "LS", "BW", "SZ", "KM", "SH", "TA", "ER", "AW", "FO", "GL", "GI", "PT", "LU", "IE", "IS", "AL", "MT", "CY", "FI",
            "AX", "BG", "LT", "LV", "EE", "MD", "AM", "BY", "AD", "MC", "SM", "UA", "RS", "ME", "XK", "HR", "SI", "BA", "MK",
            "CZ", "SK", "LI", "FK", "BZ", "GT", "SV", "HN", "NI", "CR", "PA", "PM", "HT", "GP", "BL", "MF", "BO", "GY", "EC",
            "GF", "PY", "MQ", "SR", "UY", "CW", "BQ", "TL", "NF", "BN", "NR", "PG", "TO", "SB", "VU", "FJ", "PW", "WF", "CK",
            "NU", "WS", "KI", "NC", "TV", "PF", "TK", "FM", "MH", "KP", "HK", "MO", "KH", "LA", "BD", "TW", "MV", "LB", "JO",
            "SY", "IQ", "KW", "SA", "YE", "OM", "PS", "AE", "IL", "BH", "QA", "BT", "MN", "NP", "TJ", "TM", "AZ", "GE", "KG",
            "UZ",
        ];
        return $supportedRegions;
    }
}

if (!function_exists('getPhoneCountry')) {
    function getPhoneCountry($mobile)
    {
        return PhoneNumber::make($mobile, supportedRegions())->getCountry();
    }
}

if (!function_exists('toJalaliByConvert')) {
    function toJalaliByConvert($time, $format = 'Y/m/d H:i:s')
    {
        $time = Carbon::parse($time)->format($format);
        return unConvertNumber(CalendarUtils::strftime($format, strtotime($time)));
    }
}

if (!function_exists('toJalali')) {
    function toJalali($time, $format = 'Y/m/d H:i:s')
    {
        return unConvertNumber(CalendarUtils::strftime($format, strtotime($time)));
    }
}

if (!function_exists('toAgo')) {
    function toAgo($time)
    {
        return Jalalian::forge($time)->ago();
    }
}

if (!function_exists('toGregorian')) {
    function toGregorian($time, $format = 'Y/m/d H:i:s')
    {
        $time = convertNumber($time);
        $year = 1399;
        $month = 01;
        $day = 1;
        $hour = 0;
        $minute = 0;
        $second = 0;
        $date_time = explode(" ", $time);

        if (!empty($date_time)) {
            $date = explode("/", $date_time[0]);
            $year = data_get($date, 0, 1399);
            $month = data_get($date, 1, 01);
            $day = data_get($date, 2, 01);
            if (!empty($date_time[1])) {
                $time = explode(":", $date_time[1]);
                $hour = data_get($time, 0, 0);
                $minute = data_get($time, 1, 0);
                $second = data_get($time, 2, 0);
            }
        }
        return (new Jalalian($year, $month, $day, $hour, $minute, $second))->toCarbon()->format($format);
    }
}

if (!function_exists('diffDate')) {
    function diffDate($time, $format = "%y year %m  month %d day", $by = 'now')
    {
        $date = Carbon::parse($time);
        if ($by)
            $date_diff = Carbon::parse($by);
        else
            $date_diff = Carbon::now();

        $diff = $date->diff($date_diff)->format($format);


        return $diff;
    }
}

if (!function_exists('persianTime')) {
    function persianTime($time)
    {
        $today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $yesterday = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        $tomorrow = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
        $time_date = date("Y-m-d", strtotime($time));
        if ($today == $time_date) {
            return 'امروز ' . unConvertNumber(date("H:i", strtotime($time)));
        } elseif ($yesterday == $time_date) {
            return 'دیروز ' . unConvertNumber(date("H:i", strtotime($time)));
        } elseif ($tomorrow == $time_date) {
            return 'فردا ' . unConvertNumber(date("H:i", strtotime($time)));
        } else {
            $date = unConvertNumber(Jalalian::forge($time_date)->format('%y/%m/%d'));
            $date .= ' - ' . unConvertNumber(date("H:i", strtotime($time)));
            return $date;
        }
    }
}

if (!function_exists('persianTimeColor')) {
    function persianTimeColor($time)
    {
        $now = Carbon::now();
        if ($now <= $time) {
            return 'green';
        } else {
            return 'red';
        }
    }
}

if (!function_exists('arabicToPersian')) {
    function arabicToPersian($str)
    {
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', 'ي', 'ك');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', 'ی', 'ک');
        return str_replace($arabic, $persian, $str);
    }
}

if (!function_exists('convert2english')) {
    function convert2english($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }
}

if (!function_exists('convertNumber')) {
    function convertNumber($value)
    {
        $western = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $eastern = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];
        return str_replace($eastern, $western, $value);
    }
}

if (!function_exists('unConvertNumber')) {
    function unConvertNumber($value)
    {
        $western = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $eastern = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];
        return str_replace($western, $eastern, $value);
    }
}

if (!function_exists('persianConvert')) {
    function persianConvert($string, $separator = '-')
    {
        $_transliteration = array(
            '/؆|؇|؈|؉|؊|؍|؎|ؐ|ؑ|ؒ|ؓ|ؔ|ؕ|ؖ|ؘ|ؙ|ؚ|؞|ٖ|ٗ|٘|ٙ|ٚ|ٛ|ٜ|ٝ|ٞ|ٟ|٪|٬|٭|ہ|ۂ|ۃ|۔|ۖ|ۗ|ۘ|ۙ|ۚ|ۛ|ۜ|۞|۟|۠|ۡ|ۢ|ۣ|ۤ|ۥ|ۦ|ۧ|ۨ|۩|۪|۫|۬|ۭ|ۯ|ﮧ|﮲|﮳|﮴|﮵|﮶|﮷|﮸|﮹|﮺|﮻|﮼|﮽|﮾|﮿|﯀|﯁|ﱞ|ﱟ|ﱠ|ﱡ|ﱢ|ﱣ|ﹰ|ﹱ|ﹲ|ﹳ|ﹴ|ﹶ|ﹷ|ﹸ|ٌ|ٍ|ﹸ|ﹹ|ْ|ﹺ|ﹻ|ﹼ|ً|ُ|ِ|َ|ّ|\]|\[|\}|\{|\||ٓ|ٰ|‌|ٔ|ء|ﹾ|ﹿ/' => '',
            '/أ|إ|ٱ|ٲ|ٳ|ٵ|ݳ|ݴ|ﭐ|ﭑ|ﺃ|ﺄ|ﺇ|ﺈ|ﺍ|ﺎ|𞺀|ﴼ|ﴽ|𞸀|إ|أ|آ/' => 'ا',
            '/ٮ|ݕ|ݖ|ﭒ|ﭓ|ﭔ|ﭕ|ﺏ|ﺐ|ﺑ|ﺒ|𞸁|𞸜|𞸡|𞹡|𞹼|𞺁|𞺡/' => 'ب',
            '/ڀ|ݐ|ݔ|ﭖ|ﭗ|ﭘ|ﭙ|ﭚ|ﭛ|ﭜ|ﭝ/' => 'پ',
            '/ٹ|ٺ|ٻ|ټ|ݓ|ﭞ|ﭟ|ﭠ|ﭡ|ﭢ|ﭣ|ﭤ|ﭥ|ﭦ|ﭧ|ﭨ|ﭩ|ﺕ|ﺖ|ﺗ|ﺘ|𞸕|𞸵|𞹵|𞺕|𞺵/' => 'ت',
            '/ٽ|ٿ|ݑ|ﺙ|ﺚ|ﺛ|ﺜ|𞸖|𞸶|𞹶|𞺖|𞺶/' => 'ث',
            '/ڃ|ڄ|ﭲ|ﭳ|ﭴ|ﭵ|ﭶ|ﭷ|ﭸ|ﭹ|ﺝ|ﺞ|ﺟ|ﺠ|𞸂|𞸢|𞹂|𞹢|𞺂|𞺢/' => 'ج',
            '/ڇ|ڿ|ݘ|ﭺ|ﭻ|ﭼ|ﭽ|ﭾ|ﭿ|ﮀ|ﮁ|𞸃|𞺃/' => 'چ',
            '/ځ|ݮ|ݯ|ݲ|ݼ|ﺡ|ﺢ|ﺣ|ﺤ|𞸇|𞸧|𞹇|𞹧|𞺇|𞺧/' => 'ح',
            '/ڂ|څ|ݗ|ﺥ|ﺦ|ﺧ|ﺨ|𞸗|𞸷|𞹗|𞹷|𞺗|𞺷/' => 'خ',
            '/ڈ|ډ|ڊ|ڌ|ڍ|ڎ|ڏ|ڐ|ݙ|ݚ|ﺩ|ﺪ|𞺣|ﮂ|ﮃ|ﮈ|ﮉ/' => 'د',
            '/ﱛ|ﱝ|ﺫ|ﺬ|𞸘|𞺘|𞺸|ﮄ|ﮅ|ﮆ|ﮇ|ۮ/' => 'ذ',
            '/٫|ڑ|ڒ|ړ|ڔ|ڕ|ږ|ݛ|ݬ|ﮌ|ﮍ|ﱜ|ﺭ|ﺮ|𞸓|𞺓|𞺳/' => 'ر',
            '/ڗ|ڙ|ݫ|ݱ|ﺯ|ﺰ|𞸆|𞺆|𞺦/' => 'ز',
            '/ﮊ|ﮋ|ژ|ۯ/' => 'ژ',
            '/ښ|ݽ|ݾ|ﺱ|ﺲ|ﺳ|ﺴ|𞸎|𞸮|𞹎|𞹮|𞺎|𞺮/' => 'س',
            '/ڛ|ۺ|ݜ|ݭ|ݰ|ﺵ|ﺶ|ﺷ|ﺸ|𞸔|𞸴|𞹔|𞹴|𞺔|𞺴/' => 'ش',
            '/ڝ|ﺹ|ﺺ|ﺻ|ﺼ|𞸑|𞹑|𞸱|𞹱|𞺑|𞺱/' => 'ص',
            '/ڞ|ۻ|ﺽ|ﺾ|ﺿ|ﻀ|𞸙|𞸹|𞹙|𞹹|𞺙|𞺹/' => 'ض',
            '/ﻁ|ﻂ|ﻃ|ﻄ|𞸈|𞹨|𞺈|𞺨/' => 'ط',
            '/ڟ|ﻅ|ﻆ|ﻇ|ﻈ|𞸚|𞹺|𞺚|𞺺/' => 'ظ',
            '/؏|ڠ|ﻉ|ﻊ|ﻋ|ﻌ|𞸏|𞸯|𞹏|𞹯|𞺏|𞺯/' => 'ع',
            '/ۼ|ݝ|ݞ|ݟ|ﻍ|ﻎ|ﻏ|ﻐ|𞸛|𞸻|𞹛|𞹻|𞺛|𞺻/' => 'غ',
            '/؋|ڡ|ڢ|ڣ|ڤ|ڥ|ڦ|ݠ|ݡ|ﭪ|ﭫ|ﭬ|ﭭ|ﭮ|ﭯ|ﭰ|ﭱ|ﻑ|ﻒ|ﻓ|ﻔ|𞸐|𞸞|𞸰|𞹰|𞹾|𞺐|𞺰/' => 'ف',
            '/ٯ|ڧ|ڨ|ﻕ|ﻖ|ﻗ|ﻘ|𞸒|𞸟|𞸲|𞹒|𞹟|𞹲|𞺒|𞺲|؈/' => 'ق',
            '/ػ|ؼ|ك|ڪ|ګ|ڬ|ڭ|ڮ|ݢ|ݣ|ݤ|ݿ|ﮎ|ﮏ|ﮐ|ﮑ|ﯓ|ﯔ|ﯕ|ﯖ|ﻙ|ﻚ|ﻛ|ﻜ|𞸊|𞸪|𞹪/' => 'ک',
            '/ڰ|ڱ|ڲ|ڳ|ڴ|ﮒ|ﮓ|ﮔ|ﮕ|ﮖ|ﮗ|ﮘ|ﮙ|ﮚ|ﮛ|ﮜ|ﮝ/' => 'گ',
            '/ڵ|ڶ|ڷ|ڸ|ݪ|ﻝ|ﻞ|ﻟ|ﻠ|𞸋|𞸫|𞹋|𞺋|𞺫/' => 'ل',
            '/۾|ݥ|ݦ|ﻡ|ﻢ|ﻣ|ﻤ|𞸌|𞸬|𞹬|𞺌|𞺬/' => 'م',
            '/ڹ|ں|ڻ|ڼ|ڽ|ݧ|ݨ|ݩ|ﮞ|ﮟ|ﮠ|ﮡ|ﻥ|ﻦ|ﻧ|ﻨ|𞸍|𞸝|𞸭|𞹍|𞹝|𞹭|𞺍|𞺭/' => 'ن',
            '/ؤ|ٶ|ٷ|ۄ|ۅ|ۆ|ۇ|ۈ|ۉ|ۊ|ۋ|ۏ|ݸ|ݹ|ﯗ|ﯘ|ﯙ|ﯚ|ﯛ|ﯜ|ﯝ|ﯞ|ﯟ|ﯠ|ﯡ|ﯢ|ﯣ|ﺅ|ﺆ|ﻭ|ﻮ|𞸅|𞺅|𞺥/' => 'و',
            '/ة|ھ|ۀ|ە|ۿ|ﮤ|ﮥ|ﮦ|ﮩ|ﮨ|ﮪ|ﮫ|ﮬ|ﮭ|ﺓ|ﺔ|ﻩ|ﻪ|ﻫ|ﻬ|𞸤|𞹤|𞺄|ة/' => 'ه',
            '/ؠ|ئ|ؽ|ؾ|ؿ|ى|ي|ٸ|ۍ|ێ|ې|ۑ|ے|ۓ|ݵ|ݶ|ݷ|ݺ|ݻ|ﮢ|ﮣ|ﮮ|ﮯ|ﮰ|ﮱ|ﯤ|ﯥ|ﯦ|ﯧ|ﯨ|ﯩ|ﯼ|ﯽ|ﯾ|ﯿ|ﺉ|ﺊ|ﺋ|ﺌ|ﻯ|ﻰ|ﻱ|ﻲ|ﻳ|ﻴ|𞸉|𞸩|𞹉|𞹩|𞺉|𞺩/' => 'ی',
            '/ٴ|۽|ﺀ/' => 'ء',
            '/ﻵ|ﻶ|ﻷ|ﻸ|ﻹ|ﻺ|ﻻ|ﻼ/' => 'لا',
            '/\؟/' => '',
            '/ﷲ/' => 'الله',
            '/﷼/' => 'ریال',
            '/ﷳ/' => 'اکبر',
            '/ﷴ/' => 'محمد',
            '/ﷵ/' => 'صلعم',
            '/ﷶ/' => 'رسول',
            '/ﷷ/' => 'علیه',
            '/ﷸ/' => 'وسلم',
            '/ﷹ/' => 'صلی',
            '/ﷺ/' => 'صلی الله علیه وسلم',
            '/ﷻ/' => 'جل جلاله'
        );

        $quotedReplacement = preg_quote($separator, '/');
        $merge = array(
            '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/[\s\p{Zs}]+/mu' => $separator,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        $map = $_transliteration + $merge;
        unset($_transliteration);
        return strtolower(preg_replace(array_keys($map), array_values($map), $string));
    }
}

if (!function_exists('slug_seo')) {
    function slug_seo($string, $separator = '-')
    {
        $_transliteration = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
            '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
            '/ç|ć|ĉ|ċ|č/' => 'c',
            '/Ð|Ď|Đ/' => 'D',
            '/ð|ď|đ/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
            '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
            '/ĝ|ğ|ġ|ģ/' => 'g',
            '/Ĥ|Ħ/' => 'H',
            '/ĥ|ħ/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
            '/Ĵ/' => 'J',
            '/ĵ/' => 'j',
            '/Ķ/' => 'K',
            '/ķ/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
            '/Ñ|Ń|Ņ|Ň/' => 'N',
            '/ñ|ń|ņ|ň|ŉ/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
            '/Ŕ|Ŗ|Ř/' => 'R',
            '/ŕ|ŗ|ř/' => 'r',
            '/Ś|Ŝ|Ş|Ș|Š/' => 'S',
            '/ś|ŝ|ş|ș|š|ſ/' => 's',
            '/Ţ|Ț|Ť|Ŧ/' => 'T',
            '/ţ|ț|ť|ŧ/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
            '/Ý|Ÿ|Ŷ/' => 'Y',
            '/ý|ÿ|ŷ/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž/' => 'Z',
            '/ź|ż|ž/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/' => 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f',
            '/\_/' => '-',
            '/\?|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)/' => '',
            '/\؟/' => ''
        );

        $quotedReplacement = preg_quote($separator, '/');
        $merge = array(
            '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/[\s\p{Zs}]+/mu' => $separator,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        $map = $_transliteration + $merge;
        unset($_transliteration);
        return strtolower(preg_replace(array_keys($map), array_values($map), $string));
    }
}

if (!function_exists('original_url')) {
    function original_url($url)

    {
        return env('APP_URL_ARMAN', 'http://club.test/assets') . '/' . $url;
    }
}


if (!function_exists('utf8StrLen')) {
    function utf8StrLen($str)
    {
        return preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $str, $dummy);
    }
}


if (!function_exists('makeDirectoryStorage')) {
    function makeDirectoryStorage($path)
    {
        $array_path = array_filter(explode("/", $path));
        $base_path = "";
        foreach ($array_path as $create_path) {
            $base_path .= "/" . $create_path;
            if (!is_dir(storage_path($base_path))) {
                File::makeDirectory(storage_path($base_path), $mode = 0777, true, true);

            }
        }
        // File::makeDirectory(storage_path($base_path . "/thumbs"), $mode = 0777, true, true);
    }
}
if (!function_exists('makeDirctoryPublic')) {
    function makeDirectoryPublic($path)
    {
        $array_path = array_filter(explode("/", $path));
        $base_path = "";
        foreach ($array_path as $create_path) {
            $base_path .= "/" . $create_path;
            if (!is_dir(public_path($base_path))) {
                File::makeDirectory(public_path($base_path), $mode = 0777, true, true);

            }
        }
    }
}

if (!function_exists('fagd')) {

    function fagd($str, $z = "", $method = 'normal')
    {
//        $output ="";
//        $e_output = "";
//        $num = "";
        $p_chars = array(
            'آ' => array('ﺂ', 'ﺂ', 'آ'),
            'ا' => array('ﺎ', 'ﺎ', 'ا'),
            'ب' => array('ﺐ', 'ﺒ', 'ﺑ'),
            'پ' => array('ﭗ', 'ﭙ', 'ﭘ'),
            'ت' => array('ﺖ', 'ﺘ', 'ﺗ'),
            'ث' => array('ﺚ', 'ﺜ', 'ﺛ'),
            'ج' => array('ﺞ', 'ﺠ', 'ﺟ'),
            'چ' => array('ﭻ', 'ﭽ', 'ﭼ'),
            'ح' => array('ﺢ', 'ﺤ', 'ﺣ'),
            'خ' => array('ﺦ', 'ﺨ', 'ﺧ'),
            'د' => array('ﺪ', 'ﺪ', 'ﺩ'),
            'ذ' => array('ﺬ', 'ﺬ', 'ﺫ'),
            'ر' => array('ﺮ', 'ﺮ', 'ﺭ'),
            'ز' => array('ﺰ', 'ﺰ', 'ﺯ'),
            'ژ' => array('ﮋ', 'ﮋ', 'ﮊ'),
            'س' => array('ﺲ', 'ﺴ', 'ﺳ'),
            'ش' => array('ﺶ', 'ﺸ', 'ﺷ'),
            'ص' => array('ﺺ', 'ﺼ', 'ﺻ'),
            'ض' => array('ﺾ', 'ﻀ', 'ﺿ'),
            'ط' => array('ﻂ', 'ﻄ', 'ﻃ'),
            'ظ' => array('ﻆ', 'ﻈ', 'ﻇ'),
            'ع' => array('ﻊ', 'ﻌ', 'ﻋ'),
            'غ' => array('ﻎ', 'ﻐ', 'ﻏ'),
            'ف' => array('ﻒ', 'ﻔ', 'ﻓ'),
            'ق' => array('ﻖ', 'ﻘ', 'ﻗ'),
            'ک' => array('ﻚ', 'ﻜ', 'ﻛ'),
            'گ' => array('ﮓ', 'ﮕ', 'ﮔ'),
            'ل' => array('ﻞ', 'ﻠ', 'ﻟ'),
            'م' => array('ﻢ', 'ﻤ', 'ﻣ'),
            'ن' => array('ﻦ', 'ﻨ', 'ﻧ'),
            'و' => array('ﻮ', 'ﻮ', 'ﻭ'),
            'ی' => array('ﯽ', 'ﯿ', 'ﯾ'),
            'ك' => array('ﻚ', 'ﻜ', 'ﻛ'),
            'ي' => array('ﻲ', 'ﻴ', 'ﻳ'),
            'أ' => array('ﺄ', 'ﺄ', 'ﺃ'),
            'ؤ' => array('ﺆ', 'ﺆ', 'ﺅ'),
            'إ' => array('ﺈ', 'ﺈ', 'ﺇ'),
            'ئ' => array('ﺊ', 'ﺌ', 'ﺋ'),
            'ة' => array('ﺔ', 'ﺘ', 'ﺗ')
        );
        $nastaligh = array(
            'ه' => array('ﮫ', 'ﮭ', 'ﮬ', 'ه')
        );
        $normal = array(
            'ه' => array('ﻪ', 'ﻬ', 'ﻫ')
        );
        $mp_chars = array('آ', 'ا', 'د', 'ذ', 'ر', 'ز', 'ژ', 'و', 'أ', 'إ', 'ؤ');
        $ignorelist = array('', 'ٌ', 'ٍ', 'ً', 'ُ', 'ِ', 'َ', 'ّ', 'ٓ', 'ٰ', 'ٔ', 'ﹶ', 'ﹺ', 'ﹸ', 'ﹼ', 'ﹾ', 'ﹴ', 'ﹰ', 'ﱞ', 'ﱟ', 'ﱠ', 'ﱡ', 'ﱢ', 'ﱣ',);
        if ($method == 'nastaligh') {
            $p_chars = array_merge($p_chars, $nastaligh);
        } else {
            $p_chars = array_merge($p_chars, $normal);
        }
        $str_len = utf8StrLen($str);
        preg_match_all("/./u", $str, $ar);
        for ($i = 0; $i < $str_len; $i++) {
            $str1 = $ar[0][$i];
            if (in_array($ar[0][$i + 1], $ignorelist)) {
                $str_next = $ar[0][$i + 2];
                if ($i == 2) $str_back = $ar[0][$i - 2];
                if ($i != 2) $str_back = $ar[0][$i - 1];
            } elseif (!in_array($ar[0][$i - 1], $ignorelist)) {
                $str_next = $ar[0][$i + 1];
                if ($i != 0) $str_back = $ar[0][$i - 1];

            } else {
                if (isset($ar[0][$i + 1]) && !empty($ar[0][$i + 1])) {
                    $str_next = $ar[0][$i + 1];
                } else {
                    $str_next = $ar[0][$i - 1];
                }
                if ($i != 0) $str_back = $ar[0][$i - 2];
            }
            if (!in_array($str1, $ignorelist)) {
                if (array_key_exists($str1, $p_chars)) {
                    if (!$str_back or $str_back == " " or !array_key_exists($str_back, $p_chars)) {
                        if (!array_key_exists($str_back, $p_chars) and !array_key_exists($str_next, $p_chars)) $output = $str1 . $output;
                        else $output = $p_chars[$str1][2] . $output;
                        continue;
                    } elseif (array_key_exists($str_next, $p_chars) and array_key_exists($str_back, $p_chars)) {
                        if (in_array($str_back, $mp_chars) and array_key_exists($str_next, $p_chars)) {
                            $output = $p_chars[$str1][2] . $output;
                        } else {
                            $output = $p_chars[$str1][1] . $output;
                        }
                        continue;
                    } elseif (array_key_exists($str_back, $p_chars) and !array_key_exists($str_next, $p_chars)) {
                        if (in_array($str_back, $mp_chars)) {
                            $output = $str1 . $output;
                        } else {
                            $output = $p_chars[$str1][0] . $output;
                        }
                        continue;
                    }

                } elseif ($z == "fa") {

                    $number = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", "۴", "۵", "۶", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
                    switch ($str1) {
                        case ")" :
                            $str1 = "(";
                            break;
                        case "(" :
                            $str1 = ")";
                            break;
                        case "}" :
                            $str1 = "{";
                            break;
                        case "{" :
                            $str1 = "}";
                            break;
                        case "]" :
                            $str1 = "[";
                            break;
                        case "[" :
                            $str1 = "]";
                            break;
                        case ">" :
                            $str1 = "<";
                            break;
                        case "<" :
                            $str1 = ">";
                            break;
                    }
                    if (in_array($str1, $number)) {
                        $num .= $str1;
                        $str1 = "";
                    }
                    if (!in_array($str_next, $number)) {
                        $str1 .= $num;
                        $num = "";
                    }
                    $output = $str1 . $output;
                } else {
                    if (($str1 == "،") or ($str1 == "؟") or ($str1 == "ء") or (array_key_exists($str_next, $p_chars) and array_key_exists($str_back, $p_chars)) or
                        ($str1 == " " and array_key_exists($str_back, $p_chars)) or ($str1 == " " and array_key_exists($str_next, $p_chars))) {
                        if ($e_output) {
                            $output = $e_output . $output;
                            $e_output = "";
                        }
                        $output = $str1 . $output;
                    } else {
                        $e_output .= $str1;
                        if (array_key_exists($str_next, $p_chars) or $str_next == "") {
                            $output = $e_output . $output;
                            $e_output = "";
                        }
                    }
                }
            } else {
                $output = $str1 . $output;
            }
            $str_next = null;
            $str_back = null;
        }
        return $output;
    }
}
