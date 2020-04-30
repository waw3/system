<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Where the templates for the generators are stored...
    |--------------------------------------------------------------------------
    |
    */
    'model_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/model.txt'),

    'scaffold_model_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/scaffolding/model.txt'),

    'controller_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/controller.txt'),

    'scaffold_controller_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/scaffolding/controller.txt'),

    'migration_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/migration.txt'),

    'seed_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/seed.txt'),

    'view_template_path' => base_path('packages/way-generators/src/Way/Generators/Templates/view.txt'),


    /*
    |--------------------------------------------------------------------------
    | Where the generated files will be saved...
    |--------------------------------------------------------------------------
    |
    */
    'model_target_path'   => app_path(),

    'controller_target_path'   => app_path('Http/Controllers'),

    'migration_target_path'   => base_path('database/generated/migrations'),

    'seed_target_path'   => base_path('database/generated/seeds'),

    'view_target_path'   => base_path('resources/views')

];
