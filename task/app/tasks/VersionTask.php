<?php

class VersionTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {

        $data = \App\Models\ForumUser::findFirst('id = 11');
        var_dump($data->toArray());
        //$config = $this->getDI()->get('config');

        //echo $config['version'];
    }

}
