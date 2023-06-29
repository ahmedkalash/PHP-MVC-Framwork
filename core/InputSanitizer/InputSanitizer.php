<?php
declare(strict_types=1);
namespace app\core\InputSanitizer;

class InputSanitizer implements InputSanitizerInterface
{

    public function sanitizeGetData(array $data, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array
    {
        $sanitizedData = [];
        foreach ($data as $key=>$value) {
            $filterResult = filter_input(INPUT_GET, $key, $filter);
            if($filterResult != 0 && $filterResult != null) {
                $sanitizedData[$key]= $filterResult;
            }
        }
        return $sanitizedData;
    }

    public function sanitizePostData(array $data, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array
    {
        return $data;
        $sanitizedData = [];
        foreach ($data as $key=>$value) {
            if(is_array($value)){
                 $sanitizedData[$key]=$this->sanitizePostData($value);
            }
            $filterResult = filter_input(INPUT_POST, $key, $filter);
            if($filterResult != 0 && $filterResult != null) {
                $sanitizedData[$key]= $filterResult;
            }
        }
        return $sanitizedData;
    }


    public function sanitizeCookies(array $cookies, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array
    {
        $sanitizedCookies = [];
        foreach ($cookies as $key=>$value) {
            $filterResult = filter_input(INPUT_COOKIE, $key, $filter);
            if($filterResult != 0 && $filterResult != null) {
                $sanitizedCookies[$key]= $filterResult;
            }
        }
        return $sanitizedCookies;
    }



    public function sanitizeHeaders(array $headers, int $filter=FILTER_SANITIZE_FULL_SPECIAL_CHARS): array
    {
        $sanitizedHeaders=[];
        foreach ($headers as $headerName => $headerValue) {
            $filterResult = filter_input(INPUT_SERVER, 'HTTP_'.$headerName, $filter);
            if($filterResult !== 0 && $filterResult != null) {
                $sanitizedHeaders[$headerName]= $filterResult;
            }
        }
        return $sanitizedHeaders;
    }
}
