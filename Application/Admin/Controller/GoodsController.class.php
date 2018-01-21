<?php

namespace Admin\Controller;

class GoodsController extends BaseController
{
    private $status = array(
        '0' =>'上架',
        '1' =>'下架',
        '2' =>'删除'
    );
    public function index()
    {
        $model = M('Goods');
        $list = $model->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')->where(array('l_goods.status'=>array('neq',2),'l_goods_picture.type'=>0))->group('l_goods.id')->field('l_goods.*,l_goods_picture.url')->select();
        foreach ($list as &$v){
            $v['status'] = $this->status[$v['status']];
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
        $model = M('Goods');
        $detail = $model->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')->where('l_goods.id=' . I('get.id'))->field('l_goods.*,l_goods_picture.url,l_goods_picture.type')->select();
        foreach ($detail as $v){
            if($v['type']== 0){
                $picture_0[] = $v['url'];
            }elseif ($v['type'] == 1){
                $picture_1[] =$v['url'];
            }
        }
        $picture_value_0 = implode(',',$picture_0);
        $picture_value_1 = implode(',',$picture_1);
        $detail = array_merge($detail[0],array('picture_0'=>$picture_0),array('picture_1'=>$picture_1));
        $detail['picture_value_0'] = $picture_value_0;
        $detail['picture_value_1'] = $picture_value_1;
        $this->assign('detail', $detail);
        $this->display();
    }

    public function create()
    {
        $param = array(
            'name' => I('post.name'),
            'price' => I('post.price'),
            'number' => I('post.number'),
            'al_number' => I('post.al_number'),
            'detail' => I('post.detail'),
            'order' => I('post.order'),
        );
        $model = M('Goods');
        $result = $model->add($param);

        $photo_value1 = explode(',',trim(I('post.photo_value1'),','));
        foreach ($photo_value1 as $v){
            $arr_file[] = array('url'=>$v,'type' =>0 ,'goods_id'=>$result);
            copy('./Public/temp/'.$v,'./Public/images/'.$v);
            unlink('./Public/temp/'.$v);
        }
        $photo_value2 = explode(',',trim(I('post.photo_value2'),','));
        foreach ($photo_value2 as $v){
            $arr_file[] = array('url'=>$v,'type' =>1 ,'goods_id'=>$result);
            copy('./Public/temp/'.$v,'./Public/images/'.$v);
            unlink('./Public/temp/'.$v);
        }
        $photo_model = M('GoodsPicture');
        $photo_model->addAll($arr_file);
        if ($result) {
            $this->success('添加成功', U('index'));
        } else {
            $this->error('添加失败');
        }
    }

    public function update()
    {
        $param = array(
            'name' => I('post.name'),
            'price' => I('post.price'),
            'number' => I('post.number'),
            'al_number' => I('post.al_number'),
            'detail' => I('post.detail'),
            'order' => I('post.order'),
        );
        $model = M('Goods');
        $result = $model->where('id=' . I('post.id'))->save($param);
        //图片处理部分
        $photo_model = M('GoodsPicture');
        if(!empty(I('post.photo_value1'))){
            //先删除
            $photo_model->where(array('goods_id'=>I('post.id'),'type'=>0))->delete();
            $picture_value_0 = explode(',',I('post.picture_value_0'));
            foreach ($picture_value_0 as $v){
                unlink('./Public/images/'.$v);
            }
            //后添加
            $photo_value1 = explode(',',trim(I('post.photo_value1'),','));
            foreach ($photo_value1 as $v){
                $arr_file[] = array('url'=>$v,'type' =>0 ,'goods_id'=>I('post.id'));
                copy('./Public/temp/'.$v,'./Public/images/'.$v);
                unlink('./Public/temp/'.$v);
            }
        }
        if(!empty(I('post.photo_value2'))){
            //先删除
            $photo_model->where(array('goods_id'=>I('post.id'),'type'=>1))->delete();
            $picture_value_1 = explode(',',I('post.picture_value_1'));
            foreach ($picture_value_1 as $v){
                unlink('./Public/images/'.$v);
            }
            //后添加
            $photo_value2 = explode(',',trim(I('post.photo_value2'),','));
            foreach ($photo_value2 as $v){
                $arr_file[] = array('url'=>$v,'type' =>1 ,'goods_id'=>I('post.id'));
                copy('./Public/temp/'.$v,'./Public/images/'.$v);
                unlink('./Public/temp/'.$v);
            }
        }
        $photo_model->addAll($arr_file);

        if ($result !== false) {
            $this->success('修改成功', U('index'));
        } else {
            $this->error('修改失败');
        }
    }

    public function update_status()
    {
        $model = M('Goods');
        $result = $model->where('id=' . I('get.id'))->save(array('status'=>I('get.status')));
        if ($result!==false) {
            $this->success('操作成功', U('index'));
        } else {
            $this->error('操作失败');
        }
    }

    public function photo_upload()
    {
        $file_name = md5(time().mt_rand(1000000,9999999)) . "." . substr(strrchr($_FILES['file']['name'], '.'), 1);
        copy($_FILES["file"]["tmp_name"], './Public/temp/' . $file_name);
        $this->ajaxReturn(array('src'=>$file_name));
    }
}