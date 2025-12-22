<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

/**
 * LogHelper - Centralized logging utility
 * 
 * Provides structured logging with file-based storage
 * and proper error categorization
 */
class LogHelper
{
    /**
     * Log directory path
     */
    private static $logPath = 'logs/custom';
    
    /**
     * Log an error message
     * 
     * @param string $message
     * @param array $context
     * @param string $module
     */
    public static function error($message, $context = [], $module = 'general')
    {
        self::writeLog('error', $message, $context, $module);
        Log::error($message, array_merge($context, ['module' => $module]));
    }
    
    /**
     * Log a warning message
     * 
     * @param string $message
     * @param array $context
     * @param string $module
     */
    public static function warning($message, $context = [], $module = 'general')
    {
        self::writeLog('warning', $message, $context, $module);
        Log::warning($message, array_merge($context, ['module' => $module]));
    }
    
    /**
     * Log an info message
     * 
     * @param string $message
     * @param array $context
     * @param string $module
     */
    public static function info($message, $context = [], $module = 'general')
    {
        self::writeLog('info', $message, $context, $module);
        Log::info($message, array_merge($context, ['module' => $module]));
    }
    
    /**
     * Write log to custom file
     * 
     * @param string $level
     * @param string $message
     * @param array $context
     * @param string $module
     */
    private static function writeLog($level, $message, $context, $module)
    {
        try {
            $logDir = storage_path(self::$logPath);
            if (!File::exists($logDir)) {
                File::makeDirectory($logDir, 0755, true);
            }
            
            $logFile = $logDir . '/' . $module . '_' . date('Y-m-d') . '.log';
            $timestamp = date('Y-m-d H:i:s');
            $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
            $logEntry = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
            
            File::append($logFile, $logEntry);
        } catch (\Exception $e) {
            // Fallback to Laravel's default logging if custom logging fails
            Log::error('LogHelper writeLog failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Log exception with full stack trace
     * 
     * @param \Exception $exception
     * @param string $module
     * @param array $additionalContext
     */
    public static function exception(\Exception $exception, $module = 'general', $additionalContext = [])
    {
        $context = array_merge([
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ], $additionalContext);
        
        self::error('Exception occurred: ' . $exception->getMessage(), $context, $module);
    }
}

