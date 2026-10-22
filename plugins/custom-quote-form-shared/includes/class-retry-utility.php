<?php
/**
 * Retry Utility for Custom Quote Form plugins
 * 
 * Provides exponential backoff retry logic for various operations
 */

if (!defined('ABSPATH')) {
    exit;
}

class CQF_Retry_Utility {
    
    /**
     * Retry operation with exponential backoff
     * 
     * @param callable $callback Function to retry
     * @param string $operation_name Name of operation (for logging)
     * @param int $max_attempts Maximum number of retry attempts
     * @param int $initial_delay Initial delay in seconds before first retry
     * @return mixed Return value from callback
     * @throws \RuntimeException If all retries fail
     */
    public static function retry_with_backoff($callback, $operation_name = 'operation', $max_attempts = 3, $initial_delay = 1) {
        $attempt = 0;
        $delay = $initial_delay;
        
        while ($attempt < $max_attempts) {
            try {
                return $callback();
            } catch (\RuntimeException $e) {
                $attempt++;
                
                if ($attempt >= $max_attempts) {
                    error_log("CQF Retry: {$operation_name} failed after {$max_attempts} attempts");
                    throw $e; // Re-throw if max attempts reached
                }
                
                // Exponential backoff: delay doubles with each attempt
                error_log("CQF Retry: {$operation_name} attempt {$attempt}/{$max_attempts} failed, waiting {$delay} seconds before retry");
                sleep($delay);
                $delay *= 2; // Exponential backoff
            }
        }
    }
}

