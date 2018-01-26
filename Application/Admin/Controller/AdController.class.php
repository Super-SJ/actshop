<?php

namespace Admin\Controller;

class AdController extends BaseController
{
    private $type = array(
        '0' =>'广告首页轮播',
    );
    public function index()
    {
        $model = M('AdPicture');
        $list = $model->select();
        foreach ($list as &$v){
            $v['type'] = $this->type[$v['type']];
        }
        $this->assign('list', $list);
        $this->display();
    }

    public function add()
    {
        $this->display();
    }

    public function edit()
    {
        $model = M('AdPicture');
        $detail = $model->where('id=' . I('get.id'))->find();
        $this->assign('detail', $detail);
        $this->display();
    }

    public function create()
    {
        $photo_value1 = trim(I('post.photo_value1'),',');
        rename('./Public/temp/'.$photo_value1,'./Public/images/'.$photo_value1);
        $param = array(
            'type' => I('post.type'),
            'url' => $photo_value1,
            'href' => I('post.href'),
            'order' => I('post.order')
        );
        $model = M('AdPicture');
        $result = $model->add($param);
        if ($result) {
            $this->success('添加成功', U('index'));
        } else {
            $this->error('添加失败');
        }
    }

    public function update()
    {
        $model = M('AdPicture');
        $param = array(
            'type' => I('post.type'),
            'href' => I('post.href'),
            'order' => I('post.order')
        );
        if(!empty(I('post.photo_value1'))){
            //先删除
            $picture_value_0 = I('post.picture_value_0');
            //后添加
            $photo_value1 = trim(I('post.photo_value1'),',');
            rename('./Public/temp/'.$photo_value1,'./Public/images/'.$photo_value1);
            $param['url'] = $photo_value1;
        }
        $result = $model->where('id=' . I('post.id'))->save($param);
        if ($result !== false) {
            $this->success('修改成功', U('index'));
        } else {
            $this->error('修改失败');
        }
    }

    public function delete()
    {
        $model = M('AdPicture');
        $detail = $model->where('id=' . I('get.id'))->find();
        $result = $model->where('id=' . I('get.id'))->delete();
        if ($result!==false) {
            $this->success('操作成功', U('index'));
        } else {
            $this->error('操作失败');
        }
    }
}