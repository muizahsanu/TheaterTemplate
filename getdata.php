<?php
    error_reporting(0);
    
    $row = 1;
    $allData = array();
    $pixelKe = 0;
    $K = 3;
    $KR = array();
    $KG = array();
    $KB = array();
    $totalK1 = 0;
    $totalK2 = 0;
    $totalK3 = 0;
    $centroidSetiapCluster = array();

    // Mengambil data dari file csv lalu dipindahkan ke array
    if (($handle = fopen("data2.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            $arrInside = [];
            for ($c=0; $c < $num; $c++) {
                if($data[$c] != null && $row>=3){
                    $allData[$pixelKe][$c] = $data[$c];
                }
            }
            $pixelKe++;
        }
        fclose($handle);
    }

    // Menentukan kluster
    for($i = 1; $i <= count($allData); $i++){
        $randNum = rand(1,$K);
        $allData[$i][4] = $randNum;
    }

    // Menghitung kluster
    foreach($allData as $pixel){
        for($i=0; $i<$K; $i++){
            if($pixel[4] == $i+1){
                $KR[$i] = $KR[$i] + $pixel[1];
                $KG[$i] = $KG[$i] + $pixel[2];
                $KB[$i] = $KB[$i] + $pixel[3];
            }
        }
    }
    ?><p><?php print("KR = "); print_r($KR);?></p><?php
    ?><p><?php print("KG = "); print_r($KG);?></p><?php
    ?><p><?php print("KB = "); print_r($KB);?></p><?php

    // Mendapatkan total K1
    foreach($allData as $data){
        if($data[4] == 1){
            $totalK1 = $totalK1 + 1;
        }
        elseif($data[4] == 2){
            $totalK2 = $totalK2 + 1;
        }
        else{
            $totalK3 = $totalK3 + 1;
        }
    }
    print($totalK1);
    echo "<br>";
    print($totalK2);
    echo "<br>";
    print($totalK3);
    echo "<br>";

    // Centroid Setiap Cluster
    for($i = 0; $i < $K; $i++){
        $asd = array();
        if($i == 0){
            array_push($asd,$KR[$i] / $totalK1);
            array_push($asd,$KG[$i] / $totalK1);
            array_push($asd,$KB[$i] / $totalK1);
        }
        elseif($i == 1){
            array_push($asd,$KR[$i] / $totalK2);
            array_push($asd,$KG[$i] / $totalK1);
            array_push($asd,$KB[$i] / $totalK1);
        }
        else{
            array_push($asd,$KR[$i] / $totalK3);
            array_push($asd,$KG[$i] / $totalK1);
            array_push($asd,$KB[$i] / $totalK1);
        }
        array_push($centroidSetiapCluster,$asd);
    }

    // print_r($centroidSetiapCluster);

    // Menghitung jarak centroid
    $seolahC1 = array();
    $semuaC = array();
    foreach($allData as $data){
        for($i = 0; $i < $K; $i++){
            $rumusR = sqrt(pow($data[$i+1] - $centroidSetiapCluster[$i][$i],2) + pow($data[$i+2] - $centroidSetiapCluster[$i][$i+1],2) + pow($data[$i+3] - $centroidSetiapCluster[$i][$i+2],2));
            array_push($seolahC1, $rumusR);
            // $C1 = sqrt(pow($data[$i+1] - $centroidSetiapCluster[$i][$i],2) + pow($data[$i+2] - $centroidSetiapCluster[$i][$i+1],2) + pow($data[$i+3] - $centroidSetiapCluster[$i][$i+2],2));
            // $C2 = sqrt(pow($data[$i+1] - $centroidSetiapCluster[$i+1][$i],2) + pow($data[$i+2] - $centroidSetiapCluster[$i+1][$i+1],2) + pow($data[$i+3] - $centroidSetiapCluster[$i+1][$i+2],2));
            // $C2 = sqrt(pow($data[$i+1] - $centroidSetiapCluster[$i+1][$i],2) + pow($data[$i+2] - $centroidSetiapCluster[$i+1][$i+1],2) + pow($data[$i+3] - $centroidSetiapCluster[$i+1][$i+2],2));
            
        }
    }
    // print_r($seolahC1);

    echo "<br>";
    print(count($seolahC1) / $K);
    echo "<br>";
    $jumlahData = count($allData);
    for($i = 1; $i <= $K; $i++){
        $sementara = array();
        for($j = ($i-1)*$jumlahData; $j < (count($seolahC1)/$K)*$i; $j++){
            if($j < (count($seolahC1)/$K)*$i){
                array_push($sementara,$seolahC1[$j]);
            }
        }
        array_push($semuaC,$sementara);
            // array_push($semuaC,$asu);
    }
    
    echo '<hr>';
    print_r($semuaC);
    echo '<hr>';
    print(count($semuaC[0]));

    // for($i = 0; $i < count($seolahC1); $i++){
    //     if($i < )
    // }
    

    // echo "<br>" . $allData[1][1];
    // echo "<br>";
    // $C1 = $allData[1][1] - $centroidSetiapCluster[0][0];
    // print($C1);

?>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        #t01 tr:nth-child(even) {
            background-color: #eee;
        }
        #t01 tr:nth-child(odd) {
            background-color: #fff;
        }
        #t01 th {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <table id="t01">
        <tr>
            <th>Pixel</th>
            <th>R</th>
            <th>G</th>
            <th>B</th>
            <?php for($i = 1; $i <= $K; $i++){ ?>
            <th>K<?php print($i); ?></th>
            <?php } ?>

            <?php for($i = 0; $i < count($KR); $i++){ ?>
            <th>K<?php print($i+1); ?>R</th>
            <th>K<?php print($i+1); ?>G</th>
            <th>K<?php print($i+1); ?>B</th>
            <?php } ?>

            <?php for($i = 0; $i < count($semuaC); $i++){ ?>
            <th>C<?php echo $i+1; ?></th>
            <?php } ?>

            <th>Min</th>
        </tr>
        <?php 
            $nomorC = 0;?>
        <?php foreach($allData as $d){?>
        <tr>
            <td><?php print($d[0]); ?></td>
            <td><?php print($d[1]); ?></td>
            <td><?php print($d[2]); ?></td>
            <td><?php print($d[3]); ?></td>
            <?php if($d[4] == 1){ ?>
                <td>*</td>
                <td></td>
                <td></td>
            <?php } elseif($d[4] == 2){?>
                <td></td>
                <td>*</td>
                <td></td>
            <?php } else{?>
                <td></td>
                <td></td>
                <td>*</td>
            <?php } ?>
            <?php if($d[4] == 1){ ?>
            <td><?php print($d[1]); ?></td>
            <td><?php print($d[2]); ?></td>
            <td><?php print($d[3]); ?></td>
            <td colspan="6" style="background-color:white;"></td>
            <?php } elseif($d[4] == 2){?>
            <td colspan="3" style="background-color:white;"></td>
            <td><?php print($d[1]); ?></td>
            <td><?php print($d[2]); ?></td>
            <td><?php print($d[3]); ?></td>
            <td colspan="3" style="background-color:white;"></td>
            <?php } else{?>
            <td colspan="6" style="background-color:white;"></td>
            <td><?php print($d[1]); ?></td>
            <td><?php print($d[2]); ?></td>
            <td><?php print($d[3]); ?></td>
            <?php } ?>

            <?php for($i = 0; $i < count($semuaC); $i++){ ?>
            <td>
            <?php echo $semuaC[$i][$nomorC]; ?>
            </td>
            <?php }
            $iniMin = array();?>

            <td>
            <?php for($i = 0; $i < count($semuaC); $i++){
                array_push($iniMin,$semuaC[$i][$nomorC]); ?>
            <?php } 
            echo min($iniMin);
            $nomorC++; ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="7">Total</td>
            <?php for($i=0; $i<count($KR); $i++){?>
            <?php if($i == 0){ ?>
                <td><?php echo $KR[0] ?></td>
                <td><?php echo $KG[0] ?></td>
                <td><?php echo $KB[0] ?></td>
            <?php } elseif($i == 1){ ?>
                <td><?php echo $KR[1] ?></td>
                <td><?php echo $KG[1] ?></td>
                <td><?php echo $KB[1] ?></td>
            <?php } else{ ?>
                <td><?php echo $KR[2] ?></td>
                <td><?php echo $KG[2] ?></td>
                <td><?php echo $KB[2] ?></td>
            <?php } ?>
            <?php } ?>
        </tr>
    </table>
</body>
</html>