<?php
declare(strict_types=1);
namespace app\core\Session;

/**
 *
 */
class SessionHandler implements SessionHandlerInterface
{
    /**
     * @var array<string,mixed>
     */
    protected array $session;

    public function __construct()
    {
        $this->start();
        $this->session =& $_SESSION;

    }

    public function start(): bool
    {
        if (!$this->started()) {
            return session_start();
        }
        return true;

    }

    public function started(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function end(): bool
    {
        return session_abort();
    }

    public function put(string $key, $value): bool
    {
        try {
            $this->session[$key] = $value;
        } catch (\Throwable) {
            return false;
        }
        return true;
    }

    public function get(string $key): mixed
    {
        return $this->session[$key] ?? null;
    }

    public function all(): array
    {
        return $this->session;
    }

    public function flash(string $key, $value): bool
    {
        if ($this->has($key)) {
            unset($this->session[$key]);
            unset($this->session['newFlashDataKeys'][$key]);
            unset($this->session['oldFlashDataKeys'][$key]);
        }
        try {
            $this->session[$key] = $value;
            $this->session['newFlashDataKeys'][$key] = $key;
        } catch (\Throwable) {
            return false;
        }
        return true;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->session);
    }

    public function flushNewFlashData(): void
    {
        foreach ($this->newFlashDataKeys() as $key) {
            $this->delete($key);
        }
        $this->setNewFlashDataKeys([]);
    }

    public function newFlashDataKeys(): array
    {
        return $this->session['newFlashDataKeys'] ?? [];
    }

    public function delete(string $key): void
    {
        unset($this->session[$key]);
        unset($this->session['newFlashDataKeys'][$key]);
        unset($this->session['oldFlashDataKeys'][$key]);
    }

    /**
     * @param array<string, string> $newFlashDataKeys
     */
    protected function setNewFlashDataKeys(array $newFlashDataKeys): void
    {
        $this->session['newFlashDataKeys'] = $newFlashDataKeys;
    }

    public function prepareTheNewFlashDataForTheNextRequest(): void
    {
        // flush 'Old'
        $this->flushOldFlashData();
        // And Set 'Old' = 'New' (make the 'New' becomes 'old')
        $this->setOldFlashDataKeys($this->newFlashDataKeys());
        // now the 'New' is not new anymore
        $this->setNewFlashDataKeys([]);
    }

    public function flushOldFlashData(): void
    {
        foreach ($this->oldFlashDataKeys() as $key) {
            $this->delete($key);
        }
        $this->setOldFlashDataKeys([]);
    }

    public function oldFlashDataKeys(): array
    {
        return $this->session['oldFlashDataKeys'] ?? [];
    }

    /**
     * @param array<string, string> $oldFlashDataKeys
     */
    protected function setOldFlashDataKeys(array $oldFlashDataKeys): void
    {
        $this->session['oldFlashDataKeys'] = $oldFlashDataKeys;
    }

    public function id(): false|string
    {
        return session_id();
    }

    public function reFresh(): string
    {
        $this->flush();
        return $this->regenerateId();
    }

    public function flush(): void
    {
        $this->session = [];
        $this->setNewFlashDataKeys([]);
        $this->setOldFlashDataKeys([]);
    }

    public function regenerateId(): bool|string
    {
        return session_regenerate_id() ? session_id():false;
    }

}
