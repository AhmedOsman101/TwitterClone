<?php

$a = [
  "a" => "hello",
  "b" => "world"
];

$b = [
  "a" => "hello",
  "b" => "world"
];

var_export($a === $b);
echo "\n";
var_export($a == $b);
