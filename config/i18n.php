<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('DEFAULT_LANGUAGE', 'es');
define('SUPPORTED_LANGUAGES', ['en', 'es']);
define('LANG_PATH', __DIR__ . '/../locales');

// Note: The global $translations cache is no longer used by t() directly.
// t() now uses a static cache. get_js_translations() will load its own.

/**
 * Sets the current language for the session.
 *
 * @param string $lang_code Language code (e.g., 'en', 'es').
 */
function setCurrentLanguage(string $lang_code): void {
    if (in_array($lang_code, SUPPORTED_LANGUAGES)) {
        $_SESSION['lang'] = $lang_code;
    } else {
        $_SESSION['lang'] = DEFAULT_LANGUAGE;
    }
}

/**
 * Gets the current language.
 *
 * @return string The current language code.
 */
function getCurrentLanguage(): string {
    return $_SESSION['lang'] ?? DEFAULT_LANGUAGE;
}

/**
 * Translates a given key.
 *
 * Looks up the key in the 'common.php' file for the current language.
 *
 * @param string $key The translation key.
 * @param string|null $default_value Optional default value to return if key not found.
 * @return string The translated string, or the key itself (or $default_value) if not found.
 */
function t(string $key, string $default_value = null): string {
    static $loaded_translations = []; // Static cache for t()
    $current_lang = getCurrentLanguage();

    if (!isset($loaded_translations[$current_lang])) {
        $file_path = LANG_PATH . "/{$current_lang}/common.php";
        if (file_exists($file_path)) {
            $loaded_translations[$current_lang] = require $file_path;
        } else {
            // Fallback to default language if current language file is missing
            if ($current_lang !== DEFAULT_LANGUAGE) {
                $default_file_path = LANG_PATH . "/" . DEFAULT_LANGUAGE . "/common.php";
                if (file_exists($default_file_path)) {
                    // Load default translations but store them under the current language key
                    // to avoid attempting to reload the current language file on every t() call if it's missing.
                    $loaded_translations[$current_lang] = require $default_file_path;
                } else {
                    $loaded_translations[$current_lang] = []; // Default language file also missing
                }
            } else {
                 $loaded_translations[$current_lang] = []; // Current language is default, and its file is missing
            }
        }
    }

    return $loaded_translations[$current_lang][$key] ?? $default_value ?? $key;
}

/**
 * Initializes the language based on URL parameter or session.
 * To be called early in the application lifecycle.
 */
function initializeLocalization(): void {
    if (isset($_GET['lang'])) {
        setCurrentLanguage(trim($_GET['lang']));
        // Optional: Redirect to remove lang from URL to avoid it being sticky on all links
        // $uri_without_lang = strtok($_SERVER["REQUEST_URI"], '?');
        // $query_params = [];
        // parse_str($_SERVER['QUERY_STRING'] ?? '', $query_params);
        // unset($query_params['lang']);
        // $new_query_string = http_build_query($query_params);
        // header("Location: " . $uri_without_lang . ($new_query_string ? '?' . $new_query_string : ''));
        // exit;
    } elseif (!isset($_SESSION['lang'])) {
        // Set default language if no preference is found
        setCurrentLanguage(DEFAULT_LANGUAGE);
    }
    // Ensure language is set if session contained an unsupported value
    if (!in_array(getCurrentLanguage(), SUPPORTED_LANGUAGES)) {
        setCurrentLanguage(DEFAULT_LANGUAGE);
    }
}

/**
 * Generates a URL for switching to a specific language, preserving other GET parameters.
 *
 * @param string $lang_code The language code (e.g., 'en', 'es').
 * @return string The generated URL.
 */
function generate_lang_url(string $lang_code): string {
    $current_params = $_GET; // Get current query parameters
    $current_params['lang'] = $lang_code; // Set or override the lang parameter

    // Ensure 'c' and 'a' parameters are present if they were originally,
    // otherwise, they might be lost if not part of the initial $_GET for some reason.
    // This is more of a safeguard; typically, they should be in $_GET if on a page using them.
    if (!isset($current_params['c']) && isset($_GET['c'])) {
        $current_params['c'] = $_GET['c'];
    }
    if (!isset($current_params['a']) && isset($_GET['a'])) {
        $current_params['a'] = $_GET['a'];
    }

    return basename($_SERVER['PHP_SELF']) . '?' . http_build_query($current_params);
}

/**
 * Retrieves all translations for the current or default language, intended for JavaScript.
 * It ensures that all keys from the default language are present, overlayed by current language translations.
 *
 * @return array The array of translations.
 */
function get_js_translations(): array {
    static $js_translations_cache = null; // Cache for this function

    if ($js_translations_cache === null) {
        $current_lang = getCurrentLanguage();
        $translations_to_expose = [];
        $default_translations = [];

        $default_file_path = LANG_PATH . "/" . DEFAULT_LANGUAGE . "/common.php";
        if (file_exists($default_file_path)) {
            $default_translations = require $default_file_path;
        }

        $translations_to_expose = $default_translations; // Start with default translations

        if ($current_lang !== DEFAULT_LANGUAGE) {
            $current_lang_file_path = LANG_PATH . "/{$current_lang}/common.php";
            if (file_exists($current_lang_file_path)) {
                $current_lang_translations = require $current_lang_file_path;
                // Override default translations with current language translations
                $translations_to_expose = array_merge($default_translations, $current_lang_translations);
            }
            // If current lang file doesn't exist, $translations_to_expose remains as $default_translations
        }
        $js_translations_cache = $translations_to_expose;
    }
    return $js_translations_cache;
}

?>
