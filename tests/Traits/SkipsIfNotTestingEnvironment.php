<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Artisan;

trait SkipsIfNotTestingEnvironment
{
    protected function skipIfNotTestingEnvironment(): void
    {
        if (!app()->environment('testing')) {
            $this->markTestSkipped('O ambiente não é "testing".');
        }else{
            Artisan::call('optimize:clear');
        }
    }
}
