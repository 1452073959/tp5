<?php
namespace app\index\controller;
use app\extend\my\Tes;
use app\index\common\Te;
use my\Test;
use my\Tool;
use think\Db;
use think\facade\Config;
use think\Controller;
use think\facade\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Index extends Controller
{
    public function index()
    {



        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function config()
    {
        //config调用
        //        dump(Config::get('app.'));
      dump(config('app.'))  ;
    }

    public function cl()
    {
//        类测试
        $a=New Test();
//        echo $a->sayHello(1231,1123);die;
//        //
//        $A=new Tes();
//        echo $A->no();
            //https://www.kancloud.cn/manual/thinkphp5_1/content/Facade.md
//        $tes=new Te();
//        echo $tes->hello('你好啊.这是个测试',66666);
//        * 导出excel表
//    * $data：要导出excel表的数据，接受一个二维数组
//    * $name：excel表的表名
//    * $head：excel表的表头，接受一个一维数组
//    * $key：$data中对应表头的键的数组，接受一个一维数组
//    * 备注：此函数缺点是，表头（对应列数）不能超过26；
//    *循环不够灵活，一个单元格中不方便存放两个数据库字段的值

        $a=new Tool();


//        dump($data1);die;
//        $head=['1','2','3'];
//        $key=['1'=>'amcode','2'=>'fine','3'=>'name'];

//         $a->outdata($data= $data1= Db::table('fdz_basis_materials')->select(),$name='朱晨晨',$head=$head,$key=$key) ;


        /**
         * 导出Excel
         * @param  object $spreadsheet  数据
         * @param  string $format       格式:excel2003 = xls, excel2007 = xlsx
         * @param  string $savename     保存的文件名
         * @return filedownload         浏览器下载
         */
        $spreadsheet = new Spreadsheet();
        $data= $data1= Db::table('fdz_basis_materials')->select();
        // Add title
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '用户')
            ->setCellValue('C1', '详情')
            ->setCellValue('D1', '结果')
            ->setCellValue('E1', '时间')
            ->setCellValue('F1', 'IP');

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('登陆日志');

        $i = 2;
        foreach ($data as $rs) {
            // Add data
            $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$i, $rs['id'])
                ->setCellValue('B'.$i, $rs['amcode'])
                ->setCellValue('C'.$i, $rs['fine'])
                ->setCellValue('D'.$i, $rs['brank'] ? '成功' : '失败')
                ->setCellValue('E'.$i,$rs['time'])
                ->setCellValue('F'.$i, $rs['place']);
            $i++;
        }
        //Set width
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(15);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(15);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(60);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(15);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(20);

        // Set alignment
        $spreadsheet->getActiveSheet()->getStyle('A1:F'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C2:C'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        return  exportExcel($spreadsheet, 'xls', '登陆日志');


    }

    public function req(Request $request)
    {
        dump($request);
    }


    public function ren()
    {
        return $this->fetch();
    }

    public function reg($account,$passwd){
        if($account == '123'){
            return json("ajax成功！".$account."---".$passwd);
        }else{
            return json("你输出的是其他值：".$account."---".$passwd);
        }
    }

    public function test($mess,$id){
        if($mess == '123'){
            return json("ajax成功！".$mess."---".$id);
        }else{
            return json("你输出的是其他值：".$mess."---".$id);
        }
    }

    public function create($data)
    {
           $a=$data;
            return json(['data'=>$a,'a'=>$a,'b'=>456]);
    }



}
