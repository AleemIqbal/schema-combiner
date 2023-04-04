<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Combine JSON-LD Schemas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 20px;
    }
    textarea {
      resize: none;
    }
  </style>
<script>
function copyToClipboard(text) {
  const el = document.createElement('textarea');
  el.innerHTML = text;
  document.body.appendChild(el);
  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);
}
</script>
</head>
<body>
  <div class="container">
    <h1 class="mb-4">Combine JSON-LD Schemas</h1>
    <form action="combined-fixer.php" method="POST">
      <div class="mb-3">
        <label for="schemas" class="form-label">JSON-LD Schemas:</label>
        <textarea class="form-control" id="schemas" name="schemas" rows="12" placeholder="Paste both JSON-LD schemas separated by a comma" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Combine Schemas</button>
    </form>
    
    <?php
    function jsonToHtmlAttribute($json) {
      $jsonString = json_encode($json, JSON_HEX_APOS | JSON_HEX_QUOT);
      return substr($jsonString, 1, -1);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $input = '[' . $_POST['schemas'] . ']';
      $schemas = json_decode($input, true);

      if (json_last_error() === JSON_ERROR_NONE) {
        $combinedSchema = [
          "@context" => "https://schema.org",
          "@graph" => $schemas,
        ];
        $combinedJson = json_encode($combinedSchema, JSON_PRETTY_PRINT);
        echo '<div class="mt-5">';
        echo '<h2>Combined JSON-LD Schema:</h2>';
        echo '<button class="btn btn-secondary mb-2" onclick="copyToClipboard(\'' . jsonToHtmlAttribute($combinedJson) . '\')">Copy to Clipboard</button>';
        echo '<pre class="border rounded p-3 bg-light">' . htmlspecialchars($combinedJson) . '</pre>';
        echo '</div>';
      } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Invalid JSON input. Please check your JSON-LD schemas.</div>';
      }
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>