<?php

class MainTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo "Congratulations! You are now flying with Phalcon CLI!";
        $this->console->handle([
            'task' => 'version',
            'action' => 'main',
            'params' => [],
        ]);
        $this->console->handle([
            'task' => 'version',
            'action' => 'main',
            'params' => [],
        ]);
        $this->console->handle([
            'task' => 'version',
            'action' => 'main',
            'params' => [],
        ]);
        $this->console->handle([
            'task' => 'version',
            'action' => 'main',
            'params' => [],
        ]);
        $this->console->handle([
            'task' => 'version',
            'action' => 'main',
            'params' => [],
        ]);
    }

}
