<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateTestCommand extends Command
{
    protected $signature = 'generate:test';

    protected $description = 'Command description';

    public function configure()
    {
        $this->setAliases(['g:t']);
        parent::configure();
    }

    public function handle(): void
    {
        $files = File::allFiles(base_path('app/Models'));
        collect($files)->each(function (\SplFileInfo $file) {
            $modelRelativePathname = str($file->getRelativePathname())->remove('.php');
            $path = $modelRelativePathname
                ->prepend(base_path('tests/Unit/'))
                ->append('Test.php')
                ->toString();

            File::ensureDirectoryExists(dirname($path));

        });
    }
}
