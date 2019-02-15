<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->notPath('bootstrap')
    ->notPath('storage')
    ->notPath('nova')
    ->notPath('.phpstorm.meta.php')
    ->notPath('_ide_helper.php')
    ->notPath('_ide_helper_model.php')
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
        'void_return' => true,
        'trailing_comma_in_multiline_array' => true,
    ])
    ->setFinder($finder);
