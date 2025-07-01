<?php
include_once '../Model/tables.php'; 
require_once '../db.php';
$tables = getAllTables(); // fetch data
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Tables</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
</head>
<body>
<div class="admin-container">
  <?php require 'partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="top-header">
      <h1>Manage Tables</h1>
    </header>


 <!-- Add Table Form -->
<section class="data-section">
  <div class="section-header">
    <h2>Add New Table</h2>
  </div>
  <form class="form-inline" action="/TKCafe/Controller/tablesController.php" method="POST">
    <input type="text" name="table_name" placeholder="Table name" required class="input-field">
    <input type="number" name="seats" placeholder="Seats" required class="input-field" min="1">
    <select name="status" class="input-field">
      <option value="available">Available</option>
      <option value="unavailable">Unavailable</option>
    </select>
    <button type="submit" name="add_table" class="btn btn-primary">Add Table</button>
  </form>
</section>

   <!-- Table List -->
<section class="data-section">
  <div class="section-header">
    <h2>Table List</h2>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Table Name</th>
          <th>Seat</th> <!-- NEW COLUMN -->
          <th>Status</th>
          <th>QR Code</th>
          <th>Action</th>
        </tr>
      </thead>
     <tbody>
  <?php if (empty($tables)): ?>
    <tr>
      <td colspan="6">No tables found.</td>
    </tr>
  <?php else: ?>
    <?php 
      $counter = 1; // ADD THIS
      foreach ($tables as $table): 
    ?>
      <tr>
        <td><?= $counter++ ?></td> <!-- CHANGE this line from $table['id'] to counter -->
        <td><?= htmlspecialchars($table['table_name']) ?></td>
        <td><?= htmlspecialchars($table['seats']) ?></td>
        <td>
          <?php if ($table['status'] === 'available'): ?>
            <span class="badge badge-success">Available</span>
          <?php else: ?>
            <span class="badge badge-danger">Unavailable</span>
          <?php endif; ?>
        </td>
        <td>
          <img src="/TKCafe/public/img/qrcode<?= $table['id'] ?>.png" width="50" alt="QR">
        </td>
        <td>
          <button class="btn btn-sm btn-primary edit-btn" data-id="<?= $table['id'] ?>">Edit</button>
          <form action="/TKCafe/Controller/tablesController.php" method="POST" style="display:inline;">
            <input type="hidden" name="delete_table_id" value="<?= $table['id'] ?>">
            <button type="submit" name="delete_table" class="btn btn-sm btn-danger"
              onclick="return confirm('Are you sure you want to delete this table?');">
              Delete
            </button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</tbody>


<!-- Overlay and Popup (Optional Interface Preview for Modal Style) -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

<div id="popup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
background:#fff; padding:20px; border:1px solid #ccc; z-index:1000; max-width:700px;">
</div>

<script src="/TKCafe/public/js/tables.js"></script>

