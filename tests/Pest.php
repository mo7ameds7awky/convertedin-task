<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)->in('Unit', 'Feature');
uses(RefreshDatabase::class)
    ->in('Feature');
