<div class="card-body card-dashboard">
<div class="height-400">
<canvas id="column-chart" style="display: block;box-sizing: border-box;height: 400px;width: 120%;"></canvas>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php if(!empty($getYearlyData)){?>
<script>
    // Column chart
    // ------------------------------
    $(document).ready(function() {
        var ctx = document.getElementById("column-chart");

        var chartOptions = {
        };
       
        var chartData = {
            labels: [<?php foreach($getYearlyData as $yc){echo '"' . $yc->year . '", ' ;} ;?>],
            datasets: [
                {
                    label:['Yearly Wise'],
                    data: [
                        <?php foreach($getYearlyData as $yc){echo $yc->total_credit-$yc->total_debit."," ;} ;?>
                    ],
                    backgroundColor: "#28D094",
                    hoverBackgroundColor: "rgba(40,208,148,.9)",
                    borderColor: "transparent",
                }
            ],
        };
      

        var config = {
            type: "bar",

            options: chartOptions,

            data: chartData,
        };

        var lineChart = new Chart(ctx, config);
    });
</script>
<?php }?>
<?php if(!empty($dayschart)){?>
<script>
    // Column chart
    // ------------------------------
    $(document).ready(function() {
        var ctx = document.getElementById("column-chart");

        var chartOptions = {
        };
       
        var chartData = {
            labels: [<?php foreach($dayschart as $yc){echo '"' . $yc->tr_date . '", ' ;} ;?>],
            datasets: [
                {
                    label: <?=@$daterange;?>,
                    data: [
                        <?php foreach($dayschart as $yc){echo $yc->total_credit-$yc->total_debit."," ;} ;?>
                    ],
                    backgroundColor: "#28D094",
                    hoverBackgroundColor: "rgba(40,208,148,.9)",
                    borderColor: "transparent",
                }
            ],
        };
      

        var config = {
            type: "bar",

            options: chartOptions,

            data: chartData,
        };

        var lineChart = new Chart(ctx, config);
    });
</script>
<?php }?>
<?php if(!empty($yearchart)){?>
<script>
    // Column chart
    // ------------------------------
    $(document).ready(function() {
        var ctx = document.getElementById("column-chart");

        var chartOptions = {
        };
       
        var chartData = {
            labels: [<?php foreach($yearchart as $yc){echo '"' . $yc->month_name . '", ' ;} ;?>],
            datasets: [
                {
                    label: <?=@$year;?>,
                    data: [
                        <?php foreach($yearchart as $yc){echo $yc->total_credit-$yc->total_debit."," ;} ;?>
                    ],
                    backgroundColor: "#28D094",
                    hoverBackgroundColor: "rgba(40,208,148,.9)",
                    borderColor: "transparent",
                }
            ],
        };
      

        var config = {
            type: "bar",

            options: chartOptions,

            data: chartData,
        };

        var lineChart = new Chart(ctx, config);
    });
</script>
<?php }?>