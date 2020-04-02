<?php
namespace common\plugins\spay;
// require_once('log.php');
/**
 * Sarawak Pay module
 */
class SarawakPay
{
    const SP_PUBLIC_KEY          = "/app/common/plugins/spay/sarawakpay_public_key.pem";
    const MERCHANT_PUBLIC_KEY    = "/app/common/plugins/spay/merchant_public_key.key";
    const MERCHANT_PRIVATE_KEY   = "/app/common/plugins/spay/merchant_private_key.key";

    const STATUS_SUCCESS = 1;    //购买成功
    const STATUS_PENDING = 0;   //购买中

    /**
     * @param  string  $url   Sarawak pay api
     * @param  string  $data  JSON data
     * @return string         JSON string
     */
    public static function post($url, $data)
    {
        $signedData = json_decode($data, 320);
        $signedData['sign'] = Encryption::generateSignature($data, self::MERCHANT_PRIVATE_KEY);

        $encryptedData = Encryption::encrypt(json_encode($signedData, 320), self::SP_PUBLIC_KEY);

        $payload = "FAPView=JSON&formData=" . str_replace('+', '%2B', $encryptedData);
		//echo $payload;
        //echo "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close ($ch);
		//echo $response;
        $decrypted_response = Encryption::decrypt($response, self::MERCHANT_PRIVATE_KEY);

        // Verify Server Response
        if (Encryption::verifySignature($decrypted_response, self::SP_PUBLIC_KEY)) {
            return $decrypted_response;
        }

        return false;
    }

    /**
     * @param  string  $data  Encrypted formData
     * @return string         Decrypted JSON string
     */
    public static function decrypt($data)
    {
        return Encryption::decrypt($data, self::MERCHANT_PRIVATE_KEY);
    }
}
