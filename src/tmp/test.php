<?php

$text = [];
//メモを作成
function create() 
{
  echo 'タイトルを入力してください' . PHP_EOL . ':';
  $title = trim(fgets(STDIN));
  echo '内容を入力してください' . PHP_EOL . ':';
  $contents = trim(fgets(STDIN));
  echo '登録しました';
  $date = date("Y/m/d H:i:s");

  
  return [
    'title' => $title,
    'contents' => $contents,
    'date' => $date
  ];
};
//メモを表示
function listUp($text) 
{
  foreach ($text as $info) 
  {
    echo 'メモを表示します' . PHP_EOL;
    echo 'タイトル'. PHP_EOL . $info['title'] . PHP_EOL;
    echo '作成日' . PHP_EOL . $info['date'] . PHP_EOL;
    echo '内容' . PHP_EOL . $info['contents'] . PHP_EOL;
    echo '-------------' . PHP_EOL;
  };
};
//システムをループさせるための処理
while(true)
  {
    echo 'メニューを選択してください' . PHP_EOL;
    echo '1: メモを作成' . PHP_EOL;
    echo '2: メモを表示' . PHP_EOL;
    echo '9: アプリケーションを終了' . PHP_EOL;
    $selectNum = trim(fgets(STDIN));
    if ($selectNum === '1') {
      $text[] = create();
    } elseif ($selectNum === '2'){
      listUp($text);
    } elseif ($selectNum  === '9') {
      break;
    }
  }






// $numbers = [1, 2, 3, 4, 5];

// foreach ($numbers as $number) {
//   echo $number * 2 . PHP_EOL;
// }

// $currencies = [
//   'japan' => 'yen',
//   'us' => 'dollar',
//   'england' => 'pound'
// ];

// foreach ($currencies as $country => $currency) {
//   echo $country . ':' . $currency . PHP_EOL;
// }

// function multiplay($a, $b) {
//    $score = $a * $b;
//    return $score;
// };

// echo $score = multiplay(3, 5).PHP_EOL;