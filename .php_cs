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
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
        'blank_line_after_opening_tag' => true,
        'method_chaining_indentation' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline_array' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align'
            ],
            'default' => null,
        ],
    ])
    ->setFinder($finder);
