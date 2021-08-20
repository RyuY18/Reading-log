<?php

//データベースとの接続
function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
//データベースに接続できなかった際のエラー処理
    if (!$link) {
        echo 'データベースに接続できません' . PHP_EOL;
        echo 'Error:'. mysqli_connect_error() . PHP_EOL;
        exit;
    }
    echo 'データベースに接続しました' . PHP_EOL;
    return $link;
}
//データベースに登録できなかった際のエラー処理
function dbError($a) 
{
    if ($a) {
        echo 'データベースに登録しました' . PHP_EOL;
    } else {
        echo 'データベースに登録できませんでした Error';
    }
}
//読書ログを登録
function createLog()
{
    echo '読書ログを登録してください', PHP_EOL;
    echo '書籍名:';
    $title = trim(fgets(STDIN)) . PHP_EOL;
    echo '著者名:';
    $AuthorName = trim(fgets(STDIN)) . PHP_EOL;
    echo '読書状況（未読,読んでる,読了）';
    $select = trim(fgets(STDIN)) . PHP_EOL;
    echo '評価（5点満点の整数）:';
    $evaluation = trim(fgets(STDIN)) . PHP_EOL;
    echo '感想:';
    $thoughts = trim(fgets(STDIN)) . PHP_EOL;

    echo '読書ログを登録しました。' . PHP_EOL . PHP_EOL;


//ログをデータベースに登録する処理
    return $sql = <<<EOT
    INSERT INTO reviews (
            bookname,
            author,
            status,
            evaluation,
            houghts
    ) VALUES (
        '$title',
        '$AuthorName',
        '$select',
        $evaluation,
        '$thoughts'
    )
    EOT;
}

function logDisplay($books)
{
//読書ログを表示
    foreach ($books as $bookinfo) {
        echo '読書ログを表示します' . PHP_EOL;
        echo "書籍名:" . $bookinfo['title'] . PHP_EOL;
        echo "著者名:" . $bookinfo['AuthorName'] . PHP_EOL;
        echo "読書状況:" . $bookinfo['select'] . PHP_EOL;
        echo "評価:" . $bookinfo['evaluation'] . PHP_EOL;
        echo "感想:" . $bookinfo['thoughts'] . PHP_EOL;
        echo '-------------' . PHP_EOL;
    };
};

$link = dbConnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください (1,2,9):';
    $num = trim(fgets(STDIN));
    if ($num === '1') {
        createLog();
        $sql = createLog();
        $result = mysqli_query($link,$sql);
        dbError($result);
        mysqli_error($link) . PHP_EOL;
        exit;
    } elseif ($num === '2') {
        logDisplay($books);
    } elseif ($num === '9') {
        break;
    }

//データベースの切断処理
mysqli_close($link);
}

