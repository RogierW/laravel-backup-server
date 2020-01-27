<?php

namespace Spatie\BackupServer\Tests\Factories;

use Spatie\BackupServer\Models\Backup;
use Spatie\BackupServer\Models\Destination;
use Spatie\BackupServer\Models\Source;

class BackupFactory
{
    private ?Source $source;

    private ?Destination $destination;

    private bool $createBackupDirectory = false;

    public function source(Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function destination(Destination $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function makeSureBackupDirectoryExists($createBackupDirectory = true)
    {
        $this->createBackupDirectory = $createBackupDirectory;

        return $this;
    }

    public function create(array $attributes = []): Backup
    {
        $this->source ??= factory(Source::class)->create();
        $this->destination ??= factory(Destination::class)->create();

        $attributes = array_merge([
            'source_id' => $this->source->id,
            'destination_id' => $this->destination->id,
        ], $attributes);

        /** @var \Spatie\BackupServer\Models\Backup $backup */
        $backup = factory(Backup::class)->create($attributes);

        if ($this->createBackupDirectory) {
            $backup->disk()->makeDirectory($backup->destinationLocation()->getPath());
        }

        return $backup;

    }
}
