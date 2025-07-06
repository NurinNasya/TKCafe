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


 
<!-- Table List with Add Button at Top-Right -->
<section class="data-section">
  <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Table List</h2>
    <button class="btn btn-primary" onclick="openAddForm()">+ Add Table</button>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Table Name</th>
          <th>Seat</th>
          <th>Status</th>
          <th>QR Code</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($tables)): ?>
          <tr><td colspan="6">No tables found.</td></tr>
        <?php else: ?>
          <?php $counter = 1; foreach ($tables as $table): ?>
            <tr>
              <td><?= $counter++ ?></td>
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
            <img src="/TKCafe/public/QR/table_<?= $table['id'] ?>.png" width="50" alt="QR">
             <!-- Download Button -->
           <a href="/TKCafe/public/QR/table_<?= $table['id'] ?>.png" download="table_<?= $table['id'] ?>.png" class="btn btn-sm">Download</a>

          <!-- Print Button -->
          <button onclick="printQR('table_<?= $table['id'] ?>')" class="btn btn-sm">Print</button>

         <!-- Hidden QR image for printing -->
         <img id="table_<?= $table['id'] ?>" src="/TKCafe/public/QR/table_<?= $table['id'] ?>.png" style="display: none;">
         <br>
        <small><?= htmlspecialchars($table['table_name']) ?></small>
</td>
            </td>
              <td>
                <button class="btn btn-sm btn-primary edit-btn" data-id="<?= $table['id'] ?>">Edit</button>
                <form action="/TKCafe/Controller/tablesController.php" method="POST" style="display:inline;">
                  <input type="hidden" name="delete_table_id" value="<?= $table['id'] ?>">
                  <button type="submit" name="delete_table" class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this table?');">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

<!-- Overlay and Popup (Optional Interface Preview for Modal Style) -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

<div id="popup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
background:#fff; padding:20px; border:1px solid #ccc; z-index:1000; max-width:700px;">
  <h3>Add New Table</h3>
  <form class="form-inline" action="/TKCafe/Controller/tablesController.php" method="POST">
    <input type="text" name="table_name" placeholder="Table name" required class="input-field">
    <input type="number" name="seats" placeholder="Seats" required class="input-field" min="1">
    <select name="status" class="input-field">
      <option value="available">Available</option>
      <option value="unavailable">Unavailable</option>
    </select>
    <div style="margin-top: 10px;">
      <button type="submit" name="add_table" class="btn btn-primary">Add Table</button>
      <button type="button" class="btn btn-secondary" onclick="closeAddForm()">Cancel</button>
    </div>
  </form>
</div>

<script src="/TKCafe/public/js/tables.js"></script>

