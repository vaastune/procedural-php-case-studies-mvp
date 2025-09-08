<?php
$names = json_decode(file_get_contents('students.json'), true);
$cases = json_decode(file_get_contents('case_studies.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $name = $_GET['name'];
  // find existing text
  $caseText = '';
  foreach ($cases as $c) {
    if ($c['name'] === $name) {
      $caseText = $c['case_study'];
      break;
    }
  }
}
else {
  // save POST
  $name     = $_POST['name'];
  $newText  = $_POST['case_study'];
  $found = false;

  // update or append
  foreach ($cases as &$c) {
    if ($c['name'] === $name) {
      $c['case_study'] = $newText;
      $found = true;
      break;
    }
  }
  if (! $found) {
    $cases[] = ['name' => $name, 'case_study' => $newText];
  }

  file_put_contents('case_studies.json', json_encode($cases, JSON_PRETTY_PRINT));
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add/Edit Case Study</title>
</head>
<body>
  <h2>Add/Edit Case Study for “<?= htmlspecialchars($name) ?>”</h2>
  <form method="post">
    <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
    <textarea name="case_study" rows="6" cols="50" required><?= htmlspecialchars($caseText) ?></textarea><br><br>
    <button type="submit">Save</button>
    <a href="index.php">Cancel</a>
  </form>
</body>
</html>