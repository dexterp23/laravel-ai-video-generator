<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (!function_exists('createOpenAiVideoPrompt')) {
    function createOpenAiVideoPrompt(
        array $data,
        string $size = '720x1280'
    ): array {
        $prompt = config('ai.prompt_video');
        return [
            'prompt' => $prompt,
            'duration' => strval($data['length']),
            'size' => $size,
        ];
    }
}

if (!function_exists('createOpenAiJsonPrompt')) {
    function createOpenAiJsonPrompt(
        string $prompt,
        string $jsonFormatKey,
        string $lang = ''
    ): array {
        if (empty($lang)) {
            $lang = config('ai.default_language');
        }
        return [
            'instructions' => messageFormatter(
                config('ai.json_system'),
                [
                    '{lang}' => $lang,
                    '{format}' => json_encode (config($jsonFormatKey, [])),
                ]
            ),
            'input' => $prompt
        ];
    }
}

if (!function_exists('messageFormatter')) {
    function messageFormatter(string $template, array $data): string
    {
        return strtr($template, $data);
    }
}

if (!function_exists('validateJson')) {
    function validateJson(string $json): array
    {
        $array = json_decode($json, true);
        if (!is_array($array)) {
            throw new \Exception("Unvalid JSON: " . $json);
        }

        return $array;
    }
}

if (!function_exists('getAllDbTables')) {
    function getAllDbTables(): array
    {
        $driver = DB::getDriverName();

        switch ($driver) {
            case 'mysql':
                $tables = DB::select('SHOW TABLES');
                $tables = array_map('current', $tables);
                break;

            case 'pgsql':
                $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname='public'");
                $tables = array_map(fn($t) => $t->tablename, $tables);
                break;

            case 'sqlite':
                $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
                $tables = array_map(fn($t) => $t->name, $tables);
                break;

            default:
                $tables = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableNames();
                break;
        }

        return $tables;
    }
}
