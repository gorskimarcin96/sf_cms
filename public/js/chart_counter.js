$(document).ready(function () {
    if($('#counter_chart_data').length){
        const data = JSON.parse($('#counter_chart_data').val());

        for (let i = 0; i < 4; i++) {
            let id = 'counter_chart_' + i;

            $('#main>div.row').append('<div class="col-lg-12 ' + (i > 2 ? 'col-xl-12' : 'col-xl-6') + '"><div>' +
                '<div class="card m-2">' +
                '<div class="card-header">Ostatnie ' + data[i].days + ' dni</div>' +
                '<div class="card-body"><canvas id="' + id + '"></canvas></div>' +
                '</div>' +
                '</div></div>'
            );

            new Chart(document.getElementById(id).getContext('2d'), {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Liczba odświeżeń',
                        data: data[i].refresh,
                        borderColor: '#080'
                    }, {
                        label: 'Liczba unikalnych wejść IP',
                        data: data[i].entries,
                        borderColor: '#808'
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            type: 'time'
                        }]
                    }
                }
            });
        }
    }
});
