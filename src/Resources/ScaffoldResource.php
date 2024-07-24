<?php

namespace Solutionforest\FilamentScaffold\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

class ScaffoldResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\TextInput::make('Table Name')
                        ->reactive()
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('Model', 'app\\Models\\' . ucfirst($state));
                            $set('Resource', 'app\\Filament\\Resources\\' . ucfirst($state) . 'Resource');
                            $set('Choose Table', $state);
                        })
                        ->required(),
                    Forms\Components\Select::make('Choose Table')
                        ->options(self::getAllTableNames())
                        ->reactive()
                        ->afterStateUpdated(function (Set $set, $state) {
                            $tableName = self::getAllTableNames()[$state];
                            $tableColumns = self::getTableColumns($tableName);
                            $set('Table Name', $tableName);
                            $set('Model', 'app\\Models\\' . ucfirst($tableName));
                            $set('Resource', 'app\\Filament\\Resources\\' . ucfirst($tableName) . 'Resource');
                            $set('Table', $tableColumns);
                        }),
                ])->columns(2),

                Forms\Components\TextInput::make('Model')
                    ->default('app\\Models\\')
                    ->columnStart(1),

                Forms\Components\TextInput::make('Resource')
                    ->default('app\\Filament\\Resources\\')
                    ->columnStart(1),

                Forms\Components\Split::make([
                    Forms\Components\Checkbox::make('Create Resource')
                        ->default(true),
                    Forms\Components\Checkbox::make('Create Model')
                        ->default(true),
                    Forms\Components\Checkbox::make('Create Migration'),
                    Forms\Components\Checkbox::make('Create Factory'),
                    Forms\Components\Checkbox::make('Create Controller'),
                ])->columnSpanFull(),

                Forms\Components\Repeater::make('Table')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Field Name')
                            ->required()
                            ->default(fn ($record) => $record['name'] ?? ''),
                        Forms\Components\TextInput::make('translation'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'varchar' => 'string',
                                'int' => 'integer',
                                'bigint' => 'bigInteger',
                                'text' => 'text',
                                'float' => 'float',
                                'double' => 'double',
                                'decimal' => 'decimal',
                                'bool' => 'boolean',
                                'date' => 'date',
                                'time' => 'time',
                                'datetime' => 'dateTime',
                                'timestamp' => 'timestamp',
                                'char' => 'char',
                                'mediumtext' => 'mediumText',
                                'longtext' => 'longText',
                                'tinyint' => 'tinyInteger',
                                'smallint' => 'smallInteger',
                                'mediumint' => 'mediumInteger',
                                'json' => 'json',
                                'jsonb' => 'jsonb',
                                'binary' => 'binary',
                                'enum' => 'enum',
                                'ipaddress' => 'ipAddress',
                                'macaddress' => 'macAddress',
                            ])
                            ->default(fn ($record) => $record['type'] ?? 'varchar')
                            ->reactive(),
                        Forms\Components\Checkbox::make('nullable')
                            ->inline(false)
                            ->default(fn ($record) => $record['nullable'] ?? false),
                        Forms\Components\Select::make('key')
                            ->default('')
                            ->options([
                                '' => 'NULL',
                                'PRI' => 'Primary',
                                'UNI' => 'Unique',
                                'MUL' => 'Index',
                            ])
                            ->default(fn ($record) => $record['key'] ?? ''),
                        Forms\Components\TextInput::make('default')
                            ->default(fn ($record) => $record['default'] ?? ''),
                        Forms\Components\Textarea::make('comment')
                            ->default(fn ($record) => $record['comment'] ?? ''),
                    ])->columns(7)->columnSpanFull(),
            ]);
    }

    public static function getAllTableNames(): array
    {
        $tables = DB::select('SHOW TABLES');

        return array_map('current', $tables);
    }

    public static function getTableColumns($tableName)
    {
        $columns = DB::select('SHOW COLUMNS FROM ' . $tableName);
        $columnDetails = [];

        foreach ($columns as $column) {
            if ($column->Key === 'PRI') {
                continue;
            }

            $type = preg_replace('/\(.+\)/', '', $column->Type);
            $type = preg_split('/\s+/', $type)[0];

            $columnDetails[] = [
                'name' => $column->Field,
                'type' => $type,
                'nullable' => $column->Null === 'YES',
                'key' => $column->Key,
                'default' => $column->Default,
                'comment' => '',
            ];
        }

        return $columnDetails;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateScaffold::route('/'),
        ];
    }

    public static function generateFiles(array $data)
    {
        $basePath = base_path();

        $model = preg_replace('/\(.+\)/', '', $data['Model']);
        $modelParts = explode('\\', $model);
        $modelName = end($modelParts);

        $resource = preg_replace('/\(.+\)/', '', $data['Resource']);
        $resourceParts = explode('\\', $resource);
        $resourcelName = end($resourceParts);

<<<<<<< HEAD
=======
        // $resourceCommand = "make:filament-resource " . ucfirst($resourcelName) . " --generate --view";
        // $modelCommand = "make:model " . ucfirst($modelName);
        // $modelWithMigrationCommand = $modelCommand . " -m";
        // $modelWithFactoryCommand = $modelCommand . " -f";
        // $modelWithMigrationNFactoryCommand = $modelCommand . " -m -f";
        // $controllerCommand = "make:controller " . ucfirst($data['Table Name']) . "Controller";

>>>>>>> f74e2327fa6a268f250803da2e81aec94ac9ba83
        chdir($basePath);
        $migrationPath = null;
        $resourcePath = null;
        $modelPath = null;

        if ($data['Create Model'] && $data['Create Migration'] && $data['Create Factory']) {
            Artisan::call('make:model', [
                'name' => $modelName,
                '-m' => true,
                '-f' => true,
            ]);
            $output = Artisan::output();
            if (strpos($output, 'Migration') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $migrationPath = $matches[1] ?? null;
            }
            if (strpos($output, 'Model') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $modelPath = $matches[1] ?? null;
            }
        } elseif ($data['Create Model'] && $data['Create Migration']) {
            Artisan::call('make:model', [
                'name' => $modelName,
                '-m' => true,
            ]);
            $output = Artisan::output();
            if (strpos($output, 'Migration') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $migrationPath = $matches[1] ?? null;
            }
            if (strpos($output, 'Model') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $modelPath = $matches[1] ?? null;
            }
        } elseif ($data['Create Model'] && $data['Create Factory']) {
            Artisan::call('make:model', [
                'name' => $modelName,
                '-f' => true,
            ]);
            $output = Artisan::output();
            if (strpos($output, 'Model') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $modelPath = $matches[1] ?? null;
            }
        } elseif ($data['Create Model']) {
            Artisan::call('make:model', [
                'name' => $modelName,
            ]);
            $output = Artisan::output();
            if (strpos($output, 'Model') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $modelPath = $matches[1] ?? null;
            }
        }

        if ($data['Create Resource']) {
            Artisan::call('make:filament-resource', [
                'name' => $resourcelName,
                '--generate' => true,
                '--view' => true,
                '--force' => true,
            ]);
            $output = Artisan::output();
            preg_match('/\[([^\]]+)\]/', $output, $matches);
            $resourcePath = $matches[1] ?? null;
        }

        if ($data['Create Controller']) {
            Artisan::call('make:controller', [
                'name' => $data['Table Name'] . 'Controller',
            ]);
        }

        self::overwriteResourceFile($resourcePath, $data);
        self::overwriteMigrationFile($migrationPath, $data);
        self::overwriteModelFile($modelPath, $data);
    }

    public static function overwriteResourceFile($resourceFile, $data)
    {
        $model = preg_replace('/\(.+\)/', '', $data['Model']);
        $modelParts = explode('\\', $model);
        $modelName = end($modelParts);

        if (file_exists($resourceFile)) {
            $content = file_get_contents($resourceFile);

            $formSchema = self::generateFormSchema($data);
            $tableSchema = self::generateTableSchema($data);
            $useClassChange = <<<EOD
                use App\\Models\\$modelName;
                EOD;

            $classChange = <<<EOD
                protected static ?string \$model = $modelName::class;
                EOD;

            $formFunction = <<<EOD
                public static function form(Form \$form): Form
                {
                    return \$form
                        ->schema($formSchema);
                }
                EOD;

            $tableFunction = <<<EOD
                public static function table(Table \$table): Table
                {
                    return \$table
                        ->columns($tableSchema)
                        ->filters([
                            //
                        ])
                        ->actions([
                            Tables\Actions\ViewAction::make(),
                            Tables\Actions\EditAction::make(),
                        ])
                        ->bulkActions([
                            Tables\Actions\BulkActionGroup::make([
                                Tables\Actions\DeleteBulkAction::make(),
                            ]),
                        ]);
                }
                EOD;

            $content = preg_replace('/use\s+App\\\\Models\\\\.*?;/s', $useClassChange, $content);
            $content = preg_replace('/protected static\s+\?string\s+\$model\s*=\s*[^\;]+;/s', $classChange, $content);
            $content = preg_replace('/public static function form.*?{.*?}/s', $formFunction, $content);
            $content = preg_replace('/public static function table.*?{.*?}/s', $tableFunction, $content);

            file_put_contents($resourceFile, $content);
        }
    }

    public static function generateFormSchema($data)
    {
        $fields = [];
        foreach ($data['Table'] as $column) {
            $fields[] = "Forms\Components\TextInput::make('{$column['name']}')->required()";
        }

        return '[' . implode(",\n", $fields) . ']';
    }

    public static function generateTableSchema($data)
    {
        $columns = [];
        foreach ($data['Table'] as $column) {
            $columns[] = "Tables\Columns\TextColumn::make('{$column['name']}')->sortable()->searchable()";
        }

        return '[' . implode(",\n", $columns) . ']';
    }

    public static function overwriteMigrationFile($filePath, $data)
    {
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);

            $upPart = self::generateUp($data);
            $upFunction = <<<EOD
                public function up(): void
                {
                    Schema::create('{$data['Table Name']}', function (Blueprint \$table) {
                        \$table->id();
                        \$table->timestamps();
                        $upPart;
                }
                EOD;

            $downFunction = <<<EOD
                public function down()
                {
                    Schema::dropIfExists('{$data['Table Name']}');
                }
                EOD;

            $content = preg_replace('/public function up.*?{.*?}/s', $upFunction, $content);
            $content = preg_replace('/public function down.*?{.*?}/s', $downFunction, $content);

            file_put_contents($filePath, $content);
        }
    }

    public static function generateUp($data)
    {
        $fields = [];
        foreach ($data['Table'] as $column) {
            if ($column['nullable'] == true && $column['default'] != null && $column['comment'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->default('{$column['default']}')->comment('{$column['comment']}')->{$column['key']}()";
            } elseif ($column['nullable'] == true && $column['default'] != null && $column['comment'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->default('{$column['default']}')->comment('{$column['comment']}')";
            } elseif ($column['nullable'] == true && $column['default'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->default('{$column['default']}')->{$column['key']}()";
            } elseif ($column['nullable'] == true && $column['comment'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->comment('{$column['comment']}')->{$column['key']}()";
            } elseif ($column['default'] != null && $column['comment'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->default('{$column['default']}')->comment('{$column['comment']}')->{$column['key']}()";
            } elseif ($column['nullable'] == true && $column['default'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->default('{$column['default']}')";
            } elseif ($column['nullable'] == true && $column['comment'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->comment('{$column['comment']}')";
            } elseif ($column['nullable'] == true && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()->{$column['key']}()";
            } elseif ($column['comment'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->comment('{$column['comment']}')->{$column['key']}()";
            } elseif ($column['default'] != null && $column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->default('{$column['default']}')->{$column['key']}()";
            } elseif ($column['default'] != null && $column['comment'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->default('{$column['default']}')->comment('{$column['comment']}')";
            } elseif ($column['nullable'] == true) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->nullable()";
            } elseif ($column['default'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->default('{$column['default']}')";
            } elseif ($column['comment'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->comment('{$column['comment']}')";
            } elseif ($column['key'] != null) {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')->{$column['key']}()";
            } else {
                $fields[] = "\$table->{$column['type']}('{$column['name']}')";
            }

        }

        return implode(";\n", $fields);
    }

    public static function overwriteModelFile($filePath, $data)
    {
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);

            $chooseTable = <<<EOD
                use HasFactory;
                protected \$table = '{$data['Table Name']}';
                EOD;

            $content = preg_replace('/use HasFactory;/s', $chooseTable, $content);

            file_put_contents($filePath, $content);
        }
    }
}
