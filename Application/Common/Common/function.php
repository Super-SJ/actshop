<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/10
 * Time: 22:22
 */
function import_excel($file)
{
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    if ($type === 'xlsx') {
        $type = 'Excel2007';
    } else {
        $type = $type === 'csv' ? $type : 'Excel5';
    }
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    // 判断使用哪种格式
    $objReader = PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    // 取得总行数
    $highestRow = $sheet->getHighestRow();
    // 取得总列数
    $highestColumn = $sheet->getHighestColumn();
    //循环读取excel文件,读取一条,插入一条
    $data = array();
    //从第一行开始读取数据
    for ($j = 1; $j <= $highestRow; $j++) {
        //从A列读取数据
        for ($k = 'A'; $k <= $highestColumn; $k++) {
            // 读取单元格
            $data[$j][] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
        }
    }
    return $data;
}

Function Img($Image, $Dw = 450, $Dh = 450, $Type = 1)
{
    IF (!File_Exists($Image)) {
        Return False;
    }
    //如果需要生成缩略图,则将原图拷贝一下重新给$Image赋值
    IF ($Type != 1) {
        Copy($Image, Str_Replace(".", "_x.", $Image));
        $Image = Str_Replace(".", "_x.", $Image);
    }
    //取得文件的类型,根据不同的类型建立不同的对象
    $ImgInfo = GetImageSize($Image);
    Switch ($ImgInfo[2]) {
        Case 1:
            $Img = @ImageCreateFromGIF($Image);
            Break;
        Case 2:
            $Img = @ImageCreateFromJPEG($Image);
            Break;
        Case 3:
            $Img = @ImageCreateFromPNG($Image);
            Break;
    }
    //如果对象没有创建成功,则说明非图片文件
    IF (Empty($Img)) {
        //如果是生成缩略图的时候出错,则需要删掉已经复制的文件
        IF ($Type != 1) {
            Unlink($Image);
        }
        Return False;
    }
    //如果是执行调整尺寸操作则
    $w = ImagesX($Img);
    $h = ImagesY($Img);
    IF ($Type == 1) {
        $nImg = ImageCreateTrueColor($Dw, $Dh);   //新建一个真彩色画布
        ImageCopyReSampled($nImg, $Img, 0, 0, 0, 0, $Dw, $Dh, $w, $h);//重采样拷贝部分图像并调整大小
        ImageJpeg($nImg, $Image);     //以JPEG格式将图像输出到浏览器或文件
        Return True;
        //如果是执行生成缩略图操作则
    } Else {
        $w = ImagesX($Img);
        $h = ImagesY($Img);
        $width = $w;
        $height = $h;
        $nImg = ImageCreateTrueColor($Dw, $Dh);
        IF ($h / $w > $Dh / $Dw) { //高比较大
            $width = $Dw;
            $height = $h * $Dw / $w;
            $IntNH = $height - $Dh;
            ImageCopyReSampled($nImg, $Img, 0, -$IntNH / 1.8, 0, 0, $Dw, $height, $w, $h);
        } Else {   //宽比较大
            $height = $Dh;
            $width = $w * $Dh / $h;
            $IntNW = $width - $Dw;
            ImageCopyReSampled($nImg, $Img, -$IntNW / 1.8, 0, 0, 0, $width, $Dh, $w, $h);
        }
        ImageJpeg($nImg, $Image);
        Return True;
    }
}

function get_sign($parameter)
{
    $temp = $parameter;
    //验证密钥
    $secret_key = "3eba51d7554c88d488007ae4bb144f46a30695e5";
    $sign_str = "";
    //键值正排序
    ksort($temp);
    //生产字符串
    foreach ($temp as $key => $val) {
        $sign_str .= $key . $val;
    }
    //拼接上密钥
    $sign_str = $secret_key . $sign_str . $secret_key;
    //md5大写
    $sign_value = strtoupper(md5($sign_str));
    //添加进数组
    $parameter['sign'] = $sign_value;
    //返回数组
    return $parameter;

}

function httpGet($url)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    // 采用https方式调用
    if (stripos($url, "https://") !== FALSE) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    }
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}


function httpPost($url, $param, $headers = '')
{
    $curl = curl_init();
    if (stripos($url, "https://") !== FALSE) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    if (!empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($param)));
    }
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 4);
    curl_setopt($curl, CURLOPT_TIMEOUT, 4);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    $arrStatus = curl_getinfo($curl);
    curl_close($curl);

    if (intval($arrStatus["http_code"]) == 200) {
        return $res;
    } else {
        return false;
    }
}

function phone_check($phone)
{
    //正则表达式
    if (strlen($phone) == "11") {
        preg_match("/13{1}\d{9}|15\d{9}|17\d{9}|18\d{9}|19\d{9}/", $phone, $array);
        return $array;
    } else {
        return "长度必须是11位";
    }
}

function check_verify($code, $id = ""){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}
?>