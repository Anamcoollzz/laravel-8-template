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
        $filepath = app_path('Console\\Commands\\data\\crud\\files\\mahasiswa.json');
        $this->json = json_decode(file_get_contents($filepath));

        $modelName = $this->json->model;
        $modelNameSnake = Str::snake($modelName);
        $migrationExample = file_get_contents(
            app_path(
                'Console\\Commands\\data\\crud\\migration.php.dummy'
            )
        );
        $TABLENAME = $modelNameSnake . 's';
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
        foreach ($this->json->columns as $column) {
            if ($column->type === 'ai')
                $STRUCTURE .= '$table->id();';
            else if ($column->type === 'timestamps')
                $STRUCTURE .= '$table->timestamps();';
            else if (in_array($column->type, ['date', 'tinyInteger', 'text'])) {
                $STRUCTURE .= '$table->' . $column->type . '(\'' . $column->name . '\');';
                // $FILLABLES .= "\t\t'" . $column->name . "',\n";
                $FILLABLES .= "'" . $column->name . "', ";
                $label = Str::title(str_replace('_', ' ', $column->name));
                $TH .= "\t\t\t\t\t\t<th class=\"text-center\">{{ __('" . $label . "') }}</th>\n";
                if (isset($column->options)) {
                    $TD .= "\t\t\t\t\t\t<td>" . '{{ \App\Models\\' . $modelName . '::TYPES[\'' . $column->name . '\'][$item->' . $column->name . "] }}</td>\n";
                } else
                    $TD .= "\t\t\t\t\t\t<td>" . '{{ $item->' . $column->name . " }}</td>\n";
            } else {
                $STRUCTURE .= '$table->string(\'' . $column->name . '\', ' . ($column->length ?? 191) . ');';
                // $FILLABLES .= "\t\t'" . $column->name . "',\n";
                $FILLABLES .= "'" . $column->name . "', ";
                $label = Str::title(str_replace('_', ' ', $column->name));
                $TH .= "\t\t\t\t\t\t<th class=\"text-center\">{{ __('" . $label . "') }}</th>\n";
                if (isset($column->options)) {
                    $TD .= "\t\t\t\t\t\t<td>" . '{{ \App\Models\\' . $modelName . '::TYPES[\'' . $column->name . '\'][$item->' . $column->name . "] }}</td>\n";
                } else
                    $TD .= "\t\t\t\t\t\t<td>" . '{{ $item->' . $column->name . " }}</td>\n";
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
                $label = Str::title(str_replace('_', ' ', $column->name));
                switch ($column->form->type) {
                    case 'text':
                        $FORM .= "\t\t\t\t<div class=\"col-md-6\">
                  @include('includes.form.input', ['required'=>true, 'type'=>'text', 'id'=>'$column->name', 'name'=>'$column->name', 'label'=>__('" . $label . "')])
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
        $migrationContent = str_replace('STRUCTURE', $STRUCTURE, $migrationContent);
        file_put_contents($migrationPath = database_path('migrations\\' . date('Y_m_d_His') . '_create_' . $modelNameSnake . '_table.php'), $migrationContent);

        // CREATE MODEL
        $modelExample = file_get_contents(
            app_path(
                'Console\\Commands\\data\\crud\\model.php.dummy'
            )
        );
        $modelContent = str_replace('TABLENAME', $TABLENAME, $modelExample);
        $modelContent = str_replace('FILLABLES', $FILLABLES, $modelContent);
        $modelContent = str_replace('MODELNAME', $modelName, $modelContent);
        $modelContent = str_replace('TYPESVALUE', '[' . $TYPESVALUE . "\n\t]", $modelContent);
        file_put_contents($modelPath = app_path('Models\\' . $modelName . '.php'), $modelContent);

        // CREATE REPOSITORY
        $repositoryFile = file_get_contents(app_path('Console/Commands/data/NameRepository.php'));
        $repositoryFile = str_replace('ModelName', $modelName, $repositoryFile);
        $repositoryFile = str_replace('NameRepository', $modelName . 'Repository', $repositoryFile);
        $filepath = app_path('Repositories\\' . $modelName . 'Repository.php');
        file_put_contents($repositoryPath = $filepath, $repositoryFile);

        // CREATE CONTROLLER
        $controllerFile = file_get_contents(
            app_path(
                'Console\\Commands\\data\\crud\\controller.php.dummy'
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
        $controllerFile = str_replace('FOLDERVIEW', Str::slug($modelName), $controllerFile);
        $filepath = app_path('Http\\Controllers\\' . $modelName . 'Controller.php');
        file_put_contents($controllerPath = $filepath, $controllerFile);

        // CREATE REQUEST
        $requestFile = file_get_contents(
            app_path(
                'Console\\Commands\\data\\crud\\request.php.dummy'
            )
        );
        $requestFile = str_replace('REQUESTNAME', $modelName . 'Request', $requestFile);
        $requestFile = str_replace('UPDATEVALIDATIONS', $UPDATEVALIDATIONS, $requestFile);
        $requestFile = str_replace('STOREVALIDATIONS', $STOREVALIDATIONS, $requestFile);
        $filepath    = app_path('Http\\Requests\\' . $modelName . 'Request.php');
        file_put_contents($requestPath = $filepath, $requestFile);

        // CREATE VIEWS
        $viewIndexFile = file_get_contents(app_path('Console\\Commands\\data\\crud\\views\\index.blade.php.dummy'));
        $viewIndexFile = str_replace('TITLE', $this->json->title, $viewIndexFile);
        $viewIndexFile = str_replace('ROUTE', Str::slug($modelName) . 's', $viewIndexFile);
        $viewIndexFile = str_replace('ICON', $this->json->icon, $viewIndexFile);
        $viewIndexFile = str_replace('TH', $TH, $viewIndexFile);
        $viewIndexFile = str_replace('TD', $TD, $viewIndexFile);
        $folder = base_path('resources\\views\\') . Str::slug($modelName);
        // dd($folder);
        if (!file_exists($folder)) {
            File::makeDirectory($folder);
            // mkdir($folder);
        }
        $filepath    = $folder . '\\index.blade.php';
        file_put_contents($viewIndexPath = $filepath, $viewIndexFile);

        $viewFormFile = file_get_contents(app_path('Console\\Commands\\data\\crud\\views\\form.blade.php.dummy'));
        $viewFormFile = str_replace('TITLE', $this->json->title, $viewFormFile);
        $viewFormFile = str_replace('ROUTE', Str::slug($modelName) . 's', $viewFormFile);
        $viewFormFile = str_replace('ICON', $this->json->icon, $viewFormFile);
        $viewFormFile = str_replace('FORM', $FORM, $viewFormFile);
        $filepath    = $folder . '\\form.blade.php';
        file_put_contents($viewCreatePath = $filepath, $viewFormFile);

        $this->info('Created migration file => ' . $migrationPath);
        $this->info('Created model file => ' . $modelPath);
        $this->info('Created controller file => ' . $controllerPath);
        $this->info('Created repository file => ' . $repositoryPath);
        $this->info('Created request file => ' . $requestPath);
        $this->info('Created view index file => ' . $viewIndexPath);
        $this->info('Created form index file => ' . $viewCreatePath);
        $this->info('Don\'t forget to run php artisan migrate');
        $this->info('copy this to your route file => Route::resource(\'' . Str::slug($modelName) . 's\', \App\Http\Controllers\\' . $modelName . 'Controller::class);');

        return 0;
    }
}
