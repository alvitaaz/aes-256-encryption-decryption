<?php
if (!function_exists('aesEncrypt')) {
    function aesEncrypt($data, $encryptionKey, $hmacKey) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $encryptionKey, 0, $iv);
        $hmac = hash_hmac('sha256', $encryptedData, $hmacKey, true);
        return $iv . $hmac . $encryptedData;
    }
}

if (!function_exists('aesDecrypt')) {
    function aesDecrypt($data, $encryptionKey, $hmacKey) {
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength);
        $hmac = substr($data, $ivLength, 32);
        $encryptedData = substr($data, $ivLength + 32);
        $calculatedHmac = hash_hmac('sha256', $encryptedData, $hmacKey, true);

        if (!hash_equals($hmac, $calculatedHmac)) {
            throw new Exception('HMAC verification failed.');
        }

        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $encryptionKey, 0, $iv);

        if ($decryptedData === false) {
            throw new Exception('Decryption failed. The encryption key might be incorrect.');
        }

        return $decryptedData;
    }
}
?>
