<script>
    <script>
        let maintenanceStats ={!! json_encode($MaintenanceStats) !!};
        var labels ={!! json_encode($labels) !!};
        var costValues ={!! json_encode($costValues) !!};
        console.log(labels);
        console.log(costValues);



        //  var maintenance = {{ Illuminate\Support\Js::from($MaintenanceStats) }};
        // var maintenance = <?php echo json_encode($MaintenanceStats); ?>;
        //  var maintenance = {{ Js::from($MaintenanceStats) }};
    //    var labels = [];
    //    var data = [];
    //    var totalCost = 0;
    //    var avgMonth = 0;
    //    console.log(maintenanceStats);

    //    for(let month in maintenanceStats){
    //         var costSum = 0;
    //         let label= month;
    //         labels.push(label);
    //         // console.log(maintenanceStats[months]);

    //         for(let costVal of maintenanceStats[month]){
    //             costSum += costVal['cost'];
    //             totalCost += costVal['cost'];
    //             var cost = costVal['cost'];
    //             console.log(costVal);
    //         }
    //         console.log("jbgwg");

    //         data.push(costSum);
    //         // console.log(var1);
    //     }
    //     avgMonth = parseInt(totalCost/labels.length);

    //     // console.log(maintenanceStats);
        // console.log(totalCost);


        var options = {
          series: [
            {
            name: 'Taka',
            type: 'column',
            data: costValues
            },
            {
            name: 'Taka',
            type: 'line',
            data: costValues
            }
        ],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: [0, 4]
        },
        // title: {
        //   text: 'Test'
        // },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [1]
        },
        labels: labels,
        xaxis: {
          type: 'text'
        },
        yaxis: [
            {
                title: {
                    text: 'Taka',
                },
            },
            // {
            //     opposite: true,
            //     title: {
            //         text: 'Social Media'
            //     }
            // }
        ]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
     </script>
</script>

