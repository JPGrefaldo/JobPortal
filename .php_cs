<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->notPath('bootstrap')
    ->notPath('storage')
    ->notPath('Nova')
    ->notPath('nova')
    ->notPath('.phpstorm.meta.php')
    ->notPath('_ide_helper.php')
    ->notPath('_ide_helper_model.php')
    ->notPath('config')
    ->notPath('public/index.php')
    ->notPath('app/Exceptions/Handler.php')
    ->notPath('app/Http/Kernel.php')
    ->notPath('app/Console/Kernel.php')
    ->notPath('tests/TestCase.php')
    ->notPath('tests/DuskTestCase.php')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php');

return PhpCsFixer\Config::create()
    ->setRules([
        'psr0' => false,
        '@PSR2' => true,
        'array_indentation' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'blank_line_after_opening_tag' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'method_chaining_indentation' => true,
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha'
        ],
        'single_blank_line_before_namespace' => true,
        'trailing_comma_in_multiline_array' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align'
            ],
            'default' => null,
        ],
    ])
    ->setLineEnding("\n")
    ->setFinder($finder);
