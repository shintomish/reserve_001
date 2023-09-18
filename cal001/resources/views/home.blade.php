@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    {{-- <div class="row justify-content-center"> --}}
       
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> --}}
        {{-- <body> --}}
            <div id="app">
                <div class="m-auto w-50 m-5 p-5">
                    <div id='calendar'></div>
                </div>
            </div>
    
            {{-- <link href='{{ asset('fullcalendar-6.1.8/lib/main.css') }}' rel='stylesheet' /> --}}
            {{-- <link href='https://unpkg.com/browse/@fullcalendar/core@6.1.8/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/daygrid@6.1.8/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/timegrid@6.1.8/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/list@6.1.8/main.min.css' rel='stylesheet' /> --}}
            <link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' rel='stylesheet' />
            <link href='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css' rel='stylesheet' />
        
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'ja',
                        height: 'auto',
                        firstDay: 7,
                        headerToolbar: {
                            left: "dayGridMonth,listMonth",
                            center: "title",
                            right: "today prev,next"
                        },
                        buttonText: {
                            today: '今月',
                            month: '月',
                            list: 'リスト'
                        },
                        noEventsContent: 'スケジュールはありません',
                    });
                    calendar.render();
                });
            </script>
        {{-- </body> --}}
    {{-- </div> --}}
{{-- </div> --}}
@endsection
