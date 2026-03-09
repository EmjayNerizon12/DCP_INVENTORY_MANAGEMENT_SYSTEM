<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ManagesLookupCrud
{
    public static function lookupNameColumn(): string
    {
        $constant = static::class.'::LOOKUP_NAME_COLUMN';

        return defined($constant) ? constant($constant) : 'name';
    }

    public static function listForAdmin()
    {
        $instance = new static;
        $key = $instance->getKeyName();
        $nameColumn = static::lookupNameColumn();

        return static::query()
            ->orderBy($nameColumn)
            ->get([$key.' as id', $nameColumn.' as name']);
    }

    public static function createFromName(string $name)
    {
        $nameColumn = static::lookupNameColumn();

        return static::create([
            $nameColumn => trim($name),
        ]);
    }

    public static function updateNameById(int $id, string $name)
    {
        $record = static::query()->find($id);
        if (! $record) {
            throw new ModelNotFoundException(static::class.' not found.');
        }

        $record->update([
            static::lookupNameColumn() => trim($name),
        ]);

        return $record;
    }

    public static function deleteById(int $id): void
    {
        $record = static::query()->find($id);
        if (! $record) {
            throw new ModelNotFoundException(static::class.' not found.');
        }

        $record->delete();
    }
}
