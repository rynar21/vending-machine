<?php
/**
 * Sarawak Pay module
 */
namespace common\plugins\spayplugins\plugins;

class Encryption
{
    const DESKEY_FORMAT_LENGTH = 6;

    /**
     * @param  string  $data  JSON string to be encrypted
     * @param  string  $key   RSA Public Key Path
     * @return string         Encrypted data
     */
    public static function encrypt($data, $key)
    {
        $desKey = random_bytes(24); //生成加密安全的伪随机字节
        if (openssl_public_encrypt($desKey, $encryptedDesKey, static::getRsaPublicKey($key))) {  //使用公钥加密数据
            $encryptedDesKey        = unpack('C*', $encryptedDesKey);  //从二进制字符串解压缩数据 （C  无符号字符串）
            $encryptedData          = openssl_encrypt($data, 'des-ede3', $desKey, OPENSSL_RAW_DATA);  //加密数据
            $encryptedDesKeyLength  = unpack('C*', sprintf("%06d", count($encryptedDesKey)));   //sprintf返回格式化的字符串
            $encryptedData          = unpack('C*', $encryptedData);

            $encryptedMessage = base64_encode(pack('C*', ...$encryptedDesKeyLength, ...$encryptedDesKey, ...$encryptedData));  //使用 MIME base64 对数据进行编码

            return $encryptedMessage;
        }

        return false;
    }

    /**
     * @param  string  $data  Encrypted data to be decrypt
     * @param  string  $key   RSA Private Key Path
     * @return string         Decrypted JSON string
     */
    public static function decrypt($data, $key)
    {
        $encryptedMessage   = unpack('C*', base64_decode($data));
        $keyLengthByte      = array_slice($encryptedMessage, 0, self::DESKEY_FORMAT_LENGTH); //从数组中取出一段  0-6
        $encryptedMessage   = array_slice($encryptedMessage, self::DESKEY_FORMAT_LENGTH);
        $keyLengthInt       = intval(pack("C*", ...$keyLengthByte));  //获取变量的整数值
        $encryptedDesKey    = array_slice($encryptedMessage, 0, $keyLengthInt);
        $encryptedMessage   = array_slice($encryptedMessage, $keyLengthInt);
        $encryptedDesKey    = pack("C*", ...$encryptedDesKey);

        if (openssl_private_decrypt($encryptedDesKey, $decryptedDesKey, static::getRsaPrivateKey($key))) {//使用私钥解密数据
            $encryptedData = pack("C*", ...$encryptedMessage); //将数据打包成二进制字符串

            $result = openssl_decrypt($encryptedData, 'des-ede3', $decryptedDesKey, OPENSSL_RAW_DATA); //解密数据

            return $result;
        }

        return false;
    }

    private static function sortData($data)
    {
        $_data = unpack('C*', $data); //从二进制字符串解压缩数据
        sort($_data);  //排序
        return pack('C*', ...$_data);  //将数据打包成二进制字符串
    }

    /**
     * @param  string  $data  String data to be sign
     * @param  string  $key   RSA Private Key Path
     * @return string         Decrypted JSON string
     */
    public static function generateSignature($data, $key)  //生成一个签名
    {
        $sortedData = static::sortData($data);
        openssl_sign($sortedData, $binary_signature, static::getRsaPrivateKey($key), 'SHA256');  //生成签名

        return base64_encode($binary_signature);  //使用 MIME base64 对数据进行编码
    }

    /**
     * @param  string  $data  String data to be verify
     * @param  string  $key   RSA Public Key Path
     * @return boolean        Result
     */
    public static function checkSignature($data, $signature, $key)
    {
        $sortedData = static::sortData($data);

        return openssl_verify($sortedData, base64_decode($signature), static::getRsaPublicKey($key), 'SHA256');  //验证签名
    }

    /**
     * @param  string  $data  Json string data to be verify
     * @param  string  $key   RSA Public Key Path
     * @return boolean        Result
     */
    public static function verifySignature($data, $key)  //验证签名
    {
        $data = json_decode($data, 320); //对 JSON 格式的字符串进行解码
        $signature = $data['sign'];
        unset($data['sign']);     //销毁变量
        $data = json_encode($data, 320);

        return static::checkSignature($data, $signature, $key);
    }

    public static function getRsaPrivateKey($filename)    // 获取私钥
    {
        return openssl_get_privatekey(static::getKey($filename));  //解析私钥
    }

    public static function getRsaPublicKey($filename) //获取公钥
    {
        return openssl_get_publickey(static::getKey($filename));  //解析公钥，
    }

    private static function getKey($filename)  //获取密钥
    {
        $key_path = $filename;
        $fp = fopen($key_path, "r");
        $rsaKey = fread($fp, 8192);  //二进制读取   8192字节
        fclose($fp);

        return $rsaKey;
    }
}
