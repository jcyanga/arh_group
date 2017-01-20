<?php

namespace backend\controllers;

use Yii;
use common\models\SearchStockIn;

class ReportsController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMonthlyStockReport() 
    {
        $model = new SearchStockIn();

        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $getMonthlyStock = $model->getMonthlyStockByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $date_start = Yii::$app->request->post('date_start');
            $date_end = Yii::$app->request->post('date_end');

        } else {
            $getMonthlyStock = $model->getMonthlyStock();
            $date_start = '';
            $date_end = '';

        }

    	return $this->render('monthly-stock-report',[
                            'getMonthlyStock' => $getMonthlyStock,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print monthly stock report
    public function actionPrintMonthlyStockReportExcel() 
    {
        $model = new SearchStockIn();
        
        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $result = $model->getMonthlyStockByDateRange(Yii::$app->request->post('dateStart'), Yii::$app->request->post('dateEnd'));
            $dateStart = date('M-d-Y',strtotime(Yii::$app->request->post('dateStart')));
            $dateEnd = date('M-d-Y',strtotime(Yii::$app->request->post('dateEnd')));

        }else{
            $result = $model->getMonthlyStock();
            $dateStart = date('M-d-Y');
            $dateEnd = date('M-d-Y');

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', '#')
             ->setCellValue('B1', 'Supplier Name')
             ->setCellValue('C1', 'Product Name')
             ->setCellValue('D1', 'Quantity')
             ->setCellValue('E1', 'Cost Price')
             ->setCellValue('F1', 'Selling Price')
             ->setCellValue('G1', 'Date Imported');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $dateImported = date('m-d-Y', strtotime($result_row['date_imported']) );    

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['supplier_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'$'.$result_row['cost_price'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'$'.$result_row['selling_price'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$dateImported);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Monthly-Stock-Report(".$dateStart."-TO-".$dateEnd.").xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   

    }

    public function actionMonthlySalesReport() 
    {
    	$model = new SearchStockIn();

        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $getMonthlySales = $model->getMonthlySalesReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $date_start = Yii::$app->request->post('date_start');
            $date_end = Yii::$app->request->post('date_end');

        } else {
            $getMonthlySales = $model->getMonthlySales();
            $date_start = '';
            $date_end = '';

        }

        return $this->render('monthly-sales-report',[
                            'getMonthlySales' => $getMonthlySales,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print monthly sales report
    public function actionPrintMonthlySalesReportExcel() 
    {
        $model = new SearchStockIn();
        
        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $result = $model->getMonthlySalesReportByDateRange(Yii::$app->request->post('dateStart'), Yii::$app->request->post('dateEnd'));
            $dateStart = date('M-d-Y',strtotime(Yii::$app->request->post('dateStart')));
            $dateEnd = date('M-d-Y',strtotime(Yii::$app->request->post('dateEnd')));

        }else{
            $result = $model->getMonthlySales();
            $dateStart = date('M-d-Y');
            $dateEnd = date('M-d-Y');

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Invoice Number')
             ->setCellValue('B1', 'Total Selling Price')
             ->setCellValue('C1', 'Customer Name')
             ->setCellValue('D1', 'Customer Amount Paid')
             ->setCellValue('E1', 'Date Issue');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $dateIssue = date('m-d-Y', strtotime($result_row['date_issue']) );    

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['invoice_no']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'$'.$result_row['grand_total'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'$'.$result_row['amount'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$dateIssue);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Monthly-Sales-Report(".$dateStart."-TO-".$dateEnd.").xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   

    }

    public function actionBestSellingProductReport() 
    {
        $model = new SearchStockIn();

        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $getBestSellingService = $model->getBestSellingServicesReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $getBestSellingParts = $model->getBestSellingPartsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

            $date_start = Yii::$app->request->post('date_start');
            $date_end = Yii::$app->request->post('date_end');

        } else {
            $getBestSellingService = $model->getBestSellingService();
            $getBestSellingParts = $model->getBestSellingParts();

            $date_start = '';
            $date_end = '';

        }

        return $this->render('best-selling-product-report',[
                            'getBestSellingService' => $getBestSellingService, 
                            'getBestSellingParts' => $getBestSellingParts,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print best selling product report
    public function actionPrintBestSellingProductReportExcel() 
    {
        $model = new SearchStockIn();
        
        if( Yii::$app->request->post('dateStart') <> "" && Yii::$app->request->post('dateEnd') <> "" ) {
            $result = $model->getBestSellingServicesReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $result1 = $model->getBestSellingPartsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

            $dateStart = date('M-d-Y',strtotime(Yii::$app->request->post('dateStart')));
            $dateEnd = date('M-d-Y',strtotime(Yii::$app->request->post('dateEnd')));

        }else{
            $result = $model->getBestSellingService();
            $result1 = $model->getBestSellingParts();

            $dateStart = date('M-d-Y');
            $dateEnd = date('M-d-Y');

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Invoice Number')
             ->setCellValue('B1', 'Category')
             ->setCellValue('C1', 'Service Name / Product Name')
             ->setCellValue('D1', 'Quantity')
             ->setCellValue('E1', 'Total Sold Amount');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['invoice_no']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['service_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'$'.$result_row['subTotal'].'.00');

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

                foreach ($result1 as $result_row1) {  
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row1['invoice_no']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row1['category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row1['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row1['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'$'.$result_row1['subTotal'].'.00');

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Best-Selling-Product-Report(".$dateStart."-TO-".$dateEnd.").xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   

    }

}
