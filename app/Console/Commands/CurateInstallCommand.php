<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;

class CurateInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curate:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->installNodeDependencies();

        if ($this->confirm('Do you want to run the development server?', true)) {
            $this->output->write(sprintf("\033\143")); # Clear the console output
            $this->line("> php artisan serve\r\n"); # Display an informative message about the command
            # Show an alert indicating the installation link
            $this->alert('Please visit the the following link to start the installation: ' 
                . '<bg=black;fg=white>http://127.0.0.1:8000/install</>');

            # Run the `artisan serve` command
            Artisan::call(
                'serve',
                [
                    '--host' => '127.0.0.1',
                    '--port' => 8000
                ],
                $this->output
            );
        }

        /**
         * bg and fg basically mean background and foreground
         * @see https://symfony.com/doc/current/console/coloring.html
         */
        $this->alert('Please run `<bg=black;fg=white>php artisan serve</>`'
            . ' then visit the <bg=black;fg=white>/install</>` route to start the installation'
            . ' (e.g. <bg=black;fg=white>http://127.0.0.1:8000/install</>)');
    }

    /**
     * Install all of the node dependencies.
     *
     * @return void
     */
    protected function installNodeDependencies()
    {
        $this->info('Installing NPM dependencies...');
        $this->comment("[This may take a few minutes]\r\n");

        // We will first install the global node dependencies
        $this->npmInstall(base_path());

        // Then retrieve the modules list
        $modules = Module::all();

        // Finally iterate through the modules
        // and install node dependencies for each
        // of them.
        foreach ($modules as $module) {
            $name = $module->getName();
            $path = realpath($module->getPath());

            $this->npmInstall($path, "Installing node dependencies for module [{$name}]");
        }
    }

    /**
     * Run `npm install` in the given folder.
     *
     * @param string $folder
     *
     * @return void
     */
    protected function npmInstall(string $folder, string $message = null)
    {
        $this->info($message ?? 'Installing global node dependencies...');

        // Create a new process instance for the "npm install" command.
        $process = new Process(['npm', 'install']);
        // Set the current working directory to the root folder.
        $process->setWorkingDirectory($folder);
        // Set the timeout to 5 minutes in seconds
        $process->setTimeout(3600);

        $process->run(function ($type, $buffer) {
            if ($type != Process::ERR) {
                $this->info($buffer);
            } else {
                // Display NPM warning
                if (Str::contains($buffer, 'npm WARN')) {
                    $this->warn($buffer);
                } else {
                    // Display NPM error
                    $this->error($buffer);
                }
            }
        });
    }
}
