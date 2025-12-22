<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class EncryptionHelper
{
    /**
     * Encrypt an ID for use in URLs
     */
    public static function encryptId($id)
    {
        try {
            return Crypt::encryptString($id);
        } catch (\Exception $e) {
            return $id; // Fallback to plain ID if encryption fails
        }
    }

    /**
     * Decrypt an encrypted ID from URL
     */
    public static function decryptId($encryptedId)
    {
        try {
            return Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            // If decryption fails, try to use as plain ID (for backward compatibility)
            if (is_numeric($encryptedId)) {
                return $encryptedId;
            }
            throw new \Exception('Invalid encrypted ID');
        }
    }

    /**
     * Encrypt ID and encode for URL
     */
    public static function encryptIdForUrl($id)
    {
        $encrypted = self::encryptId($id);
        return base64_encode($encrypted);
    }

    /**
     * Decrypt ID from URL encoded string
     */
    public static function decryptIdFromUrl($encodedId)
    {
        try {
            $encrypted = base64_decode($encodedId);
            return self::decryptId($encrypted);
        } catch (\Exception $e) {
            // Try direct decryption if base64 decode fails
            return self::decryptId($encodedId);
        }
    }
}

