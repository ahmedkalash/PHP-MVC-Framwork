<?php

namespace app\core\Request;

/**
 * Interface RequestInterface
 *
 * Represents an HTTP request with various request data and provides methods to access and manipulate the data.
 */
interface RequestInterface
{


    /**
     * Retrieves the supported request methods.
     *
     * @return array The supported request methods.
     */
    public static function supportedMethods(): array;


    /**
     * Retrieves a specific value from the GET data or all the GET data is the $key is NULL.
     *
     * @param string|null $key The data key to retrieve.
     * @return null|int|string|float|bool|array All The GET data or the value of the specified key.
     */
    public function getData(string $key = null): null|int|string|float|bool|array;

    /**
     * Retrieves a specific value from the POST data or all the POST data is the $key is NULL.
     *
     * @param string|null $key The data key to retrieve.
     * @return null|int|string|float|bool|array All The POST data or the value of the specified key.
     */
    public function postData(string $key = null): null|int|string|float|bool|array;

    /**
     * Retrieves all the data sent to the server in both get and post method.
     * * Note that data in POST will override the data in Get that has the same key.
    * @return null|int|string|float|bool|array
     */
    public function allData(): null|int|string|float|bool|array;


    /**
     * Retrieves a specific value from the POST data. If it is not found it will search in the GET data.
     * * Note that data in POST will override the data in Get that has the same key.
     * @param string $key The data key to retrieve.
     * @return null|int|string|float|bool|array The value of the specified key or NULL if it is not found.
     */
    public function input(string $key): null|int|string|float|bool|array;


    /**
     * Retrieves a specific value from the COOKIES data or all the COOKIES data is the $key is NULL.
     *
     * @param string|null $key The cookie name to retrieve.
     * @return null|int|string|float|bool|array All The cookie data or the value of the specified key.
     */
    public function cookies(string $key = null): null|int|string|float|bool|array;

    /**
     * Retrieves a specific value from the headers data or all the headers data is the $key is NULL.
     *
     * @param string|null $key The header name to retrieve.
     * @return null|int|string|float|bool|array All The headers data or the value of the specified key.
     */
    public function headers(string $key = null): null|int|string|float|bool|array;

    /**
     * Gets the requested path.
     *
     * @return string
     */
    public function path(): string;

    /**
     * Gets the request method.
     *
     * @return string
     * @throws \Exception
     */
    public function method(): string;

    /**
     * Checks if the request method is POST.
     *
     * @return bool True if the request method is POST, false otherwise.
     */
    public function isPost(): bool;

    /**
     * Checks if the request method is GET.
     *
     * @return bool True if the request method is GET, false otherwise.
     */
    public function isGet(): bool;

}
