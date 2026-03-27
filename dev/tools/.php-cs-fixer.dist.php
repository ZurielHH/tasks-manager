<?php

declare(strict_types=1);

use PhpCsFixer\{Config, Finder};

$finder = new Finder()
    ->in([
        dirname(__DIR__, 2) . '/src',
        dirname(__DIR__, 2) . '/tests',
    ])
    ->exclude([
        'vendor'
    ])
    ->name('*.php');

return new Config()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP84Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'trim_array_spaces' => true,
        'no_whitespace_before_comma_in_array' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => null]
        ],
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'try', 'throw']
        ],
        'blank_line_after_namespace' => true,
        'cast_spaces' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'none',
                'trait_import' => 'none'
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'strict_param' => true,
        'function_typehint_space' => true,
        'braces' => [
            'allow_single_line_closure' => false,
            'position_after_functions_and_oop_constructs' => 'next',
            'position_after_control_structures' => 'same',
            'position_after_anonymous_constructs' => 'same',
        ],
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile(dirname(__DIR__, 2) . '/.php-cs-fixer.cache')
;