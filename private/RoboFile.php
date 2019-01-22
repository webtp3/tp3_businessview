<?php

if(!class_exists(\Cag\Robo\CagTasks::class)){
    if(!class_exists(\Composer\Autoload\ClassLoader::class))require_once ("../Build/vendor/autoload.php");
    //  require_once ("./build/robo/RoboFile.php");

}


/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Cag\Robo\CagTasks
{
    // define public methods as commands
    /**
     * @param string $deployerBin
     *
     * @return DeployTask
     */
    protected function taskDeployerDeployTask($deployerBin)
    {
        return $this->task(DeployTask::class, $deployerBin);
    }

    /**
     * @param string $deployerBin
     *
     * @return DeployTask
     */
    protected function taskDeployerTask($deployerBin)
    {
        return $this->task(DeployerTask::class, $deployerBin);
    }
}
