<?php

namespace backend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\helpers\StringHelper;
use yii\validators\FileValidator;
use yii\helpers\Url;

/**
 * AttachmentController controller
 */
class HqAttachmentController extends BaseController
{
    public $bucket = 'hq-attach';

    public function init()
    {
    }

    public function dir_path($path) {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }

    /**
     * 附件列表
     */
    public function actionList()
    {
        $prefix = $this->request->get('prefix', '');

        $path = '/data/htdocs/release/backend/web/resource/hq_attachment';
        if(!empty($prefix)){
            $path = $path.$prefix;
        }
        $path = self::dir_path($path);
        $files = glob($path . '*');
        $data_ox = [];
        $data=[];
        //'type'=>1,//1、文件夹；2、文件
        //admin.koudaikj.com/admin_resource/hfd_attachment/2.jpg
        foreach($files as $item){
            if(is_file($item)){
                ///data/htdocs/release/backend/web/resource/hq_attachment//active/2016-08-17/active_1471423558.jpg
               // var_dump($item);exit;
                $url = "http://121.40.140.36/backend/web/resource/hq_attachment";
                $source_url = "/backend/web/resource/hq_attachment";
                $file_box = explode("/",$item);
                $file_box = $file_box[count($file_box)-1];
                $show = explode("hq_attachment",$item);
                $show = $show[count($show)-1];
                $data[]=[
                    'type'=>2,
                    'file_name'=>$file_box,
                    'show'=>$source_url.$show,
                    'size'=>sprintf("%0.3f",filesize($item)/1000)."KB",
                    'address'=>$url.$show,
                    'created_at'=>date('Y-m-d H:i:s',filemtime($item)),
                    'operator'=>'删除'


                ];
            }else{
                $file_box = explode("/",$item);
                $file_box = $file_box[count($file_box)-1];
                $file_box = $prefix."/".$file_box;
                $data_ox[]=[
                    'type'=>1,
                    'file_name'=>$file_box."/",
                    'show'=>'文件夹',
                    'size'=>'-',
                    'address'=>'-',
                    'created_at'=>'-',
                    'operator'=>'-',
                    'prefix'=>$file_box
                ];
            }
        }

        return $this->render('list', [
            'contents' => $data,
            'prefixes' => $data_ox,
        ]);
    }

    /**
     * 添加附件
     */
    public function actionAdd($defaultType = 'financial'){
        if ($this->request->getIsPost()) {
            $type = $this->request->post('type', '');
            if(empty($type)||(!in_array($type,['active','route']))){
                return $this->redirectMessage('请选择业务类型', self::MSG_ERROR);
            }

            $file = UploadedFile::getInstanceByName('attach');
            $fileExtension = $file->extension;
            $validator = new FileValidator();
            $xlsExtensions = ['xls','xlsx','csv'];
            $imgExtensions = ['jpeg','jpg', 'png', 'gif'];
            $validator->extensions = array_merge($imgExtensions, $xlsExtensions);
            if(!in_array($fileExtension, $xlsExtensions)){
                $validator->maxSize = 1024 * 1024;
            }
            $validator->checkExtensionByMimeType = false;
            $error = '';
            if (!$validator->validate($file, $error)) {
                return $this->redirectMessage('文件不符合要求：' . $error, self::MSG_ERROR);
            }
            if(in_array($type, ['asset_plat_order']) && !in_array($fileExtension, $xlsExtensions)){
                return $this->redirectMessage('文件不符合要求：必须为excel/csv文件', self::MSG_ERROR);
            }
            if(!in_array($type, ['asset_plat_order']) && !in_array($fileExtension, $imgExtensions)){
                return $this->redirectMessage('文件不符合要求：必须为图片文件', self::MSG_ERROR);
            }
            $path = Yii::getAlias('@backend/web/resource/hq_attachment') ;

            $path = $path."/".$type."/";
            $time = date('Y-m-d',time());
            $path = $path.$time."/";
            if(!is_dir($path)) {
                mkdir($path, 0777, true);
            }

          if(isset($file->error)&&(0 == $file->error)&&!empty($file->name)&&!empty($file->tempName)){
                $file_extend = explode(".",$file->name);
                $file_extend = $file_extend[count($file_extend)-1];
                $file_name = $type."_".time().".".$file_extend;
                $ret = move_uploaded_file($file->tempName, $path.$file_name);
                if($ret){
                    $url = "http://121.40.140.36/backend/web/resource/hq_attachment";
                    $file_url = $url."/".$type."/".$time."/".$file_name;
                    return $this->redirectMessage('上传成功，文件地址：' . $file_url, self::MSG_SUCCESS);
                }else{
                    return $this->redirectMessage('上传文件出错', self::MSG_ERROR);
                }
            }else{
                return $this->redirectMessage('上传文件出错', self::MSG_ERROR);
            }



        }
        return $this->render('add', [
            'defaultType' => $defaultType
        ]);
    }

    /**
     * 删除附件
     */
    public function actionDelete($key)
    {
        $path = "/data/htdocs/release/backend/web/";
        $key = explode("121.40.140.36/backend/web/",$key);
        $key = $key[count($key)-1];
        $path = $path.$key;
        chmod($path,0755);
        $ret =  @unlink($path);
        if($ret){
            return $this->redirectMessage('成功', self::MSG_SUCCESS);
        }else{
            return $this->redirectMessage('删除失败', self::MSG_ERROR);
        }
    }
}