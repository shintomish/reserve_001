<script>
    // テストとしてイベントを３つ作成してみる

    $data = [];

    $ev1 = ['id'=>'1','teacher_id'=>'18','title'=>'event1','start'=>'2020-03-17T10:00:00','color'=>'lightpink'];
    $ev2 = ['id'=>'2','teacher_id'=>'20','title'=>'event2','start'=>'2020-03-18T10:30:00','color'=>'lightgreen'];
    $ev3 = ['id'=>'3','teacher_id'=>'35','title'=>'event3','start'=>'2020-03-18T10:50:00','color'=>'yellow'];

    array_push($data,$ev1,$ev2,$ev3);

    echo json_encode($data);

    // infoはコールバック時に渡されるオブジェクト

    // アクセス
    info.event.extendedProps.teacher_id
    // 値変更
    info.event.setExtendedProp('teacher_id',40);

</script>