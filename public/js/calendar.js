$(function () {

    var data = JSON.parse(document.getElementById('promotion_data').value);
    var event_data = [];

    for(var i = 0; i< data.length; i++) {
        event_data.push({title: data[i].title, start : data[i].start_date, end: data[i].end_date, imageurl: data[i].path})
    }

    console.log('event data', event_data);
    if ($('#calendar').length) {
        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            height: 650,
            navLinks: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            //Events
            events: event_data,
            resourceColumns: [
                {
                    labelText: 'Rooms',
                    field: 'room'
                },
                {
                    labelText: 'KVM',
                    field: 'kvm'
                }
            ],
            resources: [],
            selectable: true,
            select: function(startDate, endDate) {
                $('#start_date').val(startDate.year() + '-' + (startDate.month() + 1 > 9 ? '': '0') + (startDate.month() + 1) + '-' + (startDate.date() > 9 ? '' : '0') + startDate.date());
                $('#end_date').val(endDate.year() + '-' + (endDate.month() + 1 > 9 ? '': '0') + (endDate.month() + 1) + '-' + (endDate.date() > 9 ? '' : '0') + endDate.date());
                document.getElementById('setting_field').style.display = 'block';
                default_setting = 0;
                $('#createContractModal').modal({
                    show: true
                });
            },
            eventRender: function(event, eventElement) {
                if (event.imageurl) {
                    eventElement.find("div.fc-content").prepend("<img src='" + event.imageurl +"' width='35' height='35'>");
                }
            },
        });
    }
});
