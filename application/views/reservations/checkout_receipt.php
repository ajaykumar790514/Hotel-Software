<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $row->guest_name ?> <?= date('D, M d ,Y', strtotime($booking->start_date)) ?> - <?= date('D, M d ,Y', strtotime($booking->end_date)) ?></title>
</head>

<body>
    <style type="text/css">
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 25.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        table>thead>tr>th {
            text-align: center;
            padding: 20px 0;
            margin-bottom: 30px;
            font-size: medium;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }





        table {
            width: 500px;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            margin: auto;
        }

        /* table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        } */

        table th,
        table td {
            text-align: left;
            padding: 5px;
            border: 1px solid;


        }

        table th {
            /* color: #5D6975; */
            white-space: nowrap;
            font-weight: normal;
        }


        table td {
            color: #5D6975;
        }

        table [int] {
            text-align: right;
        }


        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }

        #printPageButton {
            cursor: pointer;
        }

        @media print {
            #printPageButton {
                display: none;
            }
        }


        table tr.rooms td {
            white-space: nowrap;
        }
    </style>

    <main>
        <table class="">
            <thead>
                <tr>
                    <th colspan="7"> <?= $propmaster->propname ?> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>GUEST NAME</th>
                    <td colspan="3">
                        <?= $row->guest_name ?>
                    </td>
                    <td colspan="3" rowspan="3" center><?= $propmaster->address ?></td>
                </tr>

                <tr>
                    <th>CONTACT NO.</th>
                    <td colspan="3">
                        <?= $row->contact_no ?>
                    </td>
                </tr>

                <tr>
                    <th>EMAIL</th>
                    <td colspan="3">
                        <?= $row->email ?>
                    </td>
                </tr>

                <tr>
                    <th>COMPANY NAME</th>
                    <td colspan="3">
                        <?= $row->company_name ?>
                    </td>
                    <th>BILL NO.</th>
                    <th colspan="2">REC-000<?= $row->id ?></th>
                </tr>

                <tr>
                    <th>ADDRESS</th>
                    <td colspan="3">
                        <?= $row->address ?>
                    </td>
                    <th>COMPANY NAME(HOTEL)</th>
                    <td colspan="2"><?= $propmaster->propname ?></td>
                </tr>

                <tr>
                    <th>GST NO.</th>
                    <td colspan="3">
                        <?= $row->gst_no ?>
                    </td>
                    <th>GST NO.</th>
                    <td colspan="2">----</td>
                </tr>

                <tr>
                    <th>ROOM NO.</th>
                    <th>CHECK-OUT</th>
                    <th>CHECK-IN</th>
                    <!-- <th int>NO. OF DAYS</th> -->
                    <th int>ROOM RENT</th>
                    <th int>DISCOUNT</th>
                    <th int>GST</th>
                    <th int>TOTAL AMOUNT</th>
                </tr>
                <?php
                foreach ($checkout_rooms as $key => $value) { ?>
                    <tr class="rooms">
                        <td>

                            <?= $value->room_no ?> (<?= $value->room_type_name ?>)

                        </td>
                        <td><?= _date($value->start_date) ?></td>
                        <td><?= _date($value->end_date) ?></td>
                        <!-- <td int><?= $value->no_of_nights ?></td> -->
                        <td int><?= _number_format($value->price) ?></td>
                        <td int><?= _number_format($value->discount) ?></td>
                        <td int><?= $value->taxAmount ?></td>
                        <td int> <span class="total-room"><?= $value->total ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <th colspan="7"><br></th>
                </tr>
                <tr>



                <tr>
                    <th colspan="4"></th>
                    <th colspan="2">FOOD AMOUNT</th>
                    <td int>
                        <?= _number_format($row->food_amount) ?>
                    </td>
                </tr>
                <tr>
                <th colspan="4"></th>
                    <th colspan="2">OTHER AMOUNT</th>
                    <td int>
                        <?= _number_format($row->other_amount) ?>
                    </td>
                </tr>


                <tr>
                <th colspan="4"></th>
                    <th colspan="2">LUMP SUM DISCOUNT</th>
                    <td int>
                        <?= _number_format($row->lump_sum_discount) ?>
                    </td>
                </tr>
                <tr>
                <th colspan="4"></th>
                    <th colspan="2">GRAND TOTAL</th>
                    <td id="grand_total" int>
                        <?= _number_format($row->grand_total) ?>
                    </td>
                </tr>



                </tr>

            </tbody>
        </table>


        <!-- <div id="logo" style="margin-top: 20px;">
        <img src="<?= $logo ?>">
      </div> -->
        <div style="display: flex;justify-content: center;padding-top:5px;">
            <button id="printPageButton" style="float: right;" onClick="window.print();">Print</button>
        </div>

    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>