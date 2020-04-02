<?php

namespace common\plugins\spay;
/**
 * Sarawak Pay module
 */
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
        $desKey = random_bytes(24);
        if (openssl_public_encrypt($desKey, $encryptedDesKey, static::getRsaPublicKey($key))) {
            $encryptedDesKey        = unpack('C*', $encryptedDesKey);
            $encryptedData          = openssl_encrypt($data, 'des-ede3', $desKey, OPENSSL_RAW_DATA);
            $encryptedDesKeyLength  = unpack('C*', sprintf("%06d", count($encryptedDesKey)));
            $encryptedData          = unpack('C*', $encryptedData);

            $encryptedMessage = base64_encode(pack('C*', ...$encryptedDesKeyLength, ...$encryptedDesKey, ...$encryptedData));

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
        $keyLengthByte      = array_slice($encryptedMessage, 0, self::DESKEY_FORMAT_LENGTH);
        $encryptedMessage   = array_slice($encryptedMessage, self::DESKEY_FORMAT_LENGTH);
        $keyLengthInt       = intval(pack("C*", ...$keyLengthByte));
        $encryptedDesKey    = array_slice($encryptedMessage, 0, $keyLengthInt);
        $encryptedMessage   = array_slice($encryptedMessage, $keyLengthInt);
        $encryptedDesKey    = pack("C*", ...$encryptedDesKey);

        if (openssl_private_decrypt($encryptedDesKey, $decryptedDesKey, static::getRsaPrivateKey($key))) {
            $encryptedData = pack("C*", ...$encryptedMessage);

            $result = openssl_decrypt($encryptedData, 'des-ede3', $decryptedDesKey, OPENSSL_RAW_DATA);

            return $result;
        }

        return false;
    }

    private static function sortData($data)
    {
        $_data = unpack('C*', $data);
        sort($_data);
        return pack('C*', ...$_data);
    }

    /**
     * @param  string  $data  String data to be sign
     * @param  string  $key   RSA Private Key Path
     * @return string         Decrypted JSON string
     */
    public static function generateSignature($data, $key)
    {
        $sortedData = static::sortData($data);
        openssl_sign($sortedData, $binary_signature, static::getRsaPrivateKey($key), 'SHA256');

        return base64_encode($binary_signature);
    }

    /**
     * @param  string  $data  String data to be verify
     * @param  string  $key   RSA Public Key Path
     * @return boolean        Result
     */
    public static function checkSignature($data, $signature, $key)
    {
        $sortedData = static::sortData($data);

        return openssl_verify($sortedData, base64_decode($signature), static::getRsaPublicKey($key), 'SHA256');
    }

    /**
     * @param  string  $data  Json string data to be verify
     * @param  string  $key   RSA Public Key Path
     * @return boolean        Result
     */
    public static function verifySignature($data, $key)
    {
        $data = json_decode($data, 320);
        $signature = $data['sign'];
        unset($data['sign']);
        $data = json_encode($data, 320);

        return static::checkSignature($data, $signature, $key);
    }

    public static function getRsaPrivateKey($filename)
    {
        return openssl_get_privatekey(static::getKey($filename));
    }

    public static function getRsaPublicKey($filename)
    {
        return openssl_get_publickey(static::getKey($filename));
    }

    private static function getKey($filename)
    {
        $key_path = $filename;
        $fp = fopen($key_path, "r");
        $rsaKey = fread($fp, 8192);
        fclose($fp);

        return $rsaKey;
    }
}
