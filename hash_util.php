<?php
/**
 * Utility helpers for hash table based searching with division method.
 */
if (!function_exists('calculateHashIndex')) {
    function calculateHashIndex(string $value, int $tableSize = 5): int
    {
        if ($tableSize <= 0) {
            return 0;
        }

        $normalized = strtolower(trim($value));
        $asciiSum = 0;
        $length = strlen($normalized);

        for ($i = 0; $i < $length; $i++) {
            $asciiSum += ord($normalized[$i]);
        }

        return $asciiSum % $tableSize;
    }
}

if (!function_exists('buildHashTable')) {
    function buildHashTable(array $rows, string $keyField, int $tableSize = 5): array
    {
        $table = array_fill(0, $tableSize, []);

        foreach ($rows as $row) {
            if (!isset($row[$keyField])) {
                continue;
            }

            $hashIndex = calculateHashIndex((string) $row[$keyField], $tableSize);
            $row['_hash_index'] = $hashIndex;
            $table[$hashIndex][] = $row;
        }

        return $table;
    }
}

if (!function_exists('hashTableSearch')) {
    function hashTableSearch(array $hashTable, string $searchTerm, string $keyField, int $tableSize = 5): array
    {
        $searchTerm = trim($searchTerm);
        if ($searchTerm === '') {
            return flattenHashTable($hashTable);
        }

        $hashIndex = calculateHashIndex($searchTerm, $tableSize);
        $bucket = $hashTable[$hashIndex] ?? [];
        $results = [];

        foreach ($bucket as $row) {
            if (!isset($row[$keyField])) {
                continue;
            }

            if (stripos($row[$keyField], $searchTerm) !== false) {
                $results[] = $row;
            }
        }

        return $results;
    }
}

if (!function_exists('flattenHashTable')) {
    function flattenHashTable(array $hashTable): array
    {
        $flattened = [];
        foreach ($hashTable as $bucket) {
            foreach ($bucket as $row) {
                $flattened[] = $row;
            }
        }
        return $flattened;
    }
}
?>
