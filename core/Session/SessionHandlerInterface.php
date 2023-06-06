<?php

namespace app\core\Session;

interface SessionHandlerInterface
{
    public function start(): bool;

    public function started(): bool;

    public function end(): bool;

    public function put(string $key, $value): bool;

    public function get(string $key): mixed;

    public function has(string $key): bool;

    public function delete(string $key): void;

    public function all(): array;

    public function flush(): void;


    public function flash(string $key, $value): bool;

    public function id(): false|string;

    public function regenerateId():bool| string;

    public function reFresh(): string;


    public function newFlashDataKeys(): array;


    public function oldFlashDataKeys(): array;


    public function flushNewFlashData(): void;

    public function flushOldFlashData(): void;

    public function prepareTheNewFlashDataForTheNextRequest(): void;

}
