<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD Files';

    private $json;
    private $varModelName;
    private $modelName;
    private $varRepoName;
    private $repoName;
    private $tableName;
    private $FILLABLES;
    private $controllerName;
    private $requestName;
    private $folderViewName;
    private $routeName;
    private $STOREVALIDATIONS;
    private $UPDATEVALIDATIONS;
    private $arrayColumns;
    private $moduleName;
    private $arrayTH;
    private $arrayTD;
    private $exportClassName;
    private $importClassName;
    private $icon;
    private $controllerApiPath;
    private $requestApiPath;
    private $permissionPath;
    private $menuSettingPath;
    private $routePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function setColumnsWithTab($tab = 1)
    {
        $columns = '';
        $i = 0;
        $count = count($this->arrayColumns);
        $tabs = collect(range(1, $tab))->transform(function ($item) {
            return "\t";
        })->toArray();
        $tabs = implode('', $tabs);
        foreach ($this->arrayColumns as $column) {
            if ($i < $count - 1)
                $columns .= "$tabs'$column',\n";
            else
                $columns .= "$tabs'$column',";
            $i++;
        }
        return $columns;
    }

    private function setTab(array $data, $tabSize = 0, $spacing = 2)
    {
        $spaces = collect(range(1, $spacing))->transform(function ($item) {
            return " ";
        })->toArray();
        $spaces = implode('', $spaces);
        $tabs = collect(range(1, $tabSize))->transform(function ($item) use ($spaces) {
            return $spaces;
        })->toArray();
        $tabs = implode('', $tabs);

        $columns = '';
        $count = count($data);
        $i = 0;
        foreach ($data as $column) {
            if ($i < $count - 1)
                $columns .= "$tabs$column\n";
            else
                $columns .= "$tabs$column";
            $i++;
        }
        return $columns;
    }

    public function getRequired($required)
    {
        if ($required === false)
            $requiredText = 'false';
        else if ($required == 2)
            $requiredText = 'true';
        else if ($required == 1)
            $requiredText = 'isset($d)';
        else if ($required == 0)
            $requiredText = '!isset($d)';
        return $requiredText ?? '';
    }

    public function generateMigration($column)
    {
        $STRUCTURE = '';
        if ($column->type === 'ai')
            $STRUCTURE .= '$table->id()';
        else if ($column->type === 'timestamps')
            $STRUCTURE .= '$table->timestamps()';
        else if (in_array($column->type, ['date', 'tinyInteger', 'text', 'unsignedInteger', 'unsignedBigInteger'])) {
            $STRUCTURE .= '$table->' . $column->type . '(\'' . $column->name . '\')';
        } else {
            $STRUCTURE .= '$table->string(\'' . $column->name . '\', ' . ($column->length ?? 191) . ')';
        }
        if ($column->nullable ?? false) {
            $STRUCTURE .= '->nullable()';
        }
        if ($column->unique ?? false) {
            $STRUCTURE .= '->unique()';
        }
        if (isset($column->foreign) && $column->foreign && $column->foreign->on) {
            $STRUCTURE .= ";\n\t\t\t" . '$table->foreign(\'' . $column->name . '\')->on(\'' . $column->foreign->on . '\')->references(\'' . $column->foreign->references . '\')->onUpdate(\'' . ($column->foreign->onUpdate ?? 'cascade') . '\')->onDelete(\'' . ($column->foreign->onDelete ?? 'cascade') . '\')';
        }
        $STRUCTURE .= ";\n\t\t\t";
        return $STRUCTURE;
    }

    public function generateInput($type, $label, $name, $required = 2, $accept = '')
    {
        $requiredText = $this->getRequired($required);

        if ($accept) {
            $accept = ", 'accept'=>'$accept'";
        }

        if ($type === 'colorpicker') {
            return "\t\t\t\t<div class=\"col-md-6\">
                  @include('stisla.includes.forms.inputs.input-colorpicker', ['required'=>$requiredText, 'type'=>'$type', 'id'=>'$name', 'name'=>'$name', 'label'=>__('" . $label . "')$accept])
                </div>\n\n";
        }

        if ($type === 'textarea') {
            return "\t\t\t\t<div class=\"col-md-6\">
                  @include('stisla.includes.forms.editors.textarea', ['required'=>$requiredText, 'type'=>'$type', 'id'=>'$name', 'name'=>'$name', 'label'=>__('" . $label . "')$accept])
                </div>\n\n";
        }

        $type = str_replace('input', '', $type);

        return "\t\t\t\t<div class=\"col-md-6\">
                  @include('stisla.includes.forms.inputs.input', ['required'=>$requiredText, 'type'=>'$type', 'id'=>'$name', 'name'=>'$name', 'label'=>__('" . $label . "')$accept])
                </div>\n\n";
    }

    public function generateSelect($type, $label, $name, $required, $options, $multiple = false)
    {
        $requiredText = $this->getRequired($required);
        $multiple = ($multiple ?? false) ? 'true' : 'false';
        return "\t\t\t\t<div class=\"col-md-6\">
                  @include('stisla.includes.forms.selects.select2', ['required'=>$requiredText, 'id'=>'$name', 'name'=>'$name', 'label'=>__('" . $label . "'), 'options'=>" . $options . ", 'multiple'=>" . $multiple . "])
                </div>\n\n";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        if (!$filename) {
            $examplePath = app_path('Console/Commands/data/crud/files/student.json');
            $filename = $this->ask('CRUD Filename? (check example in ' . $examplePath . ') type like this [student]');
        }
        if (!$filename) {
            $this->error("CRUD file required");
            return 0;
        }
        // $filename = 'student';
        // $filename = 'product';

        $filepath = app_path('Console/Commands/data/crud/files/' . $filename . '.json');
        if (File::exists($filepath) === false) {
            $this->error("File not found");
            return 0;
        }

        $this->json = json_decode(file_get_contents($filepath));

        $this->modelName      = $modelName = $this->json->model;
        $this->varModelName = Str::camel($modelName);
        $this->repoName       = $modelName . 'Repository';
        $this->varRepoName    = Str::camel($modelName) . 'Repository';
        $controllerName = $this->controllerName = $modelName . 'Controller';
        $exportClassName = $this->exportClassName = $modelName . 'Export';
        $importClassName = $this->importClassName = $modelName . 'Import';
        $this->icon = $this->json->icon;
        $this->moduleName = $this->json->title;
        $this->requestName = $modelName . 'Request';
        $routeName = $this->routeName = $this->folderViewName = $folderViewName = Str::plural(Str::kebab($modelName));
        $modelNameSnake       = Str::snake($modelName);
        $migrationExample     = file_get_contents(
            app_path(
                'Console/Commands/data/crud/migration.php.dummy'
            )
        );
        $this->tableName = $TABLENAME = Str::plural($modelNameSnake);
        $migrationContent = str_replace('TABLENAME', $TABLENAME, $migrationExample);
        $MIGRATIONNAME = 'Create' . $modelName . 'Table';
        $migrationContent = str_replace('MIGRATIONNAME', $MIGRATIONNAME, $migrationContent);
        $FILLABLES = '';
        $STRUCTURE = '';
        $UPDATEVALIDATIONS = '';
        $STOREVALIDATIONS = '';
        $TH = '';
        $TD = '';
        $FORM = '';
        $TYPESVALUE = '';
        $SEEDERCOLUMNS = '';
        $this->arrayColumns = collect($this->json->columns)
            ->pluck('name')
            ->filter(function ($item) {
                return $item !== null;
            })
            ->values()
            ->toArray();
        foreach ($this->json->columns as $column) {

            // setup migration
            $STRUCTURE .= $this->generateMigration($column);

            // generate seeder
            if (in_array($column->type, ['date', 'tinyInteger', 'text'])) {
                $FILLABLES .= "'" . $column->name . "', ";
                if ($column->type === 'date')
                    $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => $faker->date("Y-m-d", $max = date("Y-m-d")), // ganti method fakernya sesuai kebutuhan' . "\n\t\t\t\t";
                else if (isset($column->options)) {
                    $max = count($column->options) - 1;
                    $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => $faker->numberBetween(0, ' . $max . '), // ganti method fakernya sesuai kebutuhan' . "\n\t\t\t\t";
                } else
                    $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => $faker->numberBetween(0,1000), // ganti method fakernya sesuai kebutuhan' . "\n\t\t\t\t";
            } elseif (in_array($column->type, ['ai', 'timestamps'])) {
            } else {
                $FILLABLES .= "'" . $column->name . "', ";
                $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => Str::random(10),' . "\n\t\t\t\t";
            }

            // setup TH dan TD
            if (!($column->type === 'ai' || $column->type === 'timestamps')) {
                $label = $column->label ?? Str::title(str_replace('_', ' ', $column->name));
                $th = "<th class=\"text-center\">{{ __('" . $label . "') }}</th>";
                $TH .= "\t\t$th\n";
                if (isset($column->options)) {
                    $td = "<td>" . '{{ \App\Models\\' . $modelName . '::TYPES[\'' . $column->name . '\'][$item->' . $column->name . "] }}</td>";
                } else {
                    $td = "<td>" . '{{ $item->' . $column->name . " }}</td>";
                }
                $TD .= "\t\t$td\n";
                $this->arrayTH[] = $th;
                $this->arrayTD[] = $td;
            }

            if (isset($column->validations)) {
                if (isset($column->validations->store)) {
                    $STOREVALIDATIONS .= "\t\t\t'" . $column->name . '\' => ' . json_encode($column->validations->store) . ",\n";
                }
                if (isset($column->validations->update)) {
                    $UPDATEVALIDATIONS .= "\t\t\t\t'" . $column->name . '\' => ' . json_encode($column->validations->store) . ",\n";
                    // $UPDATEVALIDATIONS .= $column->name . ' => ' . json_encode($column->validations->store);
                }
            }

            if (isset($column->options)) {
                $options = json_decode(json_encode($column->options), true);
                $values = collect($options)->pluck('value');
                $newOptions = [];
                $values->each(function ($item) use (&$newOptions, $options) {
                    return $newOptions[(string)$item] = $options[$item]['label'];
                });
                // dd($newOptions);
                // $newOptions
                $options = json_encode($newOptions);
                $TYPESVALUE .= "\n\t\t'" . $column->name . "' => " . $options;
            }

            if (isset($column->form)) {
                $label = $column->label ?? Str::title(str_replace('_', ' ', $column->name));
                $name = $column->name;
                $required = $column->form->required;
                $type = $column->form->type;
                switch ($column->form->type) {
                    case 'text':
                    case 'inputtext':
                    case 'email':
                    case 'inputemail':
                    case 'password':
                    case 'inputpassword':
                    case 'number':
                    case 'inputnumber':
                    case 'time':
                    case 'inputtime':
                    case 'colorpicker':
                    case 'date':
                    case 'inputdate':
                    case 'textarea':
                        $FORM .= $this->generateInput($type, $label, $name, $required);
                        break;
                    case 'image':
                        $FORM .= $this->generateInput('file', $label, $name, $required, 'image/*');
                        break;
                    case 'file':
                        $FORM .= $this->generateInput('file', $label, $name, $required, '*');
                        break;
                    case 'select2':
                    case 'select':
                        $options = json_encode($column->form->options ?? []);
                        $multiple = $column->form->multiple ?? false;
                        $FORM .= $this->generateSelect($type, $label, $name, $required, $options, $multiple);
                        break;
                    case 'radio':
                        $options = json_decode(json_encode($column->options), true);
                        $values = collect($options)->pluck('value');
                        $newOptions = [];
                        $values->each(function ($item) use (&$newOptions, $options) {
                            return $newOptions[(string)$item] = $options[$item]['label'];
                        });
                        $requiredText = $this->getRequired($required);
                        $options = json_encode($newOptions);
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('stisla.includes.forms.inputs.input-radio-toggle', ['required'=>$requiredText, 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "'), 'options'=>" . $options . "])
                </div>\n\n";
                        break;
                }
            }
        }

        $this->UPDATEVALIDATIONS = $UPDATEVALIDATIONS;
        $this->STOREVALIDATIONS = $STOREVALIDATIONS;
        $this->FILLABLES = $FILLABLES;

        $migrationContent = str_replace('STRUCTURE', $STRUCTURE, $migrationContent);
        $migrationFiles = File::files(database_path('migrations'));
        $migrationFiles = array_map(function ($item) {
            return substr(
                str_replace(database_path('migrations') . '/', '', $item->getPathname()),
                18
            );
        }, $migrationFiles);
        $migrationFileNames = getFileNamesFromDir(database_path('migrations'));
        $exist = false;
        foreach ($migrationFileNames as $migrationFileName) {
            $contain = Str::contains($migrationFileName, '_create_' . $modelNameSnake . '_table.php');
            if ($contain) {
                $migrationPath = database_path('migrations/' . $migrationFileName);
                file_put_contents($migrationPath, $migrationContent);
                $exist = true;
                break;
            }
            // if($migrationFileName)
        }
        if ($exist === false) {
            $migrationPath = database_path('migrations/' . date('Y_m_d_His') . '_create_' . $modelNameSnake . '_table.php');
            file_put_contents($migrationPath, $migrationContent);
        }

        // CREATE MODEL
        $modelExample = file_get_contents(
            app_path(
                'Console/Commands/data/crud/model.php.dummy'
            )
        );
        $modelContent = str_replace('TABLENAME', $TABLENAME, $modelExample);
        $modelContent = str_replace('FILLABLES', $this->setColumnsWithTab(2), $modelContent);
        $modelContent = str_replace('MODELNAME', $modelName, $modelContent);
        $modelContent = str_replace('TYPESVALUE', '[' . $TYPESVALUE . "\n\t]", $modelContent);
        file_put_contents($modelPath = app_path('Models/' . $modelName . '.php'), $modelContent);

        // CREATE REPOSITORY
        $repositoryFile = file_get_contents(app_path('Console/Commands/data/NameRepository.php.dummy'));
        $repositoryFile = str_replace('ModelName', $modelName, $repositoryFile);
        $repositoryFile = str_replace('NameRepository', $modelName . 'Repository', $repositoryFile);
        $filepath = app_path('Repositories/' . $modelName . 'Repository.php');
        file_put_contents($repositoryPath = $filepath, $repositoryFile);

        // CREATE CONTROLLER
        $controllerFile = file_get_contents(
            app_path(
                'Console/Commands/data/crud/controller2.php.dummy'
            )
        );
        $controllerFile = str_replace('TITLE', $this->json->title, $controllerFile);
        $controllerFile = str_replace('CONTROLLERNAME', $modelName . 'Controller', $controllerFile);
        $controllerFile = str_replace('VARREPOSITORYNAME', Str::camel($modelName) . 'Repository', $controllerFile);
        $controllerFile = str_replace('REPOSITORYNAME', $modelName . 'Repository', $controllerFile);
        $controllerFile = str_replace('VARMODELNAME', Str::camel($modelName), $controllerFile);
        $controllerFile = str_replace('MODELNAME', $modelName, $controllerFile);
        $controllerFile = str_replace('REQUESTNAME', $modelName . 'Request', $controllerFile);
        $controllerFile = str_replace('COLUMNS', $this->setColumnsWithTab(3), $controllerFile);
        $controllerFile = str_replace('FOLDERVIEW', $folderViewName, $controllerFile);
        $controllerFile = str_replace('ROUTENAME', $this->routeName, $controllerFile);
        $controllerFile = str_replace('EXPORTCLASSNAME', $this->exportClassName, $controllerFile);
        $controllerFile = str_replace('IMPORTCLASSNAME', $this->importClassName, $controllerFile);
        $filepath = app_path('Http/Controllers/' . $modelName . 'Controller.php');
        file_put_contents($controllerPath = $filepath, $controllerFile);

        // CREATE REQUEST
        $requestFile = file_get_contents(
            app_path(
                'Console/Commands/data/crud/request.php.dummy'
            )
        );
        $requestFile = str_replace('REQUESTNAME', $modelName . 'Request', $requestFile);
        $requestFile = str_replace('UPDATEVALIDATIONS', $UPDATEVALIDATIONS, $requestFile);
        $requestFile = str_replace('STOREVALIDATIONS', $STOREVALIDATIONS, $requestFile);
        $filepath    = app_path('Http/Requests/' . $modelName . 'Request.php');
        file_put_contents($requestPath = $filepath, $requestFile);

        // CREATE VIEWS
        $viewIndexFile = file_get_contents(app_path('Console/Commands/data/crud/views/index2.blade.php.dummy'));
        $viewIndexFile = str_replace('TITLE', $this->json->title, $viewIndexFile);
        $viewIndexFile = str_replace('ROUTE', $routeName, $viewIndexFile);
        $viewIndexFile = str_replace('ICON', $this->json->icon, $viewIndexFile);
        $viewIndexFile = str_replace('TH', $this->setTab($this->arrayTH, 11, 2), $viewIndexFile);
        $viewIndexFile = str_replace('TD', $this->setTab($this->arrayTD, 12, 2), $viewIndexFile);
        $folder = base_path('resources/views/stisla/') . $folderViewName;
        // dd($folder);
        if (!file_exists($folder)) {
            File::makeDirectory($folder);
            // mkdir($folder);
        }
        $filepath    = $folder . '/index.blade.php';
        file_put_contents($viewIndexPath = $filepath, $viewIndexFile);

        $viewFormFile = file_get_contents(app_path('Console/Commands/data/crud/views/form.blade.php.dummy'));
        $viewFormFile = str_replace('TITLE', $this->json->title, $viewFormFile);
        $viewFormFile = str_replace('ROUTE', $routeName, $viewFormFile);
        $viewFormFile = str_replace('ICON', $this->json->icon, $viewFormFile);
        $viewFormFile = str_replace('FORM', $FORM, $viewFormFile);
        $filepath    = $folder . '/form.blade.php';
        file_put_contents($viewCreatePath = $filepath, $viewFormFile);

        $viewExportExcelFile = file_get_contents(app_path('Console/Commands/data/crud/views/export-excel-example.blade.php.dummy'));
        $viewExportExcelFile = str_replace('TH', $this->setTab($this->arrayTH, 3, 2), $viewExportExcelFile);
        $viewExportExcelFile = str_replace('TD', $this->setTab($this->arrayTD, 4, 2), $viewExportExcelFile);
        $viewExportExcelPath    = $folder . '/export-excel-example.blade.php';
        file_put_contents($viewExportExcelPath, $viewExportExcelFile);

        $viewExportPdf = file_get_contents(app_path('Console/Commands/data/crud/views/export-pdf.blade.php.dummy'));
        $viewExportPdf = str_replace('TITLE', $this->json->title, $viewExportPdf);
        $viewExportPdf = str_replace('TH', $this->setTab($this->arrayTH, 4, 2), $viewExportPdf);
        $viewExportPdf = str_replace('TD', $this->setTab($this->arrayTD, 5, 2), $viewExportPdf);
        $viewExportPdfPath    = $folder . '/export-pdf.blade.php';
        file_put_contents($viewExportPdfPath, $viewExportPdf);

        $exportExcelFile = file_get_contents(app_path('Console/Commands/data/crud/export.php.dummy'));
        $exportExcelFile = str_replace('FOLDERVIEW', $folderViewName, $exportExcelFile);
        $exportExcelFile = str_replace('MODELNAME', $modelName, $exportExcelFile);
        $exportExcelFile = str_replace('FILLABLES', $this->setColumnsWithTab(4), $exportExcelFile);
        $exportExcelPath = app_path('Exports/' . $modelName . 'Export.php');
        file_put_contents($exportExcelPath, $exportExcelFile);

        $importExcelFile = file_get_contents(app_path('Console/Commands/data/crud/import.php.dummy'));
        $importExcelFile = str_replace('MODELNAME', $modelName, $importExcelFile);
        $importExcelPath = app_path('Imports/' . $modelName . 'Import.php');
        file_put_contents($importExcelPath, $importExcelFile);

        // SEEDER
        $seederFile = file_get_contents(app_path('Console/Commands/data/crud/seeder.php.dummy'));
        $seederFile = str_replace('MODELNAME', $modelName, $seederFile);
        $seederFile = str_replace('SEEDERCOLUMNS', $SEEDERCOLUMNS, $seederFile);
        $seederPath = database_path('seeders/' . $modelName . 'Seeder.php');
        file_put_contents($seederPath, $seederFile);

        // MENU
        $menuContent = file_get_contents(app_path('Console/Commands/data/crud/menu.json.dummy'));
        $menuContent = str_replace('TITLE', $this->json->title, $menuContent);
        $menuContent = str_replace('ROUTENAME', $this->routeName, $menuContent);
        $menuContent = str_replace('ICON', $this->icon, $menuContent);
        $menuContent = str_replace('PERMISSION', $this->json->title, $menuContent);
        $folderMenu = database_path('seeders/data/menu-modules');
        if (!file_exists($folderMenu)) {
            mkdir($folderMenu);
        }
        $this->menuSettingPath = $menuPath = $folderMenu . '/' . $this->routeName . '.json';
        file_put_contents($menuPath, $menuContent);

        $this->apiController();
        $this->apiRequest();
        $this->permission();
        $this->routing();

        $logs = [];
        $createdFile = 0;
        if (isset($migrationPath))
            $this->info($logs[] = 'Created migration file => ' . $migrationPath);
        $createdFile++;
        $this->info($logs[] = 'Created seeder file => ' . $seederPath);
        $createdFile++;
        $this->info($logs[] = 'Created model file => ' . $modelPath);
        $createdFile++;
        $this->info($logs[] = 'Created controller file => ' . $controllerPath);
        $createdFile++;
        $this->info($logs[] = 'Created api controller file => ' . $this->controllerApiPath);
        $createdFile++;
        $this->info($logs[] = 'Created repository file => ' . $repositoryPath);
        $createdFile++;
        $this->info($logs[] = 'Created request file => ' . $requestPath);
        $createdFile++;
        $this->info($logs[] = 'Created api request file => ' . $this->requestApiPath);
        $createdFile++;
        $this->info($logs[] = 'Created export excel file => ' . $exportExcelPath);
        $createdFile++;
        $this->info($logs[] = 'Created import excel file => ' . $importExcelPath);
        $createdFile++;
        $this->info($logs[] = 'Created view index file => ' . $viewIndexPath);
        $createdFile++;
        $this->info($logs[] = 'Created view form file => ' . $viewCreatePath);
        $createdFile++;
        $this->info($logs[] = 'Created view export pdf file => ' . $viewExportPdfPath);
        $createdFile++;
        $this->info($logs[] = 'Created view export excel example file => ' . $viewExportExcelPath);
        $createdFile++;
        $this->info($logs[] = 'Created permission file => ' . $this->permissionPath);
        $createdFile++;
        $this->info($logs[] = 'Created routing file => ' . $this->routePath);
        $createdFile++;
        $this->info($logs[] = 'Created menu setting file => ' . $this->menuSettingPath);
        $createdFile++;
        $this->info($logs[] = "Created $createdFile files");

        $logComplete = implode("\n", $logs);
        $folderLog   = app_path('Console/Commands/data/crud/logs');
        createFolder($folderLog);
        $logPath     = $folderLog . '/' . $filename . '.log';
        file_put_contents($logPath, $logComplete);

        $logs = collect($logs)->transform(function ($item) {
            return explode(' => ', $item);
        })->toArray();
        $logComplete = json_encode($logs);
        $logPath = app_path('Console/Commands/data/crud/logs/' . $filename . '.json');
        file_put_contents($logPath, $logComplete);
        // $this->info('Don\'t forget to run php artisan migrate');
        // $this->info('copy this to your route file 👇');

        // for copy route
        $fullControllerName = '\App\Http\Controllers\\' . $controllerName . '::class';
        // $this->info('Route::get(\'' . $routeName . '/pdf\', [' . $fullControllerName . ', \'pdf\'])->name(\'' . $routeName . '.pdf\');');
        // $this->info('Route::get(\'' . $routeName . '/csv\', [' . $fullControllerName . ', \'csv\'])->name(\'' . $routeName . '.csv\');');
        // $this->info('Route::get(\'' . $routeName . '/json\', [' . $fullControllerName . ', \'json\'])->name(\'' . $routeName . '.json\');');
        // $this->info('Route::get(\'' . $routeName . '/excel\', [' . $fullControllerName . ', \'excel\'])->name(\'' . $routeName . '.excel\');');
        // $this->info('Route::get(\'' . $routeName . '/import-excel-example\', [' . $fullControllerName . ', \'importExcelExample\'])->name(\'' . $routeName . '.import-excel-example\');');
        // $this->info('Route::post(\'' . $routeName . '/import-excel\', [' . $fullControllerName . ', \'importExcel\'])->name(\'' . $routeName . '.import-excel\');');
        // $this->info('Route::resource(\'' . $routeName . '\', ' . $fullControllerName . ');');

        return 0;
    }

    private function apiController()
    {

        $master  = app_path('Console/Commands/data/crud/apicontroller.php.dummy');
        $content = file_get_contents($master);

        // replace specific var
        $content = str_replace('TITLE', $this->json->title, $content);
        $content = str_replace('CONTROLLERNAME', $this->controllerName, $content);
        $content = str_replace('VARREPOSITORYNAME', $this->varRepoName, $content);
        $content = str_replace('REPOSITORYNAME', $this->repoName, $content);
        $content = str_replace('VARMODELNAME', $this->varModelName, $content);
        $content = str_replace('MODELNAME', $this->modelName, $content);
        $content = str_replace('REQUESTNAME', $this->requestName, $content);
        $content = str_replace('COLUMNS', $this->setColumnsWithTab(3), $content);
        $content = str_replace('FOLDERVIEW', $this->folderViewName, $content);

        // save to specific path
        $this->controllerApiPath = $filepath = app_path('Http/Controllers/Api/' . $this->controllerName . '.php');
        file_put_contents($filepath, $content);
    }

    private function apiRequest()
    {
        $path    = app_path('Console/Commands/data/crud/request.php.dummy');
        $content = file_get_contents($path);

        $content = str_replace('REQUESTNAME', $this->requestName, $content);
        $content = str_replace('UPDATEVALIDATIONS', $this->UPDATEVALIDATIONS, $content);
        $content = str_replace('STOREVALIDATIONS', $this->STOREVALIDATIONS, $content);
        $content = str_replace("namespace App\Http\Requests;", "namespace App\Http\Requests\Api;", $content);

        $folder = app_path('Http/Requests/Api');
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $this->requestApiPath = $filepath = $folder . '/' . $this->requestName . '.php';
        file_put_contents($filepath, $content);
    }

    private function permission()
    {
        $path    = app_path('Console/Commands/data/crud/permission.json.dummy');
        $content = file_get_contents($path);

        $content = str_replace('MODULENAME', $this->moduleName, $content);

        $folder = database_path('seeders/data/permission-modules');
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $this->permissionPath = $filepath = $folder . '/' . $this->routeName . '.json';
        file_put_contents($filepath, $content);
    }

    private function routing()
    {
        $path    = app_path('Console/Commands/data/crud/route.php.dummy');
        $content = file_get_contents($path);

        $content = str_replace('CONTROLLERNAME', $this->controllerName, $content);
        $content = str_replace('ROUTENAME', $this->routeName, $content);

        $filename = Str::singular($this->routeName);
        $this->routePath = $filepath = base_path('routes/modules/' . $filename . '.php');
        file_put_contents($filepath, $content);
    }
}
