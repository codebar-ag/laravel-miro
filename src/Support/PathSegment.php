<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Support;

/**
 * Escapes identifiers before they are placed into a request path, so that an
 * id can never break out of its own path segment (for example by containing
 * a slash, a query string or a dot segment) and reach a different endpoint.
 *
 * Characters that are valid in Miro ids (letters, digits, "=", "-", "_")
 * are left untouched, so regular ids produce exactly the same path as before.
 *
 * @internal
 */
final class PathSegment
{
    public static function encode(string $value): string
    {
        if ($value === '.' || $value === '..') {
            return str_replace('.', '%2E', $value);
        }

        return strtr($value, [
            '/' => '%2F',
            '\\' => '%5C',
            '?' => '%3F',
            '#' => '%23',
        ]);
    }
}
