<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'binary_operator_spaces' => [
        'align_double_arrow' => false,
        'align_equals' => false,
    ],
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'single_space',
            // '=' => 'single_space',
            '===' => 'align_single_space_minimal',
        ],
    ],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => true,
    'braces' => true,
    'cast_spaces' => true,
    'class_definition' => true,
    'constant_case' => [
        'case' => 'lower'
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
            'property' => 'one',
            'trait_import' => 'none',
        ],
    ],
    'declare_equal_normalize' => true,
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'general_phpdoc_tag_rename' => true,
    'heredoc_to_nowdoc' => true,
    'include' => true,
    'lowercase_cast' => true,
    'lowercase_keywords' => true,
    'method_argument_space' => true,
    'multiline_whitespace_before_semicolons' => true,
    'native_function_casing' => true,
    'no_alias_functions' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_closing_tag' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_extra_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_mixed_echo_print' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_trailing_whitespace' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unreachable_default_argument_value' => true,
    'no_unused_imports' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => false,
    'object_operator_without_whitespace' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => [
        'sort_algorithm' => 'length',
    ],
    'phpdoc_indent' => true,
    'phpdoc_inline_tag_normalizer' => true,
    'phpdoc_no_access' => false,
    'phpdoc_no_package' => false,
    'phpdoc_no_useless_inheritdoc' => false,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_tag_type' => true,
    'phpdoc_to_comment' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'phpdoc_var_without_name' => true,
    'psr_autoloading' => true,
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'simplified_null_return' => true,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'single_class_element_per_statement' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_line_comment_style' => [
        'comment_types' => [
            'hash'
        ],
    ],
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arrays',
        ],
    ],
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => [
        'elements' => [
            'method',
            'property',
        ],
    ],
    'whitespace_after_comma_in_array' => true,
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
