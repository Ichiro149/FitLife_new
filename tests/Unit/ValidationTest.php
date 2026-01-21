<?php

test('username validation allows letters and numbers', function () {
    $username = 'JohnDoe123';
    
    $isValid = preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,14}$/', $username);
    
    expect($isValid)->toBe(1);
});

test('username must start with letter', function () {
    $username = '123John';
    
    $isValid = preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,14}$/', $username);
    
    expect($isValid)->toBe(0);
});

test('username minimum length is 5 characters', function () {
    $username = 'John';
    
    $isValid = preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,14}$/', $username);
    
    expect($isValid)->toBe(0);
});

test('username maximum length is 15 characters', function () {
    $username = 'JohnDoeVeryLongName';
    
    $isValid = preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,14}$/', $username);
    
    expect($isValid)->toBe(0);
});

test('username allows underscore', function () {
    $username = 'John_Doe';
    
    $isValid = preg_match('/^[a-zA-Z][a-zA-Z0-9_]{4,14}$/', $username);
    
    expect($isValid)->toBe(1);
});

test('email validation works correctly', function () {
    $email = 'test@example.com';
    
    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    
    expect($isValid)->toBeTrue();
});

test('invalid email rejected', function () {
    $email = 'not-an-email';
    
    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    
    expect($isValid)->toBeFalse();
});

test('password length validation', function () {
    $password = 'short';
    $minLength = 8;
    
    $isValid = strlen($password) >= $minLength;
    
    expect($isValid)->toBeFalse();
});

test('valid password meets length requirement', function () {
    $password = 'securepassword123';
    $minLength = 8;
    
    $isValid = strlen($password) >= $minLength;
    
    expect($isValid)->toBeTrue();
});
