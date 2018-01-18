<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

use Think\Controller;

class PictureController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function action()
    {
        $crop = array(
            '1' => array(
                'width' => 750,
                'height' => 352,
                'size' => 90
            ),
            '2' => array(
                'width' => 480,
                'height' => 480,
                'size' => 950
            )
        );
        $t = 1;
        if (!file_exists('./pic/')) {
            mkdir('./pic/');
        }
        if (count($_FILES['file']['name']) > 1) {
            for ($i = 0; $i <= count($_FILES['file']['name']); $i++) {
                foreach (I('post.crop') as $v) {
                    $file_name = $t . "." . substr(strrchr($_FILES['file']['name'][$i], '.'), 1);
                    copy($_FILES["file"]["tmp_name"][$i], './pic/' . $file_name);
                    $height = $crop[$v]['height'];
                    $width = $crop[$v]['width'];
                    Img('./pic/' . $file_name, $width, $height, 1);
                    $img = '../../../pic/' . $file_name;
                    echo "<img src=\"" . $img . "\" />";
                    $t++;
                }
            }
        } else {
            foreach (I('post.crop') as $v) {
                $file_name = $t . "." . substr(strrchr($_FILES['file']['name'][0], '.'), 1);
                copy($_FILES["file"]["tmp_name"][0], './pic/' . $file_name);
                $height = $crop[$v]['height'];
                $width = $crop[$v]['width'];
                Img('./pic/' . $file_name, $width, $height, 1);
                $img = '../../../pic/' . $file_name;
                echo "<img src=\"" . $img . "\" />";
                $t++;
            }
        }
    }

    public function test()
    {
        $this->display();
    }

    public function test_action()
    {
        $data = '';
        foreach ($_FILES['file']['tmp_name'] as $v){
            $content = file_get_contents($v);
            $data .=$content;
        }
        file_put_contents('./text.txt',$data);
    }
}