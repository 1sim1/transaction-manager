<?php
require(__DIR__ . "/../db/db_singleton.php");
require(__DIR__ . "/../model/TransactionEntity.php");
class TransactionController
{
    public function actionPostInsertTransaction()
    {
        try {
            $transactionModel = new TransactionEntity();
            $csvContent = $_POST['fileContent'];
            $rows = explode("\n", $csvContent);
            $totalIncome = 0;
            $totalExpense = 0;
            $arrayCsvContent = array();
            array_shift($rows);
            foreach ($rows as $row) {
                if (empty(trim($row))) {
                    continue;
                }
                $fields = str_getcsv($row);
                $fields[3] = str_replace("\"", "", $fields[3]);
                $fields[3] = str_replace("$", "", $fields[3]);
                $fields[3] = str_replace(",", "", $fields[3]);
                if (str_starts_with($fields[3], '-')) {
                    $totalExpense -= $fields[3];
                } else {
                    $totalIncome += $fields[3];
                }
                array_push($arrayCsvContent, $row);
                $totalIncome = round($totalIncome, 2);
                $totalExpense = round($totalExpense, 2);
                $formattedDate = date("Y-m-d", strtotime($fields[0]));
                $transactionModel->insertTransaction($formattedDate, $fields[1], $fields[2], $fields[3]);
            }
            $ret['cod'] = 0;
            $ret['dat'] = $arrayCsvContent;
            $ret['income'] = $totalIncome;
            $ret['expense'] = $totalExpense;
            $ret['msg'] = 'Inserimento transazioni effettuato correttamente';
        } catch (Exception $e) {
            $ret['cod'] = 1;
            $ret['msg'] = 'ERRORE inserimento transazioni: ' . $e->getMessage();
        }
        echo json_encode($ret);
    }
}
