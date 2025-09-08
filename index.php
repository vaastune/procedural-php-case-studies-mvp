<?php
// Load your premade names
$names = json_decode(file_get_contents('students.json'), true);

// Load existing case studies
$cases = json_decode(file_get_contents('case_studies.json'), true);

// Map case studies by student name for quick lookup
$casesByName = [];
foreach ($cases as $c) {
  $casesByName[$c['name']] = $c['case_study'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Student Case Studies</title>
</head>
<body>
  <h2>Student Case Studies</h2>
  <table border="1" cellpadding="5">
    <tr>
      <th>#</th><th>Name</th><th>Case Study</th><th>Actions</th>
    </tr>
    <?php foreach ($names as $i => $name): ?>
      <?php $text = $casesByName[$name] ?? ''; ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($name) ?></td>
        <td><?= nl2br(htmlspecialchars($text)) ?></td>
        <td>
          <a href="edit.php?name=<?= urlencode($name) ?>">✏️ Add/Edit</a> |
          <a href="delete.php?name=<?= urlencode($name) ?>"
             onclick="return confirm('Remove <?= htmlspecialchars($name) ?> and their case study?')">
            🗑️ Remove
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>