<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Extension;
use App\Models\ProductStocks;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function displayImage($image,$isAvatar = false)
{
    if (file_exists($image) && is_file($image)) {
        return asset($image);
    } elseif ($isAvatar) {
        return asset('assets/images/avatar.jpg');
    } else {
        return asset('assets/images/default.jpg');
    }
}

function verification_code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country =  @$xml->geoplugin_countryName;
    $city =     @$xml->geoplugin_city;
    $area =     @$xml->geoplugin_areaCode;
    $code =     @$xml->geoplugin_countryCode;
    $long =     @$xml->geoplugin_longitude;
    $lat =      @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}

function osBrowser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $osPlatform = "Unknown OS Platform";
    $osArray = array(
        '/windows nt 11/i' => 'Windows 11',
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($osArray as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $osPlatform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browserArray = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browserArray as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    $data['os_platform'] = $osPlatform;
    $data['browser'] = $browser;

    return $data;
}

function summary($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}

function systemDetails()
{
    $system['name'] = 'Job Portal';
    $system['version'] = '1.0';
    return $system;
}

function searchForKey($value, $key, $array)
{
    foreach ($array as $k => $val) {
        if (@$val[$key] == $value) {
            return $k;
        }
    }
    return null;
}


function sendEmail($user, $type = null, $shortCodes = [],$log=true)
{
    $general = Setting::first();
    $emailTemplate = EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    $message = summary("{{fullname}}", $user->fullname, $general->email_template);
    $message = summary("{{username}}", $user->username, $message);
    $message = summary("{{message}}", $emailTemplate->email_body, $message);
    if (empty($message)) {
        $message = $emailTemplate->email_body;
    }
    foreach ($shortCodes as $code => $value) {
        $message = summary('{{' . $code . '}}', $value, $message);
    }
    $config = json_decode($general->mail_config);
    $config_mail = $general->mail;
    if($log){
        $emailLog = new EmailLog();
        $emailLog->user_id = $user->id;
        $emailLog->company_id = $user->id;
        $emailLog->user_type = $user->id;
        $emailLog->mail_sender = $config->name;
        $emailLog->email_from = $general->site_name.' '.$general->email_from;
        $emailLog->email_to = $user->email;
        $emailLog->subject = $emailTemplate->subj;
        $emailLog->message = $message;
        $emailLog->save();

    }
        sendSmtpMail($config, $config_mail, $user->email, $user->username, $emailTemplate->subj, $message,$general);
}


function sendSmtpMail($config, $config_mail, $receiver_email, $receiver_name, $subject, $message,$setting)
{
    // dd($receiver_email);
    $mail = new PHPMailer(true);
    $setting = Setting::first();
    try {
        $mail->isSMTP();
        $mail->Host       = $config_mail->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config_mail->username;
        $mail->Password   = $config_mail->password;
        if ($config_mail->encryption == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port    = $config_mail->port;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($setting->email_from, $setting->site_name);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($setting->email_from, $setting->site_name);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function sendRegularEmail($email, $subject, $message_data, $receiver_name = '')
{
    $setting = Setting::first();
    $message = summary("{{fullname}}", $receiver_name, $setting->email_template);
    $message = summary("{{username}}",$receiver_name, $message);
    $message = summary("{{message}}", $message_data, $message);
    $config = json_decode($setting->mail_config);
    $config_mail = $setting->mail;
    sendSmtpMail($config, $config_mail, $email, $receiver_name, $subject, $message, $setting);
}

function loadReCaptcha()
{
    $reCaptcha = Extension::where('act', 'google-recaptcha2')->where('status', 1)->first();
    return $reCaptcha ? $reCaptcha->generateScript() : '';
}

function alert($user, $type, $shortCodes = null)
{
    sendEmail($user, $type, $shortCodes);
}


function showDateTime($date, $format = 'j F Y h:i:s A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function numberFormat($number, $precision = null)
{
  
    $number = is_numeric($number) ? (float)$number : 0;

    if ($precision !== null) {
        // Ensure $precision is an integer
        $precision = is_numeric($precision) ? (int)$precision : 0;

        // Round with specified precision
        $number = round($number, $precision);
    }

    return $number;
}

function trxNumber(){
    return Str::random();
}

function getUser(){
    $user = 0;
    if(auth()->user()){
        $user = auth()->user();

    }
    if(auth()->guard('company')->user()){
        $user = auth()->guard('company')->user();

    }
    return $user;
}


function menuActive($routename)
{
    if (request()->routeIs($routename)) {
        return [
            'sidebar-menu-active',
            'mm-show',
            'mm-active',
        ];
    }else{
        return [
            '',
            '',
            ''
        ];
    }
}

function checkWishList($product_id){
    $user_id    = auth()->user()->id??null;
    $wishlist   = session()->get('wishlist')??[];

    $wishlist   = array_keys($wishlist);

    if(in_array($product_id, $wishlist)){
        return true;
    }else{
        return false;
    }
}

function combinations($arrays, $i = 0) {
    if(sizeof($arrays) == 1){
       foreach($arrays[0] as $arr){
           $temp_array[]    = $arr;
           $final_array[]   =  $temp_array;
           unset($temp_array);
        }
       return  $final_array;
    }
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }
    // get combinations from subsequent arrays
    $tmp = combinations($arrays, $i + 1);
    $result = array();
    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ?
                array_merge(array($v), $t) :
                array($v, $t);
        }
    }
    return $result;
}
function getProuductAttributes($pid, $aid)
{
    $data = App\Models\ProductAttribute::where('status', 1)->where('product_id', $pid)->where('attribute_id', $aid)->with(['product', 'productAttribute'])->get();

    return $data;
}


function getStockData($pid, $attr)
{
    $a = ProductStocks::where('product_id', $pid)->where('attributes', $attr)->first();
    if ($a) {
        return $a;
    }

    return false;
}

function showAvailableStock($pid, $attr)
{
//    dd($pid);
//    dd($attr);

//    $a = ProductStocks::where('product_id', $pid)->where('attributes', $attr)->get();
    $a = ProductStocks::where('product_id', $pid)->whereJsonContains('attributes', $attr)->first();
//    dd($a);
    if ($a) {
        return $a->quantity;
    }
    return 0;
}

function shortContent($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}

function shouldDisplayImage($image)
{
    return $image->product_id && is_null($image->product_attribute_id);
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}
function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function sendSMS($to, $body)
{
    $general = Setting::first();
    $config = json_decode($general->sms);
    //dd($body);
    $url = $config->url;
    $key = $config->api_key;
    $id = $config->sender_id;
    $data = [
        "api_key" => $key,
        "type" => "unicode",
        "contacts" => $to,
        "senderid" => $id,
        "msg" => $body,
    ];
    //dd($url);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    // dd($response);
    return $response;
    //dd("not found");
    return true;
}