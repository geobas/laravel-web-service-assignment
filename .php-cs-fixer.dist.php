<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'single_space',
            '===' => 'align_single_space_minimal',
        ],
    ],
    'braces' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'only_if_meta'
        ],
    ],
    'ordered_imports' => [
        'sort_algorithm' => 'length',
    ],
    'phpdoc_to_comment' => [
        'ignored_tags' => [
            'todo',
        ],
    ],
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arrays',
        ],
    ],
    'visibility_required' => [
        'elements' => [
            'method',
            'property',
        ],
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'php_unit_method_casing' => [
        'case' => 'snake_case',
    ],
    'single_line_comment_style' => [
        'comment_types' => [
            'hash',
        ],
    ],
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
    'phpdoc_no_empty_return' => false,
    'phpdoc_add_missing_param_annotation' => false,
    'not_operator_with_successor_space' => true,
    'no_superfluous_phpdoc_tags' => false,
    'phpdoc_order' => false,
    'phpdoc_types_order' => false,
    'phpdoc_align' => false,
    'phpdoc_separation' => false,
    'single_trait_insert_per_statement' => false,
    'no_empty_comment' => false,
    'phpdoc_no_package' => false,
    'no_extra_blank_lines' => [
        'tokens' => [
            'default',
            'extra',
        ],
    ],
    'new_with_braces' => false,
];

$excludes = [
    'bootstrap',
    'public',
    'resources/lang',
    'storage',
    'vendor',
];

$finder = Finder::create()
    ->exclude($excludes)
    ->notName('*.xml')
    ->notName('*.yml')
    ->notPath('tests/Feature/ExampleTest.php')
    ->notPath('app/Providers/AuthServiceProvider.php')
    ->notPath('app/Models/User.php')
    ->in(__DIR__);

return (new Config)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setFinder($finder);
