<?php
include __DIR__ ."/../vendor/autoload.php";
class Format
{
public function DateFormat($date)
{
     return date('F j, Y, g:i a',strtotime($date));
}
public function textShorten($text,$limit = 400)
{
    $text = $text." ";
    $text = substr($text,0,$limit);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."......";
    return $text;
}
public function validation($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

public function title()
{
	$db = new Database();
	$fm = new Format();
    $path = $_SERVER['SCRIPT_FILENAME'];
    $title = basename($path,'.php');
    //$title = str_replace("_",'',$title);
    if ($title == 'index')
    {
        $title = 'Home';
    }elseif ($title == 'contact')
    {
        $title = 'contact';
    }
    return $title = ucfirst($title);
}
}