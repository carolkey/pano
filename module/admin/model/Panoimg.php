<?php
namespace module\admin\model;

use lying\db\ActiveRecord;

class Panoimg extends ActiveRecord
{
    /**
     * 分页获取数据
     * @param integer $lenght 每页显示的条数
     * @param integer $page 显示第几页
     * @return array 返回一个数组[$curr, $pages, $data]
     */
    public static function findPage($lenght = 20, $page = 1)
    {
        ($lenght = abs((int)$lenght)) || ($lenght = 1);
        ($page = abs((int)$page)) || ($page = 1);

        $countLine = self::find()->select(['count(id)'])->column();
        ($countPage = ceil($countLine / $lenght)) || ($countPage = 1);

        $offset = (($page > $countPage ? $countPage : $page) - 1) * $lenght;

        $data = self::find()
            ->orderBy(['id'=>SORT_DESC])
            ->limit($offset, $lenght)
            ->asArray()
            ->all();

        return [$page, $countPage, $data];
    }
}
