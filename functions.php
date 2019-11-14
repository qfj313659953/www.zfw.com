<?php
//静态资源路径
function staticAdminPath()
{
    return '/admin/';
}

/**
 * 数组的合并，并加上html标识前缀
 * @param array $data
 * @param int $pid
 * @param string $html
 * @param int $level
 * @return array
 */
function treeLevel(array $data, int $pid = 0, string $html = '--', int $level = 0) {
    static $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['html'] = str_repeat($html, $level * 2);
            $val['level'] = $level + 1;
            $arr[] = $val;
            treeLevel($data, $val['id'], $html, $val['level']);
        }
    }
    return $arr;
}

/**
 * @param  array $data
 * @return 无限级树状结构
 */
function get_tree_list( array $data)
{
    //将每条数据的id值作为下标
    $tree = [];
    foreach($data as $v){
        $v['son'] = [];
        $tree[$v['id']] = $v;
    }

    //获取分类树
    foreach($tree as $k=>$v){
        $tree[$v['pid']]['son'][] = &$tree[$v['id']];
    }
    return isset($tree[0]['son'])?$tree[0]['son']:[];

}
