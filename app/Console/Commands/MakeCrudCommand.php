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
    protected $signature = 'make:crud';

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->ask('CRUD Filename? (check example in ' . app_path('Console/Commands/data/crud/files/student.json') . ') type like this [student]');
        if (!$filename) {
            $this->error("CRUD file required");
            return 0;
        }
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
        foreach ($this->json->columns as $column) {
            if ($column->type === 'ai')
                $STRUCTURE .= '$table->id();';
            else if ($column->type === 'timestamps')
                $STRUCTURE .= '$table->timestamps();';
            else if (in_array($column->type, ['date', 'tinyInteger', 'text'])) {
                $STRUCTURE .= '$table->' . $column->type . '(\'' . $column->name . '\');';
                // $FILLABLES .= "\t\t'" . $column->name . "',\n";
                $FILLABLES .= "'" . $column->name . "', ";
                $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => $faker->numberBetween(0,1000), // ganti method fakernya sesuai kebutuhan' . "\n\t\t\t\t";
                $label = $column->label ?? Str::title(str_replace('_', ' ', $column->name));
                $TH .= "\t\t<th class=\"text-center\">{{ __('" . $label . "') }}</th>\n";
                if (isset($column->options)) {
                    $TD .= "\t\t<td>" . '{{ \App\Models\\' . $modelName . '::TYPES[\'' . $column->name . '\'][$item->' . $column->name . "] }}</td>\n";
                } else
                    $TD .= "\t\t<td>" . '{{ $item->' . $column->name . " }}</td>\n";
            } else {
                $STRUCTURE .= '$table->string(\'' . $column->name . '\', ' . ($column->length ?? 191) . ');';
                // $FILLABLES .= "\t\t'" . $column->name . "',\n";
                $FILLABLES .= "'" . $column->name . "', ";
                $SEEDERCOLUMNS .= "'" . $column->name . '\'' . ' => Str::random(10),' . "\n\t\t\t\t";
                $label = $column->label ?? Str::title(str_replace('_', ' ', $column->name));
                $TH .= "\t\t<th class=\"text-center\">{{ __('" . $label . "') }}</th>\n";
                if (isset($column->options)) {
                    $TD .= "\t\t<td>" . '{{ \App\Models\\' . $modelName . '::TYPES[\'' . $column->name . '\'][$item->' . $column->name . "] }}</td>\n";
                } else
                    $TD .= "\t\t<td>" . '{{ $item->' . $column->name . " }}</td>\n";
            }
            $STRUCTURE .= "\n\t\t\t";

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
                switch ($column->form->type) {
                    case 'text':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'text', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'email':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input-email', ['required'=>true, 'type'=>'email', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'password':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input-password', ['required'=>true, 'type'=>'text', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'image':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'file', 'accept'=>'image/*', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'file':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'file', 'accept'=>'*', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'number':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'number', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "'), 'min'=>0])
                </div>\n\n";
                        break;
                    case 'time':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'time', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'colorpicker':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.colorpicker', ['required'=>true, 'type'=>'text', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'date':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'date', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'textarea':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.textarea', ['required'=>true, 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
                </div>\n\n";
                        break;
                    case 'select2':
                        $multiple = $column->form->multiple ?? false ? 'true' : 'false';
                        $options = json_encode($column->form->options ?? []);
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.select2', ['required'=>true, 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "'), 'options'=>" . $options . ", 'multiple'=>" . $multiple . "])
                </div>\n\n";
                        break;
                    case 'select':
                        $options = json_encode($column->form->options ?? []);
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.select', ['required'=>true, 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "'), 'options'=>" . $options . "])
                </div>\n\n";
                        break;
                    case 'radio':
                        $options = json_decode(json_encode($column->options), true);
                        $values = collect($options)->pluck('value');
                        $newOptions = [];
                        $values->each(function ($item) use (&$newOptions, $options) {
                            return $newOptions[(string)$item] = $options[$item]['label'];
                        });
                        // dd($newOptions);
                        // $newOptions
                        $options = json_encode($newOptions);
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.radio-toggle', ['required'=>true, 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "'), 'options'=>" . $options . "])
                </div>\n\n";
                        break;
                }
            }
        }

        $this->FILLABLES = $FILLABLES;

        $migrationContent = str_replace('STRUCTURE', $STRUCTURE, $migrationContent);
        $migrationFiles = File::files(database_path('migrations'));
        $migrationFiles = array_map(function ($item) {
            return substr(
                str_replace(database_path('migrations') . '/', '', $item->getPathname()),
                18
            );
        }, $migrationFiles);
        // dd($migrationFiles);
        // if (
        //     // !Str::contains(
        //     //     $migrationFiles[0]->getPathname(),
        //     //     '_create_' . $modelNameSnake . '_table'
        //     // )
        //     !in_array('create_' . $modelNameSnake . '_table.php', $migrationFiles)
        // ) {
        //     file_put_contents($migrationPath = database_path('migrations\\' . date('Y_m_d_His') . '_create_' . $modelNameSnake . '_table.php'), $migrationContent);
        // }
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
        $modelContent = str_replace('FILLABLES', $FILLABLES, $modelContent);
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
                'Console/Commands/data/crud/controller.php.dummy'
            )
        );
        $controllerFile = str_replace('TITLE', $this->json->title, $controllerFile);
        $controllerFile = str_replace('CONTROLLERNAME', $modelName . 'Controller', $controllerFile);
        $controllerFile = str_replace('VARREPOSITORYNAME', Str::camel($modelName) . 'Repository', $controllerFile);
        $controllerFile = str_replace('REPOSITORYNAME', $modelName . 'Repository', $controllerFile);
        $controllerFile = str_replace('VARMODELNAME', Str::camel($modelName), $controllerFile);
        $controllerFile = str_replace('MODELNAME', $modelName, $controllerFile);
        $controllerFile = str_replace('REQUESTNAME', $modelName . 'Request', $controllerFile);
        $controllerFile = str_replace('COLUMNS', $FILLABLES, $controllerFile);
        $controllerFile = str_replace('FOLDERVIEW', $folderViewName, $controllerFile);
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
        $viewIndexFile = file_get_contents(app_path('Console/Commands/data/crud/views/index.blade.php.dummy'));
        $viewIndexFile = str_replace('TITLE', $this->json->title, $viewIndexFile);
        $viewIndexFile = str_replace('ROUTE', $routeName, $viewIndexFile);
        $viewIndexFile = str_replace('ICON', $this->json->icon, $viewIndexFile);
        $viewIndexFile = str_replace('TH', $TH, $viewIndexFile);
        $viewIndexFile = str_replace('TD', $TD, $viewIndexFile);
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
        $viewExportExcelFile = str_replace('TITLE', $this->json->title, $viewExportExcelFile);
        $viewExportExcelFile = str_replace('ROUTE', $routeName, $viewExportExcelFile);
        $viewExportExcelFile = str_replace('ICON', $this->json->icon, $viewExportExcelFile);
        $viewExportExcelFile = str_replace('FORM', $FORM, $viewExportExcelFile);
        $viewExportExcelFile = str_replace('TH', $TH, $viewExportExcelFile);
        $viewExportExcelFile = str_replace('TD', $TD, $viewExportExcelFile);
        $viewExportExcelPath    = $folder . '/export-excel-example.blade.php';
        file_put_contents($viewExportExcelPath, $viewExportExcelFile);

        $exportExcelFile = file_get_contents(app_path('Console/Commands/data/crud/export.php.dummy'));
        $exportExcelFile = str_replace('FOLDERVIEW', $folderViewName, $exportExcelFile);
        $exportExcelFile = str_replace('MODELNAME', $modelName, $exportExcelFile);
        $exportExcelFile = str_replace('FILLABLES', $FILLABLES, $exportExcelFile);
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
        $seederPath = database_path('Seeders/' . $modelName . 'Seeder.php');
        file_put_contents($seederPath, $seederFile);

        if (isset($migrationPath))
            $this->info('Created migration file => ' . $migrationPath);
        $this->info('Created seeder file => ' . $seederPath);
        $this->info('Created model file => ' . $modelPath);
        $this->info('Created controller file => ' . $controllerPath);
        $this->info('Created repository file => ' . $repositoryPath);
        $this->info('Created request file => ' . $requestPath);
        $this->info('Created export excel file => ' . $exportExcelPath);
        $this->info('Created import excel file => ' . $importExcelPath);
        $this->info('Created view index file => ' . $viewIndexPath);
        $this->info('Created form index file => ' . $viewCreatePath);
        $this->info('Don\'t forget to run php artisan migrate');
        $this->info('copy this to your route file 👇');

        // for copy route
        $fullControllerName = '\App\Http\Controllers\\' . $controllerName . '::class';
        $this->info('Route::get(\'' . $routeName . '/pdf\', [' . $fullControllerName . ', \'pdf\'])->name(\'' . $routeName . '.pdf\');');
        $this->info('Route::get(\'' . $routeName . '/csv\', [' . $fullControllerName . ', \'csv\'])->name(\'' . $routeName . '.csv\');');
        $this->info('Route::get(\'' . $routeName . '/json\', [' . $fullControllerName . ', \'json\'])->name(\'' . $routeName . '.json\');');
        $this->info('Route::get(\'' . $routeName . '/excel\', [' . $fullControllerName . ', \'excel\'])->name(\'' . $routeName . '.excel\');');
        $this->info('Route::get(\'' . $routeName . '/import-excel-example\', [' . $fullControllerName . ', \'importExcelExample\'])->name(\'' . $routeName . '.import-excel-example\');');
        $this->info('Route::post(\'' . $routeName . '/import-excel\', [' . $fullControllerName . ', \'importExcel\'])->name(\'' . $routeName . '.import-excel\');');
        $this->info('Route::resource(\'' . $routeName . '\', ' . $fullControllerName . ');');

        $this->apiController();
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
        $content = str_replace('COLUMNS', $this->FILLABLES, $content);
        $content = str_replace('FOLDERVIEW', $this->folderViewName, $content);

        // save to specific path
        $filepath = app_path('Http/Controllers/Api/' . $this->controllerName . '.php');
        file_put_contents($filepath, $content);
    }
}
