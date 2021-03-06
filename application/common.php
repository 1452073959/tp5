<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function exportExcel($spreadsheet, $format = 'xls', $savename = 'export') {
    if (!$spreadsheet) return false;
    if ($format == 'xls') {
        //输出Excel03版本
        header('Content-Type:application/vnd.ms-excel');
        $class = "\PhpOffice\PhpSpreadsheet\Writer\Xls";
    } elseif ($format == 'xlsx') {
        //输出07Excel版本
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $class = "\PhpOffice\PhpSpreadsheet\Writer\Xlsx";
    }
    //输出名称
    header('Content-Disposition: attachment;filename="'.$savename.'.'.$format.'"');
    //禁止缓存
    header('Cache-Control: max-age=0');
    $writer = new $class($spreadsheet);
    $filePath = env('runtime_path')."temp/".time().microtime(true).".tmp";
    $writer->save($filePath);
    readfile($filePath);
    unlink($filePath);
}