<?php
namespace common\plugins\spayplugins\plugins;
/**
 * Sarawak Pay module
 */
class SarawakPay
{
    const SP_PUBLIC_KEY          = "/app/common/plugins/spayplugins\keys/sarawakpay_public_key.pem";
    const MERCHANT_PUBLIC_KEY    = "/app/common/plugins/spayplugins\keys/merchant_public_key.key";
    const MERCHANT_PRIVATE_KEY   = "/app/common/plugins/spayplugins\keys/merchant_private_key.key";

    /**
     * @param  string  $url   Sarawak pay api
     * @param  string  $data  JSON data
     * @return string         JSON string
     */
    public static function post($url, $data)
    {
        $signedData = json_decode($data, 320); //对 JSON 格式的字符串进行解码
        $signedData['sign'] = Encryption::generateSignature($data, self::MERCHANT_PRIVATE_KEY);  ////生成一个签名

        $encryptedData = Encryption::encrypt(json_encode($signedData, 320), self::SP_PUBLIC_KEY);  ///对数据进行加密

        $payload = "FAPView=JSON&formData=" . str_replace('+', '%2B', $encryptedData);   //全部+替换为 %2B

        $ch = curl_init();  //初始化url对话
        curl_setopt($ch, CURLOPT_URL, $url);  //设置 cURL 传输选项
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // have to remove
        $response = curl_exec($ch); //执行 cURL 会话
        curl_close ($ch);  //关闭对话

        $decrypted_response = Encryption::decrypt($response, self::MERCHANT_PRIVATE_KEY);  //解密数据

        // Verify Server Response
        if (Encryption::verifySignature($decrypted_response, self::SP_PUBLIC_KEY)) { //验证签名
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
