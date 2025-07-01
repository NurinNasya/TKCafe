<?php
require_once '../Model/tables.php';

if (!isset($_GET['id'])) {
  echo "Table ID not provided.";
  exit;
}

$table = getTableById($_GET['id']);
if (!$table) {
  echo "Table not found.";
  exit;
}
?>

<form class="form-vertical" action="/TKCafe/Controller/tablesController.php" method="POST">
  <input type="hidden" name="id" value="<?= $table['id'] ?>">

  <label for="table_name">Table Name</label>
  <input type="text" id="table_name" name="table_name" value="<?= htmlspecialchars($table['table_name']) ?>" required class="input-field">

  <label for="seats">Seats</label>
  <input type="number" id="seats" name="seats" value="<?= $table['seats'] ?>" required class="input-field" min="1">

  <label for="status">Status</label>
  <select id="status" name="status" class="input-field">
    <option value="available" <?= $table['status'] === 'available' ? 'selected' : '' ?>>Available</option>
    <option value="unavailable" <?= $table['status'] === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
  </select>

  <button type="submit" name="update_table" class="btn btn-primary" style="margin-top: 1rem;">Update Table</button>
</form>
