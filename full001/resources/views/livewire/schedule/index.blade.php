<div>
    {{-- In work, do what you enjoy. --}}
</div>
<div class="pt-3">
    <x-adminlte-card>
        <div class="d-flex">
            <div class="mr-auto d-flex align-items-center justify-content-center">
                <h4>スケジュール</h4>
            </div>
            <div class="d-flex">
                <div class="mr-2 dropdown" wire:ignore>
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ユーザーフィルター
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @foreach($users as $user)
                            <div class="dropdown-item">
                                <div class="icheck-info">
                                    <input type="checkbox" id="filter_user_{{ $user->id }}"
                                           name="selectStoreIds" value="{{ $user->id }}"
                                           wire:model.lazy="selectedUserIds"/>
                                    <label class="font-weight-normal" for="filter_user_{{ $user->id }}">
                                        {{ $user->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- <livewire:schedule.create/> --}}
            </div>
        </div>
        <div wire:loading.flex class="align-items-center justify-content-center">
            読み込み中...
        </div>
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
    </x-adminlte-card>
   
</div>
@push('js')
<script>
    //ドロップダウンメニュー内でクリックされてもメニューを閉じないように制御
    $('.dropdown-menu').click(function (e) {
        e.stopPropagation();
    });
    document.addEventListener('livewire:load', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            //プレミアム機能を使うためのライセンスキー(これはトライアル)
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            //表示テーマ
            themeSystem: 'bootstrap',
            //カレンダーそのものの高さ
            height: 700,
            //各ボタンの表示テキスト変更
            buttonText: {
                resourceTimeGridDay: '日(グリッド)',
                resourceTimelineDay: '日',
            },
            //ツールバー
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,resourceTimelineDay,resourceTimeGridDay",
            },
            //初期表示
            initialView: 'dayGridMonth',
            //日本語化
            locale: 'ja',
            //リソースヘッダー名(日付モードの際に見える)
            resourceAreaHeaderContent: "ユーザー",
            //ユーザーが別の日付に移動したりビューを変更したりしたときに、リソースを再取得して再レンダリングするかどうか。
            refetchResourcesOnNavigate: true,
            //全日表示モードで時間表示するか
            displayEventTime: false,
            //日付クリックで日付モードにするかどうか
            navLinks: true,
            //月表示の時に見える「日」が邪魔なので消す
            dayCellContent: function (e) {
                e.dayNumberText = e.dayNumberText.replace('日', '');
            },
            //リソース取得(月が切り替わる度に更新)
            resources: function (fetchInfo, successCallback, failureCallback) {
                @this.
                getResources().then((response) => {
                    successCallback(response);
                })
            },
            //イベント取得(月が切り替わる度に更新)
            events: function (info, successCallback) {
                @this.
                getEvents(info.start, info.end).then((response) => {
                    successCallback(response);
                })
            },
        });
        calendar.render();
        window.addEventListener('refreshCalendar', event => {
            calendar.refetchResources();
            calendar.refetchEvents();
        });
    });
</script>
@endpush

