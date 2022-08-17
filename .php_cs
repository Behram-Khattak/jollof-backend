<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.15|configurator
 * you can change this configuration by importing this file.
 */

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setLineEnding("\r\n")
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_superfluous_phpdoc_tags' => false,
        'binary_operator_spaces' => ['align_double_arrow' => true],
        'braces' => ['allow_single_line_closure' => true],
        'class_definition' => ['single_line' => true],
        'increment_style' => ['style' => 'post'],
        'logical_operators' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'blank_line_before_statement' => ['statements' => ['return', 'throw']],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
    ])
    ->setCacheFile(__DIR__.'/storage/.php_cs.cache')
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude('app/Console')
        ->exclude('node_modules')
        ->exclude('app/Providers')
        ->exclude('app/Exceptions')
        ->exclude('app/Http/Middleware')
        ->exclude('resources/lang/en')
        ->exclude('vendor')
        ->exclude('config')
        ->exclude('bootstrap')
        ->exclude('storage')
        ->notPath('server.php')
        ->notPath('public/index.php')
        ->notPath('app/Http/Kernel.php')
        ->notPath('_ide_helper.php')
        ->notPath('artisan')
        ->in(__DIR__)
    )
;
