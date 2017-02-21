<?php

    session_start();

    header('Content-type: text/html; charset=utf-8');

    include_once 'connect.php';

    printf('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">');
    printf('<style>*{font-size: 12px;}</style>');

    printf("<table class='table table-bordered table-hover'>");
    printf("<tr><th colspan='10'>Registration/报名信息</th></tr>");
    printf("<tr><th colspan='2'>Wechat pay/微信支付</th><th colspan='4'>Use wechat pay but didn't finish the payment /选择微信支付但没有完成付款</th><th colspan='2'>Pay onsite/现场支付</th><th colspan='2'>Total/总报名人数</th></tr>");


    if ($stmt = $mysqli->prepare("SELECT count(*) FROM user WHERE paystatus=1")) {

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($totalpplofonlinepaid);

        /* fetch value */
        $stmt->fetch();

        // Display the data.
        printf("<tr><td colspan='2'>%s</td>", $totalpplofonlinepaid);

        /* close statement */
        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("SELECT count(*) FROM user WHERE paystatus=0")) {

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($totalpplofnonpayment);

        /* fetch value */
        $stmt->fetch();

        // Display the data.
        printf("<td colspan='4'>%s</td>", $totalpplofnonpayment);

        /* close statement */
        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("SELECT count(*) FROM user WHERE paystatus=3")) {

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($totalpplofbelowlinepaid);

        /* fetch value */
        $stmt->fetch();

        // Display the data.
        printf("<td colspan='2'>%s</td>", $totalpplofbelowlinepaid);

        /* close statement */
        $stmt->close();
    }



    if ($stmt = $mysqli->prepare("SELECT count(*) FROM user")) {

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($totalppl);

        /* fetch value */
        $stmt->fetch();

        // Display the data.

        printf("<td colspan='2'>%s</td></tr>", $totalppl);

        /* close statement */
        $stmt->close();
    }

    /* list */
    printf("<tr><th colspan='10'></th></tr>");
    printf("<tr><th colspan='10'>List/报名列表</th></tr>");
    printf("<tr><th>Name/姓名</th><th>Wechat/微信昵称</th><th>Phone/手机号码</th><th>Email/邮箱</th><th>Profession/职业</th><th>Why Come/来访原因</th><th>Pay Status/支付状态</th><th>Date/报名时间</th><th>Redeem Status/入场情况</th></tr>");
    if ($result = $mysqli->query("SELECT name, nickname, phone, email, whoyouare, lookingforshmadness, paystatus, adate, numbers FROM user")) {

        /* fetch value */
        while($row = mysqli_fetch_array($result)){
            printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['name'], $row['nickname'], $row['phone'], $row['email'], profession($row['whoyouare']), whycome($row['lookingforshmadness']), paystatus($row['paystatus']), $row['adate'], redeem($row['numbers'])); //, $row['outtradeno']
        }

    }

    function profession($n)
    {
        switch($n)
        {
            case 1:
            return "Artist";
            break;
            case 2:
            return "Architect";
            break;
            case 3:
            return "Designer";
            break;
            case 4:
            return "Entrepreneur";
            break;
            case 5:
            return "Fashion Designer";
            break;
            case 6:
            return "Graphic Designer";
            break;
            case 7:
            return "Musician";
            break;
            case 8:
            return "Photographer";
            break;
            case 9:
            return "Other";
            break;
        }
    }

    function whycome($n)
    {
        switch($n)
        {
            case 1:
                return "Find a creative agency";
                break;
            case 2:
                return "Find a creative job";
                break;
            case 3:
                return "Inspiring speakers";
                break;
            case 4:
                return "Just for fun";
                break;
            case 5:
                return "Other";
                break;
        }
    }

    function paystatus($n)
    {
        switch($n)
        {
            case 0:
                return "Waiting To Pay on Wechat/待支付";
                break;
            case 1:
                return "Paid/已支付";
                break;
            case 2:
                return "Pay on Site/线下支付";
                break;
            case 3:
                return "Pay on Site/线下支付";
                break;
        }
    }

    function redeem($n)
    {
        switch($n)
        {
            case 0:
            case 1:
            case 2:
                return "Waiting to redeem/未入场";
                break;
            case 3:
                return "Redeemed/已入场";
                break;
        }
    }

    printf("</table>");
?>