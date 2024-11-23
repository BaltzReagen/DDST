<?php

namespace App\Helpers;

class StringHelper
{
    public static function extractFirstName($username)
    {
        // Remove any common prefixes (like 'guest_')
        $username = preg_replace('/^guest_/', '', $username);
        
        // Try different separators first
        $separators = [' ', '_', '-'];
        foreach ($separators as $separator) {
            if (strpos($username, $separator) !== false) {
                $parts = explode($separator, $username);
                return ucfirst(strtolower($parts[0]));
            }
        }
        
        // If all uppercase, convert to title case first
        if (strtoupper($username) === $username) {
            $username = ucwords(strtolower($username));
        }
        
        // Split by camelCase, consecutive uppercase, or lowercase letters
        $pattern = '/(?:[A-Z][a-z]+)|(?:[A-Z]{2,}(?=[A-Z][a-z]|\d|\W|$|[A-Z][a-z]+))|(?:[a-z]+)/';
        if (preg_match_all($pattern, $username, $matches)) {
            // Return first word found
            return ucfirst(strtolower($matches[0][0]));
        }
        
        // If all else fails, return the first word or up to 15 characters
        $firstWord = preg_split('/[^a-zA-Z]/', $username)[0];
        return ucfirst(strtolower(substr($firstWord, 0, 15)));
    }

    public static function formatFullName($username)
    {
        // Remove any special characters
        $username = preg_replace('/[^a-zA-Z0-9\s]/', '', $username);
        
        // If all uppercase, convert to title case and add spaces before capital letters
        if (strtoupper($username) === $username) {
            // Convert to lowercase first
            $username = strtolower($username);
            
            // Split into words (assuming each capital letter starts a new word)
            $words = [];
            $currentWord = '';
            
            for ($i = 0; $i < strlen($username); $i++) {
                if ($i > 0 && ctype_upper($username[$i])) {
                    $words[] = $currentWord;
                    $currentWord = $username[$i];
                } else {
                    $currentWord .= $username[$i];
                }
            }
            
            // Add the last word
            if (!empty($currentWord)) { 
                $words[] = $currentWord;
            }
            
            // Capitalize each word and join with spaces
            return implode(' ', array_map('ucfirst', array_filter($words)));
        }
        
        // Handle camelCase and mixed case names
        $pattern = '/(?:[A-Z][a-z]+)|(?:[A-Z]{2,}(?=[A-Z][a-z]|\d|\W|$|[A-Z][a-z]+))|(?:[a-z]+)/';
        preg_match_all($pattern, $username, $matches);
        
        if (!empty($matches[0])) {
            // Properly capitalize each word
            $formatted = array_map(function($word) {
                return ucfirst(strtolower($word));
            }, $matches[0]);
            
            return implode(' ', $formatted);
        }
        
        return ucfirst(strtolower($username));
    }
}