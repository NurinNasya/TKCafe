function printQR(imgId) {
  const img = document.getElementById(imgId).src;
  const printWindow = window.open('', '_blank');

  printWindow.document.write(`
    <html>
      <head>
        <title>Print QR</title>
        <style>
          body { text-align: center; padding: 40px; font-family: sans-serif; }
        </style>
      </head>
      <body>
        <h2>QR Code for Table</h2>
        <img src="${img}" style="width: 200px;"><br><br>
        <script>window.onload = () => window.print();<\/script>
      </body>
    </html>
  `);

  printWindow.document.close();
}
