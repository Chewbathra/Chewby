<?php

namespace Chewbathra\Chewby\Database;

use Chewbathra\Chewby\Facades\Config;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\DB;

class Blueprint extends BaseBlueprint
{
    private string $typesColumn = 'chewby_types';

    /**
     * Add / Update tracked models types depending on migrations done
     *
     * @param  string  $method
     * @return void
     */
    private function buildColumnsTypes(string $method): void
    {
        $modelTables = Config::getTrackedModels()->map(function ($model, $key) {
            return (new $model())->getTable();
        });
        if (! $modelTables->contains($this->table)) {
            return;
        }
        switch ($method) {
            case 'compileAdd':
            case 'compileCreate':
                foreach ($this->columns as $column) {
                    DB::insert(
                        "INSERT INTO $this->typesColumn (tableName, columnName, columnType) VALUES (?,?,?)", [
                            $this->table,
                            $column->get('name'),
                            $column->get('chewby_type') ?? $column->get('type'),
                        ]);
                }
                break;
            case 'compileChange':
                foreach ($this->columns as $column) {
                    DB::update("UPDATE $this->typesColumn SET columnType = ? WHERE tableName = ? AND columnName = ?", [
                        $column->get('chewby_type') ?? $column->get('type'),
                        $this->table,
                        $column->get('name'),
                    ]);
                }
                break;
            case 'compileRenameColumn':
                DB::update("UPDATE $this->typesColumn SET columnName = ? WHERE tableName = ? AND columnName = ?", [
                    $this->commands[0]->get('to'),
                    $this->table,
                    $this->commands[0]->get('from'),
                ]);
                break;
            case 'compileRename':
                DB::update("UPDATE $this->typesColumn SET tableName = ? WHERE tableName = ?", [
                    $this->commands[0]->get('to'),
                    $this->table,
                ]);
                break;
            case 'compileDropColumn':
                foreach ($this->commands[0]->get('columns') as $column) {
                    DB::delete("DELETE FROM $this->typesColumn WHERE tableName = ? AND columnName = ?", [
                        $this->table,
                        $column,
                    ]);
                }
                break;
            case 'compileDropIfExists':
            case 'compileDrop':
                DB::delete("DELETE FROM $this->typesColumn WHERE tableName = ?", [
                    $this->table,
                ]);
                break;
        }
    }

    /**
     * Get the raw SQL statements for the blueprint.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @param  \Illuminate\Database\Schema\Grammars\Grammar  $grammar
     * @return array
     */
    public function toSql(Connection $connection, Grammar $grammar)
    {
        $this->addImpliedCommands($grammar);

        $statements = [];

        // Each type of command has a corresponding compiler function on the schema
        // grammar which is used to build the necessary SQL statements to build
        // the blueprint element, so we'll just call that compilers function.
        $this->ensureCommandsAreValid($connection);

        foreach ($this->commands as $command) {
            /**
             * @phpstan-ignore-next-line
             */
            $method = 'compile'.ucfirst($command->name);

            if (method_exists($grammar, $method) || $grammar::hasMacro($method)) {
                if (! is_null($sql = $grammar->$method($this, $command, $connection))) {
                    $this->buildColumnsTypes($method);
                    $statements = array_merge($statements, (array) $sql);
                }
            }
        }

        return $statements;
    }

    /**
     * Create all needed columns for chewby models
     */
    public function neededColumns(): void
    {
        $this->id();
        $this->timestamps();
        $this->string('title')->nullable(false);
        $this->boolean('online')->nullable(false)->default(false);
        $this->dateTime('online_from')->nullable()->default(null);
        $this->dateTime('online_until')->nullable()->default(null);
    }

    /**
     * Create a new wysiwyg column on the table.
     *
     * @param  string  $column column name
     */
    public function wysiwyg(string $column): ColumnDefinition
    {
        return $this->addColumn('string', $column, ['chewby_type' => 'wysiwyg']);
    }

    /**
     * Create a new editor column on the table.
     *
     * @param  string  $column column name
     */
    public function editor(string $column = 'editor'): ColumnDefinition
    {
        return $this->addColumn('json', $column, ['chewby_type' => 'editor'])->nullable(true)->default(null);
    }
}
