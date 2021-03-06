<?php
	
//バリデーション処理
function validate($review)
{
    $errors = [];

    //書籍名が正しく入力されているかチェック
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    };
    //評価が正しく入力されているかチェック
    if (!mb_strlen($review['evaluation'])){
        $errors['evaluation'] = '1~5までの数値を入力してください';
    } elseif ($review['evaluation'] < 1 || $review['evaluation'] > 5){
        $errors['evaluation'] = '1~5までの数値を入力してください';
    };
    //著者名のチェック
    if (!mb_strlen($review['AuthorName'])) {
        $errors['AuthorName'] = '著者名を入力してください';
    } elseif (mb_strlen($review['AuthorName']) > 100) {
        $errors['AuthorName'] = '著者名は100文字以内で入力してください';
    };
    //読書状況のチェック
    if (!mb_strlen($review['select'])) {
        $errors['select'] = '読書状況を入力してください';
    } elseif (mb_strlen($review['select']) > 100) {
        $errors['select'] = '読書状況は100文字以内で入力してください';
    };
    //感想のチェック
    if (!mb_strlen($review['thoughts'])) {
        $errors['thoughts'] = '感想を入力してください';
    } elseif (mb_strlen($review['thoughts']) > 1000) {
        $errors['thoughts'] = '感想は1000文字以内で入力してください';
    };
    return $errors;
}
//データベースとの接続
function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    //データベースに接続できなかった際のエラー処理
    if (!$link) {
        echo 'データベースに接続できません' . PHP_EOL;
        echo 'Error:' . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    return $link;
}

//読書ログを登録
function createLog($link)
{

    $review = [];

    echo '読書ログを登録してください', PHP_EOL;
    echo '書籍名:';
    $review['title'] = trim(fgets(STDIN));

    echo '著者名:';
    $review['AuthorName'] = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）';
    $review['select'] = trim(fgets(STDIN));

    echo '評価（1~5）:';
    $review['evaluation'] = (int) trim(fgets(STDIN));

    echo '感想:';
    $review['thoughts'] = trim(fgets(STDIN));


    //バリデーション
    $validated = validate($review);
    if  (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }
    

    //ログをデータベースに登録する処理
    $sql = <<<EOT
    INSERT INTO reviews (
            bookname,
            author,
            score,
            evaluation,
            houghts
    ) VALUES (
        "{$review['title']}",
        "{$review['AuthorName']}",
        "{$review['select']}",
        "{$review['evaluation']}",
        "{$review['thoughts']}"
    )
    EOT;
    

    $result = mysqli_query($link, $sql);

    //データベースに登録できなかった際のエラー処理
    if ($result) {
        echo 'データベースに登録しました' . PHP_EOL;
    } else {
        echo 'データベースに登録できませんでした Error';
    }
}


function logDisplay($link)
{
    $link;
    $sql = 'SELECT bookname, author, score, evaluation, houghts FROM reviews';
    $result = mysqli_query($link, $sql);
    //読書ログを表示
    while($book_log = mysqli_fetch_assoc($result)){
            echo '読書ログを表示します' . PHP_EOL;
            echo "書籍名:" . $book_log['bookname'] . PHP_EOL;
            echo "著者名:" . $book_log['author']  . PHP_EOL;
            echo "読書状況:" . $book_log['score']. PHP_EOL;
            echo "評価:" . $book_log['evaluation'] . PHP_EOL;
            echo "感想:" . $book_log['houghts'] . PHP_EOL;
            echo '-------------' . PHP_EOL;
    }
mysqli_free_result($result);
};

while (true) {
    $link = dbConnect();
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください (1,2,9):';
    $num = trim(fgets(STDIN));
    if ($num === '1') {
        createLog($link);
    } elseif ($num === '2') {
        logDisplay($link);
    } elseif ($num === '9') {
        mysqli_close($link);
        break;
    };

    //データベースの切断処理
    mysqli_close($link);
}
