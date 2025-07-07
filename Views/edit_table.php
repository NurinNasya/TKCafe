<?php
// require_once '../Model/tables.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Table</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php require 'partials/sidebar.php'; ?>
  <main class="main-content">
    <header class="top-header">
  <h1>Edit Table</h1>
</header>

<section class="data-section">
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
</section>

</html>

