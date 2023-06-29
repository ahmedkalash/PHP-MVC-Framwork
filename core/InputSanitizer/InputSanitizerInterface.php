<?php
declare(strict_types=1);
namespace app\core\InputSanitizer;

interface InputSanitizerInterface
{
    // todo handel how to sanitize a data from a given array
    public function sanitizeGetData(array $data, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array;

    public function sanitizePostData(array $data, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array;

    public function sanitizeCookies(array $cookies, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array;

    public function sanitizeHeaders(array $headers, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array;
}
