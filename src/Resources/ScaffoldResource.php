<?php

namespace Solutionforest\FilamentScaffold\Resources;

use Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                    // Forms\Components\Checkbox::make('Create Controller'),
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
                                'string' => 'string',
                                'integer' => 'integer',
                                'bigInteger' => 'bigInteger',
                                'text' => 'text',
                                'float' => 'float',
                                'double' => 'double',
                                'decimal' => 'decimal',
                                'boolean' => 'boolean',
                                'date' => 'date',
                                'time' => 'time',
                                'datetime' => 'dateTime',
                                'timestamp' => 'timestamp',
                                'char' => 'char',
                                'mediumText' => 'mediumText',
                                'longText' => 'longText',
                                'tinyInteger' => 'tinyInteger',
                                'smallInteger' => 'smallInteger',
                                'mediumInteger' => 'mediumInteger',
                                'json' => 'json',
                                'jsonb' => 'jsonb',
                                'binary' => 'binary',
                                'enum' => 'enum',
                                'ipAddress' => 'ipAddress',
                                'macAddress' => 'macAddress',
                            ])
                            ->default(fn ($record) => $record['type'] ?? 'string')
                            ->reactive(),
                        Forms\Components\Checkbox::make('nullable')
                            ->inline(false)
                            ->default(fn ($record) => $record['nullable'] ?? false),
                        Forms\Components\Select::make('key')
                            ->default('')
                            ->options([
                                '' => 'NULL',
                                'primary' => 'Primary',
                                'unique' => 'Unique',
                                'index' => 'Index',
                            ])
                            ->default(fn ($record) => $record['key'] ?? ''),
                        Forms\Components\TextInput::make('default')
                            ->default(fn ($record) => $record['default'] ?? ''),
                        Forms\Components\Textarea::make('comment')
                            ->default(fn ($record) => $record['comment'] ?? ''),
                    ])->columns(7)->columnSpanFull(),
                Forms\Components\Split::make([
                    Forms\Components\Checkbox::make('Created_at & Updated_at')
                        ->inline(),
                    Forms\Components\Checkbox::make('Soft Delete')
                        ->inline(),
                ])->columnSpanFull(),
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

        $typeMapping = [
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
        ];

        $keyMapping = [
            'PRI' => 'primary',
            'UNI' => 'unique',
            'MUL' => 'index',
        ];

        foreach ($columns as $column) {
            if ($column->Field === 'id' || $column->Field === 'ID') {
                continue;
            }

            $type = preg_replace('/\(.+\)/', '', $column->Type);
            $type = preg_split('/\s+/', $type)[0];

            $key = $column->Key;

            $translatedType = $typeMapping[$type] ?? $type;
            $translatedKey = $keyMapping[$key] ?? $key;

            $columnDetails[] = [
                'name' => $column->Field,
                'type' => $translatedType,
                'nullable' => $column->Null === 'YES',
                'key' => $translatedKey,
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

        chdir($basePath);
        $migrationPath = null;
        $resourcePath = null;
        $modelPath = null;

        if ($data['Create Migration']) {
            Artisan::call('make:migration', [
                'name' => 'create_' . $data['Table Name'] . '_table'
            ]);
            $output = Artisan::output();
            if (strpos($output, 'Migration') !== false) {
                preg_match('/\[([^\]]+)\]/', $output, $matches);
                $migrationPath = $matches[1] ?? null;
            }
        } 

        if ($data['Create Factory']) {
            Artisan::call('make:factory', [
                'name' => $data['Table Name'] . 'Factory'
            ]);
        }

        if ($data['Create Model']) {
            Artisan::call('make:model', [
                'name' => $modelName
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

        // if ($data['Create Controller']) {
        //     Artisan::call('make:controller', [
        //         'name' => $data['Table Name'] . 'Controller'
        //     ]);
        // }

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
        return "[" . implode(",\n", $fields) . "]";
    }

    public static function generateTableSchema($data)
    {
        $columns = [];
        foreach ($data['Table'] as $column) {
            $columns[] = "Tables\Columns\TextColumn::make('{$column['name']}')->sortable()->searchable()";
        }
        return "[" . implode(",\n", $columns) . "]";
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

    public static function generateUp(array $data): string
    {
        $fields = array_map(
            fn(array $column): string => self::generateColumnDefinition($column),
            $data['Table']
            );

        if($data['Created_at & Updated_at']==true) {
            $fields[] = "\$table->timestamps()";
        }
        
        if($data['Soft Delete']==true) {
            $fields[] = "\$table->softDeletes()";
        }
            
        return implode(";\n", $fields);
    }

    private static function generateColumnDefinition(array $column): string
    {
        $definition = "\$table->{$column['type']}('{$column['name']}')";

        $methods = [
            'nullable' => fn(): bool => $column['nullable'] ?? false,
            'default' => fn(): ?string => $column['default'] ?? null,
            'comment' => fn(): ?string => $column['comment'] ?? null,
            'key' => fn(): ?string => $column['key'] ?? null,
        ];

        foreach ($methods as $method => $condition) {
            $value = $condition();
            if ($value !== null && $value !== false) {
                $definition .= match ($method) {
                    'nullable' => "->nullable()",
                    'default' => "->default('{$value}')",
                    'comment' => "->comment('{$value}')",
                    'key' => "->{$value}()",
                };
            }
        }

        return $definition;
    }

    public static function overwriteModelFile($filePath, $data)
    {
        $column = self::getColumn($data);

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $useSoftDel = <<<EOD
                use Illuminate\Database\Eloquent\Model;
                use Illuminate\Database\Eloquent\SoftDeletes;
                EOD;

            $chooseTable = <<<EOD
                use HasFactory;
                protected \$table = '{$data['Table Name']}';
                protected \$fillable = $column;
                EOD;

            $withSoftdel = <<<EOD
                use HasFactory;
                use SoftDeletes;
                protected \$table = '{$data['Table Name']}';
                protected \$fillable = $column;
                EOD;

            if($data['Soft Delete']==true) {
                $content = preg_replace('/use Illuminate\\\\Database\\\\Eloquent\\\\Model;/s', $useSoftDel, $content);
                $content = preg_replace('/use HasFactory;/s', $withSoftdel, $content);
            } else {
                $content = preg_replace('/use HasFactory;/s', $chooseTable, $content);
            }
            file_put_contents($filePath, $content);
        }
    }

    public static function getColumn($data)
    {
        $fields = [];
        foreach ($data['Table'] as $column) {
            $fields[] = "{$column['name']}";
        }
        return "['" . implode("','", $fields) . "']";
    }
}
