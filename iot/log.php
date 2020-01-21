<?php
class Log
{
    public static function createLog($post_data)
    {
        $handle = fopen("C:\wamp64\www\PHP\barcode.txt", "a+");
        fwrite($handle, $post_data ."\n");
        fclose($handle);
    }

}


 ?>
