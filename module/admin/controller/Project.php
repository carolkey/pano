<?php
namespace module\admin\controller;

use module\admin\model\Oss;

class Project extends ACL
{

    public function building()
    {
        return $this->render('building', $this->subparams);
    }

    public function tags()
    {
        return $this->render('tags', $this->subparams);
    }


    public function publish()
    {
        $projectList = \module\admin\model\Project::find()->asArray()->all();

        return $this->render('publish', $this->subparams + ['projectList' => $projectList]);
    }

    public function signature()
    {
        return Oss::signature('sourceimg/');
    }
}
