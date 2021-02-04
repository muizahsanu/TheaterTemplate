<?php
    $data = array (
        array(1,123,22,32,1),
        array(2,32,44,12,2),
        array(3,32,12,11,1),
        array(4,22,44,55,3)
    );
    $KR = array();
    $KG = array();
    $KB = array();
    $jumlahK = 3;
    // foreach($data as $pixel){
    //     for($i=0; $i<$jumlahK; $i++){
    //         if($pixel[4] == $jumlahK-$i){
    //             $RK[$jumlahK-1][1] = $RK[$jumlahK-1][1] + $pixel[$i][1];
    //         }
    //     }
    // }
    error_reporting(0);
?>
<html>
<head>
    <style>
        table {
            width:100%;
        }
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
            <?php for($i = 0; $i < $jumlahK; $i++){ ?>
            <th>K<?php print($i+1); ?></th>
            <?php } ?>
        </tr>
        <?php foreach($data as $d){ ?>
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
        </tr>
        <?php } ?>
    </table>
    <?php 
        ?> <br><hr> <?php
        foreach($data as $pixel){
            for($i=0; $i<$jumlahK; $i++){
                if($pixel[4] == $i+1){
                    $KR[$i] = $KR[$i] + $pixel[1];
                }
            }
            for($i=0; $i<$jumlahK; $i++){
                if($pixel[4] == $i+1){
                    $KG[$i] = $KG[$i] + $pixel[2];
                }
            }
            for($i=0; $i<$jumlahK; $i++){
                if($pixel[4] == $i+1){
                    $KB[$i] = $KB[$i] + $pixel[3];
                }
            }
        }
        ?><p><?php print("KR = "); print_r($KR);?></p><?php
        ?><p><?php print("KG = "); print_r($KG);?></p><?php
        ?><p><?php print("KB = "); print_r($KB);?></p><?php
    ?>
</body>
</html>