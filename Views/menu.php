<?php
// If you want, you can simulate some data here later, but for now it's just header/footer
?>

<?php require 'partials/header.php'; ?>
<?php require 'partials/categorybar.php'; ?>

<!-- Menu items container -->
<div class="menu-items">

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI DAGANG TERENGGANU.png" alt="Nasi Dagang Terengganu" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengannu</h3>
        <p>Nasi Dagang + Gulai Ikan + Acar</p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="1">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png" alt="Nasi Lemak Rendang Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Rendang Ayam</h3>
        <p>Nasi Lemak + Rendang Ayam</p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="2">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg" alt="Nasi Minyak Gulai Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam</h3>
        <p>Nasi Minyak + Gulai Ayam</p>
        <div class="menu-item-price">RM9.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="3">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang</h3>
        <p>Nasi Lemak + Sambal Udang</p>
        <div class="menu-item-price">RM15.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="4">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah</h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar</p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="5">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Ayam</h3>
        <p>Nasi + Ayam + Sup + Sambal</p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="6">Select</button>
      </div>
    </div>
  </div>

    <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="NASI DAGANG TERENGGANU + SOFT DRINKS" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengganu+ Soft Drink</h3>
        <p>Nasi Dagang + Gulai Ikan + Acar</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png" alt="Nasi Lemak Rendang Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Rendang Ayam + Soft Drink</h3>
        <p>Nasi Lemak + Rendang Ayam</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="2">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg" alt="Nasi Minyak Gulai Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam + Soft Drink</h3>
        <p>Nasi Minyak + Gulai Ayam</p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="3">Select</button>
      </div>
    </div>
  </div>

 <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang + Soft Drink</h3>
        <p>Nasi Lemak + Sambal Udang</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah + Soft Drink</h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar</p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Ayam + Soft Drink</h3>
        <p>Nasi + Ayam + Sup + Sambal</p>
        <div class="menu-item-price">RM11.50</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

   <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Ayam </h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Udang </h3>
        <p></p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Mee Goreng Mamak</h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Kuey Tiaw Goreng </h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Putih + Tomyam Ayam + Sambal Belacan</h3>
        <p></p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>



     <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Telur Dadar</h3>
        <p></p>
        <div class="menu-item-price">RM2.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Telur Mata</h3>
        <p></p>
        <div class="menu-item-price">RM1.50</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Fried Chicken</h3>
        <p></p>
        <div class="menu-item-price">RM5.50</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

    <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sosej Otak- Otak(6 PCS)/h3>
        <p></p>
        <div class="menu-item-price">RM5.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>



     <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sosej Pulut(1 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM3.50</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Kek Ayam (1 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM3.50</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="beverages">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Ice Lemon Tea</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="beverages">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Tea Ping </h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn">Select</button>
      </div>
    </div>
  </div>



















<?php require 'partials/footer.php'; ?>

<script src="/TKCafe/public/js/menu.js"></script>


