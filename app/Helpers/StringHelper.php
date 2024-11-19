<?php

namespace App\Helpers;

class StringHelper
{
    public static function extractFirstName($username)
    {
        // Remove any special characters and extra spaces
        $username = preg_replace('/[^a-zA-Z0-9\s]/', '', $username);
        
        // Try different patterns to extract first name
        
        // Pattern 1: CamelCase (e.g., KevinLimYeeHo)
        if (preg_match('/^[A-Z][a-z]+/', $username, $matches)) {
            return ucfirst(strtolower($matches[0]));
        }
        
        // Pattern 2: Space separated (e.g., "Kevin Lim")
        if (str_contains($username, ' ')) {
            return ucfirst(strtolower(explode(' ', $username)[0]));
        }
        
        // Pattern 3: Single word (e.g., "kevin" or "KEVIN")
        return ucfirst(strtolower($username));
    }

    public static function formatFullName($username)
    {
        // Remove any special characters
        $username = preg_replace('/[^a-zA-Z0-9\s]/', '', $username);
        
        // Handle camelCase by adding spaces before capital letters
        $spaced = preg_replace('/(?<!^)(?=[A-Z])/', ' ', $username);
        
        // Split into words
        $words = preg_split('/\s+/', $spaced);
        
        // Properly capitalize each word
        $formatted = array_map(function($word) {
            return ucfirst(strtolower($word));
        }, $words);
        
        return implode(' ', $formatted);
    }
}