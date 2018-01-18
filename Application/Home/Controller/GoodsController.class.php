<?php
namespace Home\Controller;

class GoodsController extends BaseController
{
    public function index()
    {
        $model = M('Goods');
        $list = $model->select();
        $this->assign('list',$list);
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function edit(){
        $model = M('Goods');
        $detail = $model->where('id='.I('get.id'))->find();
        $this->assign('detail',$detail);
        $this->display();
    }

    public function create(){
        $param = array(
            'name'=>I('post.name'),
            'price'=>I('post.price'),
            'number'=>I('post.number'),
            'al_number'=>I('post.al_number'),
            'detail'=>I('post.detail'),
            'order'=>I('post.order'),
        );
        $model = M('Goods');
        $result = $model->add($param);
        if($result){
            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败');
        }
    }

    public function update(){
        $param = array(
            'name'=>I('post.name'),
            'price'=>I('post.price'),
            'number'=>I('post.number'),
            'al_number'=>I('post.al_number'),
            'detail'=>I('post.detail'),
            'order'=>I('post.order'),
        );
        $model = M('Goods');
        $result = $model->where('id='.I('post.id'))->save($param);
        if($result){
            $this->success('修改成功',U('index'));
        }else{
            $this->error('修改失败');
        }
    }

    public function delete(){
        $model = M('Goods');
        $result = $model->where('id='.I('get.id'))->delete();
        if($result){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
}