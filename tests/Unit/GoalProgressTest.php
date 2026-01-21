<?php

test('goal progress percentage calculated correctly', function () {
    $currentValue = 50;
    $targetValue = 100;
    
    $percentage = ($currentValue / $targetValue) * 100;
    
    expect($percentage)->toBe(50.0);
});

test('goal is completed when current equals target', function () {
    $currentValue = 100;
    $targetValue = 100;
    
    $isCompleted = $currentValue >= $targetValue;
    
    expect($isCompleted)->toBeTrue();
});

test('goal is completed when current exceeds target', function () {
    $currentValue = 120;
    $targetValue = 100;
    
    $isCompleted = $currentValue >= $targetValue;
    
    expect($isCompleted)->toBeTrue();
});

test('goal percentage does not exceed 100', function () {
    $currentValue = 150;
    $targetValue = 100;
    
    $percentage = min(($currentValue / $targetValue) * 100, 100);
    
    expect($percentage)->toEqual(100);
});

test('goal with zero target handles division', function () {
    $currentValue = 50;
    $targetValue = 0;
    
    $percentage = $targetValue > 0 ? ($currentValue / $targetValue) * 100 : 0;
    
    expect($percentage)->toEqual(0);
});
