<?php
$names = json_decode(file_get_contents('students.json'), true);
$cases = json_decode(file_get_contents('case_studies.json'), true);

$toRemove = $_GET['name'];

// filter out from both lists
$names = array_filter($names, fn($n) => $n !== $toRemove);
$cases = array_filter($cases, fn($c) => $c['name'] !== $toRemove);

// save back
file_put_contents('students.json', json_encode(array_values($names), JSON_PRETTY_PRINT));
file_put_contents('case_studies.json', json_encode(array_values($cases), JSON_PRETTY_PRINT));

header('Location: index.php');
exit;
?>