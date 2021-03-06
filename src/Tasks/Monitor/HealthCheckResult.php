<?php

namespace Spatie\BackupServer\Tasks\Monitor;

class HealthCheckResult
{
    protected bool $ok = true;

    protected string $message = '';

    protected bool $runRemainingChecks = true;

    public static function ok()
    {
        return new static();
    }

    public static function failed(string $message)
    {
        return (new static($message))->markAsFailed();
    }

    protected function __construct($message = '')
    {
        $this->message = $message;
    }

    public function isOk(): bool
    {
        return $this->ok;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function markAsFailed(): self
    {
        $this->ok = false;

        return $this;
    }

    public function doNotRunRemainingChecks()
    {
        $this->runRemainingChecks = false;

        return $this;
    }

    public function shouldContinueRunningRemainingChecks(): bool
    {
        return $this->runRemainingChecks;
    }
}
