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
        $detail = $model
            ->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')
            ->where('l_goods.id=' . I('get.id'))->field('l_goods.*,l_goods_picture.url,l_goods_picture.type')->select();
        //规格部分
        $arr_spe = M('GoodsSpe')->where('goods_id='.I('get.id'))->order(array('value'))->select();
        foreach ($arr_spe as $v){
            if($v['type'] == 0){
                $spe_value_1[] = $v['value'];
            }else{
                $spe_value_2[] = $v['value'];
            }
        }
        $spe_value_1 = implode(',',$spe_value_1);
        $spe_value_2 = implode(',',$spe_value_2);
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
        $detail['spe_value_1'] = $spe_value_1;
        $detail['spe_value_2'] = $spe_value_2;
        //评价部分
        $arr_evalute = M('GoodsEvaluate')->where('goods_id='.I('get.id'))->order(array('id'))->select();
        $detail['evalute'] = $arr_evalute;
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
            'support' => I('post.support'),
        );
        $model = M('Goods');
        $result = $model->add($param);
        //图片开始
        $photo_value1 = explode(',',trim(I('post.photo_value1'),','));
        foreach ($photo_value1 as $v){
            $arr_file[] = array('url'=>$v,'type' =>0 ,'goods_id'=>$result);
            rename('./Public/temp/'.$v,'./Public/images/'.$v);
        }
        $photo_value2 = explode(',',trim(I('post.photo_value2'),','));
        foreach ($photo_value2 as $v){
            $arr_file[] = array('url'=>$v,'type' =>1 ,'goods_id'=>$result);
            rename('./Public/temp/'.$v,'./Public/images/'.$v);
        }
        $photo_model = M('GoodsPicture');
        $photo_model->addAll($arr_file);
        //规格开始
        if(!empty(I('post.spe_value_1'))){
            $spe_value_1 = explode(',',I('post.spe_value_1'));
            foreach ($spe_value_1 as $v){
                $arr_spe[] = array(
                    'type'=>0,
                    'value'=>$v,
                    'goods_id'=>$result
                );
            }
        }
        if(!empty(I('post.spe_value_2'))){
            $spe_value_1 = explode(',',I('post.spe_value_2'));
            foreach ($spe_value_1 as $v){
                $arr_spe[] = array(
                    'type'=>1,
                    'value'=>$v,
                    'goods_id'=>$result
                );
            }
        }
        if(!empty($arr_spe)){
            M('GoodsSpe')->addAll($arr_spe);
        }
        //评价开始
        $evaluate_user = I('post.evaluate_user');
        $evaluate_value = I('post.evaluate_value');
        for ($i=0;$i<count($evaluate_user);$i++){
            $evalute_data[] = array(
                'user'=>$evaluate_user[$i],
                'content'=>$evaluate_value[$i],
                'goods_id'=>$result
            );
        }
        M('GoodsEvaluate')->addAll($evalute_data);
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
            'support' => I('post.support'),
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
                rename('./Public/temp/'.$v,'./Public/images/'.$v);
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
                rename('./Public/temp/'.$v,'./Public/images/'.$v);
            }
        }
        if(!empty($arr_file)){
            $photo_model->addAll($arr_file);
        }

        //规格开始
        $spe_model = M('GoodsSpe');
        $spe_model->where(array('goods_id'=>I('post.id')))->delete();
        if(!empty(I('post.spe_value_1'))){
            $spe_value_1 = explode(',',I('post.spe_value_1'));
            foreach ($spe_value_1 as $v){
                $arr_spe[] = array(
                    'type'=>0,
                    'value'=>$v,
                    'goods_id'=>I('post.id')
                );
            }
        }
        if(!empty(I('post.spe_value_2'))){
            $spe_value_1 = explode(',',I('post.spe_value_2'));
            foreach ($spe_value_1 as $v){
                $arr_spe[] = array(
                    'type'=>1,
                    'value'=>$v,
                    'goods_id'=>I('post.id')
                );
            }
        }
        if(!empty($arr_spe)){
            $spe_model->addAll($arr_spe);
        }
        //评价开始
        $eva_model = M('GoodsEvaluate');
        $eva_model->where(array('goods_id'=>I('post.id')))->delete();
        $evaluate_user = I('post.evaluate_user');
        $evaluate_value = I('post.evaluate_value');
        for ($i=0;$i<count($evaluate_user);$i++){
            $evalute_data[] = array(
                'user'=>$evaluate_user[$i],
                'content'=>$evaluate_value[$i],
                'goods_id'=>I('post.id')
            );
        }
        $eva_model->addAll($evalute_data);
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
        if(I('get.status') == 2){
            $photo_model = M('GoodsPicture');
            $list = $photo_model->where('goods_id='.I('get.id'))->select();
            foreach ($list as $v){
                unlink('./Public/images/'.$v['url']);
            }
            $photo_model->where('goods_id='.I('get.id'))->delete();
            M('GoodsSpe')->where('goods_id='.I('get.id'))->delete();
        }
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