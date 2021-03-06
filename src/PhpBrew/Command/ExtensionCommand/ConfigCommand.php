<?php
namespace PhpBrew\Command\ExtensionCommand;
use CLIFramework\Command;
use PhpBrew\Extension;
use PhpBrew\Utils;
use PhpBrew\Extension\ExtensionFactory;
use PhpBrew\Extension\ExtensionManager;
use PhpBrew\Command\ExtensionCommand\BaseCommand;


class ConfigCommand extends BaseCommand
{
    public function brief()
    {
        return 'phpbrew ext config [extension name]';
    }

    public function execute($extensionName)
    {
        $ext = ExtensionFactory::lookup($extensionName);
        if (!$ext) {
            return $this->error("Extension $extensionName not found.");
        }
        $file = $ext->getConfigFilePath();
        $this->logger->info("Looking for {$file} file...");
        if(! file_exists($file)) {
            $file .= '.disabled'; // try with ini.disabled file
            $this->logger->info("Looking for {$file} file...");
            if(! file_exists($file)) {
                $this->logger->warn("Sorry, I can't find the ini file for the requested extension: \"{$extname}\".");
                return;
            }
        }
        Utils::editor($file);
    }
}
