<?php
// Load your premade names

$names = json_decode(file_get_contents('students.json'), true);
// Flatten if nested (array with one array inside)
if (is_array($names) && count($names) === 1 && is_array($names[0])) {
  $names = $names[0];
}

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
  <style>
    body {
      background: linear-gradient(135deg, #ffe0ec 0%, #ffe5d9 100%);
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', 'Arial', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    h2 {
      color: #e29578;
      margin-bottom: 24px;
      text-align: center;
      font-size: 2.2em;
      letter-spacing: 1px;
    }
    table {
      background: #fff0f6cc;
      border-radius: 18px;
      box-shadow: 0 4px 24px #ffd6e0cc;
      border: none;
      margin: 0 auto;
      text-align: center;
      font-size: 1.1em;
      overflow: hidden;
    }
    th, td {
      padding: 14px 18px;
      border: none;
    }
    th {
      background: #ffd6e0;
      color: #b5838d;
      font-weight: 600;
    }
    tr:nth-child(even) {
      background: #fff5f8;
    }
    tr:nth-child(odd) {
      background: #fff0f6;
    }
    a {
      color: #e29578;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }
    a:hover {
      color: #b5838d;
      text-decoration: underline;
    }
    td:last-child {
      min-width: 120px;
    }
  </style>
</head>
</body>
  <h2>Student Case Studies</h2>
  <table>
    <tr>
      <th>#</th><th>Name</th><th>Case Study</th><th>Actions</th>
    </tr>
    <?php foreach ($names as $i => $name): ?>
      <?php
        // Build student name from firstname and lastname if available
        if (is_array($name) && isset($name['firstname'], $name['lastname'])) {
          $studentName = trim($name['firstname'] . ' ' . $name['lastname']);
        } elseif (is_array($name) && isset($name['name'])) {
          $studentName = $name['name'];
        } else {
          $studentName = $name;
        }
        $text = $casesByName[$studentName] ?? '';
      ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($studentName) ?></td>
        <td><?= nl2br(htmlspecialchars($text)) ?></td>
        <td>
          <a href="edit.php?name=<?= urlencode($studentName) ?>">✏️ Add/Edit</a> |
          <a href="delete.php?name=<?= urlencode($studentName) ?>"
             onclick="return confirm('Remove <?= htmlspecialchars($studentName) ?> and their case study?')">
            🗑️ Remove
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>