<?php

$link = mysqli_connect('db', 'book_log', 'pass' , 'book_log');

if (!$link) {
    echo 'Error: データベースに接続できませんでした' . PHP_EOL;
    echo 'debugging error:' . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo 'データベースに接続できました' . PHP_EOL;

$sql = <<<EOT
INSERT INTO reviews (
    bookname,
    author
) VALUES (
    'hoi',
)
EOT;

$result = mysqli_query($link, $sql);

if ($result) {
    echo 'データが追加されました' . PHP_EOL;
} else {
    echo 'データの追加に失敗しました Error:' . mysqli_error($link) . PHP_EOL;
}

mysqli_close($link);
echo 'データベースとの接続を切断しました';