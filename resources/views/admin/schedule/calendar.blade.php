
<div class="container">
    <div class="row justify-content-center">

        <!-- left -->
        @include('admin.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card"></i> カレンダー共有</div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                    </div>
                @endif

                    <div id='external-events'>
                        <p><strong>先生</strong></p>

                            @foreach ( $data as $d )
                            <div class="fc-event">{{ $d->teacher_name }}<span style="opacity:0;">:{{ $d->id }}</span></div>
                            @endforeach

                        <p style="display:none;">
                        <input type='checkbox' id='drop-remove' />
                           <label for='drop-remove'>remove after drop</label>
                        </p>
                    </div>

                    <div id='calendar-container'>
                       <div id='calendar'></div>
                   </div>
               </div><!-- end card-body -->
           </div><!-- end card -->
        </div>
    </div>
</div>
<script>
    var arr = info.event.title.split(':');
    info.event.setExtendedProp('teacher_id', arr[1]);

    document.addEventListener('DOMContentLoaded', function() {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');
        var checkbox = document.getElementById('drop-remove');

        // initialize the external events
        new Draggable(containerEl, {
            itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText
                    };
                }
        });

        // initialize the calendar
        var calendar = new Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid','list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            allDaySlot: false,
            forceEventDuration : true,
            eventColor: 'lavender',
            defaultTimedEventDuration: '01:00',
            defaultView: 'timeGridWeek',
            slotDuration: '00:10:00',
            minTime : '10:00',
            maxTime : '22:10',
            locale : 'jaLocale',
            editable: true,
            selectable: true,
            allDaySlot: false,
            droppable: true, // this allows things to be dropped onto the calendar
                buttonText: {
                    today:'今日',
                    month:'月',
                    week: '週',
                    day:  '日',
                    list: 'リスト'
                },

            events:'/admin/events/source',

            select: function (info) {
                // カレンダーセルクリック、範囲指定された時のコールバック
                console.log('select');
            },

            eventReceive: function(info) {
                // イベントがexternal-eventからドロップされた時のコールバック
                console.log('eventReceive');
            },

            eventDrop: function(info) {
                // イベントがドロップされた時のコールバック
                console.log('eventDrop');
            },

            eventResize: function(info) {
                // イベントがリサイズ（引っ張ったり縮めたり）された時のコールバック
                console.log('eventResize');
            },

            eventRender: function (info) {
            //wired listener to handle click counts instead of event type
            info.el.addEventListener('click', function() {
                clickCnt++;
                if (clickCnt === 1) {
                    oneClickTimer = setTimeout(function() {
                        clickCnt = 0;

                        // SINGLE CLICK
                        console.log('single click');

                    }, 400);
                } else if (clickCnt === 2) {
                    clearTimeout(oneClickTimer);
                    clickCnt = 0;

                    // DOUBLE CLICK
                    console.log('double click');
                }
            });
            }
        })
        calendar.render();
    });
    // eventReceive時に走る処理のサンプル 

    // 略
    eventReceive: function(info) {
            Create(info);
        },
    // 略

    const Create = (info) => {

        var dt = new Date();
        info.event.setExtendedProp('identifier',dt.getTime());

        // csrf。Laravelお約束
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'post',
            data: {
                    'identifier': info.event.extendedProps.identifier,
                    'teacher_id': info.event.extendedProps.teacher_id,
                    'start': info.event.start,
                    'end': info.event.end
            },
            datatype: 'json',
                url: '/admin/update' /* identifierをキーに登録or更新 */
            })
            .done(function(data){
                json = JSON.parse(data);
                if ( json['result'] == 'success' ) {
                    // サーバサイドにて設定された背景色に変更
                    info.event.setProp('color',json['color']);
                }
            })
            .fail(function(data){
                alert('error');
            });
    }


</script>
