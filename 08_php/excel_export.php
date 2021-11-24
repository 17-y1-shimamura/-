
<?php

$filename = 'filestream.txt';
$content = '入力文字列';
 
$fp = fopen($filename,'w');
 
fwrite($fp,$content);
 
fclose($fp);

// // ライブラリ読込
// require_once(__DIR__ . "/PHPExcel-1.8/Classes/PHPExcel.php");
 
// // PHPExcelオブジェクト作成
// $objBook = new PHPExcel();
 
// // シート設定
// $objSheet = $objBook->getActiveSheet();
 
// // [A1]セルに文字列設定
// $objSheet->setCellValue('A1', 'ABCDEFG');
 
// // [A2]セルに数値設定
// $objSheet->setCellValue('A2', 123.56);
 
// // [A3]セルにBoolean値設定
// $objSheet->setCellValue('A3', TRUE);
 
// // [A4]セルに書式設定
// $objSheet->setCellValue('A4', '=IF(A3, CONCATENATE(A1, " ", A2), CONCATENATE(A2, " ", A1))');
 
// // Excel2019形式で保存する
// $objWriter = PHPExcel_IOFactory::createWriter($objBook, "Excel2019");
// $objWriter->save('test.xlsx');
// exit();
?>
