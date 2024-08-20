@extends('layouts.app')

@section('title', 'Cek Jadwal')

@section('content')
    <!-- start page title section -->
    <section class="page-title-section bg-img cover-background" data-overlay-dark="4" data-background="img/IMG_9306.jpg">
        <div class="container">
            <h1>Cek Jadwal</h1>
            <ul>
                <li>
                    <a href="/">Beranda</a>
                </li>
                <li>
                    <a href="/jadwal">Cek Jadwal</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- end page title section -->

    <!-- start gallery section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="width-100">
                    <div id='calendar'></div>
                    <br>
                    <!-- Legend -->
                    <div class="calendar-legend">
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: green;"></span>
                            <span class="legend-text">Tersedia</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: red;"></span>
                            <span class="legend-text">Tidak Tersedia</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: orange;"></span>
                            <span class="legend-text">Belum Dibayar</span>
                        </div>
                    </div>
                    <!-- End Legend -->
                </div>
            </div>
        </div>
    </section>
    <!-- end gallery section -->
@endsection

@push('customStyle')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' />
    <style>
        .fc-other-month .fc-day-number {
            visibility: hidden;
        }
        .calendar-legend {
            margin-top: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 10px;
        }
        .legend-text {
            font-size: 14px;
        }
    </style>
@endpush

@push('customScript')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/id.js'></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                locale: 'id',
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next today'
                },
                columnFormat: 'dddd',
                eventSources: [
                    @foreach ($gedungs as $gedung)
                        {
                            events: [
                                @foreach ($gedung['dates'] as $date)
                                    @if ($date['status'] === 0 || $date['status'] === 4)
                                        {
                                            title: "Pending",
                                            start: "{{ $date['date'] }}",
                                            color: "orange"
                                        },
                                    @elseif ($date['status'] === 1 || $date['status'] === 2)
                                        {
                                            title: "Sudah dipesan",
                                            start: "{{ $date['date'] }}",
                                            color: "red"
                                        },
                                    @endif
                                @endforeach
                            ],
                            textColor: 'white',
                        },
                    @endforeach
                ],
                dayRender: function(date, cell) {
                    if (date.format('YYYY-MM-DD') < moment().format('YYYY-MM-DD')) {
                        cell.css("background-color", "#eaeaea");
                        cell.css("cursor", "not-allowed");
                    } else {
                        cell.css("cursor", "pointer");
                        cell.append(
                            '<div class="badge-center">' +
                            '<div class="badge badge-success">Klik untuk pesan</div>' +
                            '</div>'
                        );
                    }
                },
                eventRender: function(event, element) {
                    element.find('.fc-title').css({
                        "display": "flex",
                        "justify-content": "center",
                        "align-items": "center"
                    });
                },
                eventAfterAllRender: function(view) {
                    var dayEvents = $('#calendar').fullCalendar('clientEvents');
                    $.each(dayEvents, function(index, event) {
                        if (event.end) {
                            var dates = getDates(event.start, event.end);
                            $.each(dates, function(index, value) {
                                var td = $('td.fc-day[data-date="' + value + '"]');
                                td.find('div:first').remove();
                            });
                        } else {
                            var td = $('td.fc-day[data-date="' + event.start.format('YYYY-MM-DD') + '"]');
                            td.find('div:first').remove();
                        }
                    });
                },
                eventColor: '#378006',
                displayEventTime: false,
                dayClick: function(date, jsEvent, view) {
                    var clickedDate = date.format('YYYY-MM-DD');
                    var hasEvents = $('#calendar').fullCalendar('clientEvents', function(event) {
                        return event.start.format('YYYY-MM-DD') === clickedDate;
                    }).length > 0;

                    if (hasEvents) {
                        jsEvent.preventDefault();
                        return false;
                    }

                    if (clickedDate < moment().format('YYYY-MM-DD')) {
                        return false;
                    }

                    window.location.href = "{{ url('cari') }}?date=" + clickedDate;
                },
                fixedWeekCount: false,
                showNonCurrentDates: false // Hide non-current month dates
            });
        });

        function getDates(startDate, endDate) {
            var now = startDate,
                dates = [];

            while (now.format('YYYY-MM-DD') <= endDate.format('YYYY-MM-DD')) {
                dates.push(now.format('YYYY-MM-DD'));
                now.add(1, 'days'); // Update to add days correctly
            }
            return dates;
        }
    </script>
@endpush