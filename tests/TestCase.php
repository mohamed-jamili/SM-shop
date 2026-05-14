<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    protected string $compiledViewPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->compiledViewPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravel-testing-views-'.bin2hex(random_bytes(6));
        File::ensureDirectoryExists($this->compiledViewPath);

        config()->set('view.compiled', $this->compiledViewPath);
        config()->set('logging.default', 'errorlog');
    }

    protected function tearDown(): void
    {
        if (isset($this->compiledViewPath) && File::isDirectory($this->compiledViewPath)) {
            File::deleteDirectory($this->compiledViewPath);
        }

        parent::tearDown();
    }
}
