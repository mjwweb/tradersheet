
    <?php

    function formatReturnChartData($data) {
        $firstExitDate = new DateTime(array_key_first($totalReturnChartData));
        $firstExitDate = $firstExitDate->format('Y-m-d');
        $dayZero = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($firstExitDate) ) ));
        
        $dates = array_keys($data);
        $values = array_keys($data);
        $arr = [];

        $len = $trcKeys;

        for ($i=0; $i < $len; $i++) {
            $unix = new DateTime(strtotime($dates[$i]));
            $value = $values[$i];

            array_push($arr, $unix, $value);
        }

        return $arr;
    }



