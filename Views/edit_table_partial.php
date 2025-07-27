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
  
<h3>Update Table</h3>
<form class="form-vertical" action="/TKCafe/Controller/tablesController.php" method="POST">
 <input type="hidden" name="id" value="<?= $table['id'] ?>">
<input type="text" name="table_name" value="<?= htmlspecialchars($table['table_name']) ?>" placeholder="Table name" required class="input-field">
<input type="number" name="seats" value="<?= htmlspecialchars($table['seats']) ?>" placeholder="Seats" required class="input-field" min="1">
<select name="status" class="input-field">
<option value="available"<?= $table['status'] == 'available' ? 'selected' : '' ?>>Available</option>
<option value="unavailable" <?= $table['status'] == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
  </select>
</select>

<div style="margin-top: 10px;">

   <button type="submit" name="update_table" class="btn btn-primary">Update</button>
  <button type="button" class="btn btn-secondary" onclick="closeAddForm()">Cancel</button>
</form>


