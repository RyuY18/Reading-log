<?php

$S = rtrim(fgets(STDIN));

$num = mb_strlen($S);

function i($num)
{
  for($n = 0;$num > $n; $n++){
    echo "+";
  }
}

i($num);
echo '++';
echo "\n";

echo "+" . $S . "+";
echo "\n";
i($num);
echo '++';