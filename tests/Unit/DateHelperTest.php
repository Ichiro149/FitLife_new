<?php

test('date formatting works correctly', function () {
    $date = '2026-01-21';
    
    $formatted = date('F j, Y', strtotime($date));
    
    expect($formatted)->toBe('January 21, 2026');
});

test('time difference in days calculated', function () {
    $startDate = '2026-01-01';
    $endDate = '2026-01-21';
    
    $diff = (strtotime($endDate) - strtotime($startDate)) / 86400;
    
    expect($diff)->toBe(20);
});

test('week number calculated correctly', function () {
    $date = '2026-01-21';
    
    $weekNumber = (int) date('W', strtotime($date));
    
    expect($weekNumber)->toBe(4);
});

test('days remaining in month calculated', function () {
    $date = '2026-01-21';
    $timestamp = strtotime($date);
    
    $daysInMonth = (int) date('t', $timestamp);
    $currentDay = (int) date('j', $timestamp);
    $daysRemaining = $daysInMonth - $currentDay;
    
    expect($daysRemaining)->toBe(10);
});

test('is today check works', function () {
    $today = date('Y-m-d');
    $checkDate = date('Y-m-d');
    
    $isToday = $today === $checkDate;
    
    expect($isToday)->toBeTrue();
});

test('date is in past', function () {
    $pastDate = '2025-01-01';
    $today = '2026-01-21';
    
    $isPast = strtotime($pastDate) < strtotime($today);
    
    expect($isPast)->toBeTrue();
});

test('date is in future', function () {
    $futureDate = '2027-01-01';
    $today = '2026-01-21';
    
    $isFuture = strtotime($futureDate) > strtotime($today);
    
    expect($isFuture)->toBeTrue();
});
