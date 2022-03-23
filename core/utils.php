<?php

function fix_path($path)
{
    $path = str_replace('\\', '/', $path);
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}
function mystrlen($str): int
{
    return mb_strlen($str, "UTF-8");
}
function contains($haystack, $needle, $caseSensitive = false): bool
{
    return $caseSensitive ? !(strpos($haystack, $needle) === FALSE) : !(stripos($haystack, $needle) === FALSE);
}
function formattedDateSql($date, $isTimestamp = false): string
{
    if ($date) {
        $time = $isTimestamp ? $date : strtotime($date);
        $year = date("Y", $time);
        $month = date("m", $time);
        $day = date("d", $time);
        $hIsa = date("h:i:sa", $time);
        return sprintf("%s%s%s", gregorian_to_jalali($year, $month, $day, "/"), " ", $hIsa);
    } else {
        return "تاریخ ثبت نشده";
    }
}
function timeAgo($time_ago): string
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );

    if($seconds <= 60){
        return "همین الان";
    } else if($minutes <=60) {
        return $minutes == 1 ? "یک دقیقه قبل" : "$minutes دقیقه قبل ";
    } else if($hours <=24) {
        return $hours == 1 ? "یک ساعت قبل" : "$hours ساعت قبل ";
    } else if($days <= 7) {
        return $days == 1 ? "دیروز" : "$days روز قبل ";
    } else if($weeks <= 4.3) {
        return $weeks == 1 ? "یک هفته قبل" : "$weeks هفته قبل ";
    } else if($months <=12) {
        return $months == 1 ? "یک ماه قبل" : "$months ماه قبل ";
    } else {
        return $years == 1 ? "یک سال قبل" : "$years سال قبل ";
    }
}
function isRefreshPage(): bool
{
    return isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === "max-age=0";
}
function isOpenPageAjax(): bool
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
function activePage($page): string
{
    $url = explode("/", urldecode($_SERVER['REQUEST_URI']));
    $endUrl = end($url);
    return $page == $endUrl ? "active" : "";
}
function dump($variable, $isPrint = false,$die = true)
{
    echo "<pre>";
    !$isPrint ? var_dump($variable) : print_r($variable);
    echo "</pre>";
    if ($die) exit();
}
