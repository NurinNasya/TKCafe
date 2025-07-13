<?php
// If you want, you can simulate some data here later, but for now it's just header/footer
require_once '../db.php';            // ✅ Add this line FIRST
require_once '../Model/menu.php';
$conn = getConnection();
$menuItems = getAllMenuItems($conn);

?>
<?php require 'partials/header.php'; ?>
<?php require 'partials/categorybar.php'; ?>


<!-- Menu items container -->
<div class="menu-items">

     <!-- BEST SELLER -->
      <?php
$categoryOrder = [
  'best-seller',
  'standard',
  'signature',
  'set-standard',
  'set-signature',
  'masakan-ala',
  'masakan-side',
  'lokcing',
  'western',
  'air-balang',
  'soft-drinks',
  'hot-drinks'
];

if (!empty($menuItems)):
  foreach ($categoryOrder as $category):
    foreach ($menuItems as $item):
      if ($item['category'] === $category): ?>
        <div class="menu-item" data-category="<?= htmlspecialchars($item['category']) ?>">
          <img src="/TKCafe/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-item-img" />
          <div class="menu-item-info">
            <div>
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p><?= htmlspecialchars($item['description']) ?></p>
              <div class="menu-item-price">RM<?= number_format($item['price'], 2) ?></div>
            </div>
            <div>
              <button class="select-btn" data-id="<?= $item['id'] ?>">Select</button>
            </div>
          </div>
        </div>
<?php   endif;
    endforeach;
  endforeach;
else: ?>
  <p>No menu items found.</p>
<?php endif; ?>
</div>

<!-- <?php if (!empty($menuItems)): ?>
    <?php foreach ($menuItems as $item): ?>
      <div class="menu-item" data-category="<?= htmlspecialchars($item['category']) ?>">
      <img src="/TKCafe/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="menu-item-img" />
        <div class="menu-item-info">
          <div>
            <h3><?= htmlspecialchars($item['name']) ?></h3>
            <p><?= htmlspecialchars($item['description']) ?></p>
            <div class="menu-item-price">RM<?= number_format($item['price'], 2) ?></div>
          </div>
          <div>
            <button class="select-btn" data-id="<?= $item['id'] ?>">Select</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No menu items found.</p>
  <?php endif; ?>
</div> -->



   <!-- <div class="menu-item" data-category="best-seller">
    <img src="/TKCafe/public/images/LAKSA PENANG.jpg" alt="Laksa Penang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3> Laksa Penang </h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="67">Select</button>
      </div>
    </div>
  </div>


   <div class="menu-item" data-category="best-seller">
    <img src="/TKCafe/public/images/LAKSA ASIA.jpeg" alt="Laksa Asia" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Laksa Asia</h3>
        <p></p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="68">Select</button>
      </div>
    </div>
  </div>
  

  <div class="menu-item" data-category="best-seller">
    <img src="/TKCafe/public/images/KEROPOK TUMIS.jpeg" alt="Keropok Tumis" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Keropok Tumis</h3>
        <p></p>
        <div class="menu-item-price">RM5.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="69">Select</button>
      </div>
    </div>
  </div>
  

STANDARD MENU (ALA CARTE)


  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI DAGANG TERENGGANU.png" alt="Nasi Dagang Terengganu" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengganu</h3>
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
        <p>Nasi Minyak + Gulai Ayam + Acar</p>
        <div class="menu-item-price">RM9.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="3">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt="Nasi Minyak Ayam Merah " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah</h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar</p>
        <div class="menu-item-price">RM9.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="4">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI GORENG KAMPUNG.jpg" alt="Nasi Goreng Kampung" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Kampung</h3>
        <p>Nasi Goreng Kampung</p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="5">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang</h3>
        <p>Nasi Lemak + Sambal Udang </p>
        <div class="menu-item-price">RM10.00</div>
   
      </div>
      <div>
         <button class="select-btn" data-id="6">Select</button>
      </div>
    </div>
  </div>

<div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/BIHUN GORENG SINGAPURA.png" alt="Bihun Goreng Singapura " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Bihun Goreng Singapura </h3>
        <p>Bihun Goreng Singapura</p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="7">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Ayam</h3>
        <p>Nasi + Ayam + Sup + Sambal</p>
        <div class="menu-item-price">RM8.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="8">Select</button>
      </div>
    </div>
  </div>

<div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg" alt="Nasi Tomato Kuzi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Tomato Kuzi Ayam</h3>
        <p>Nasi Tomato + Kuzi Ayam </p>
        <div class="menu-item-price">RM10.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="9">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="standard">
    <img src="/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png" alt="Nasi Beriani Ayam Gulai Beriani" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Beriani Ayam Gulai Beriani  </h3>
        <p>Nasi Beriani + Ayam Gulai Beriani</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="10">Select</button>
      </div>
    </div>
  </div>

!-- SIGNATURE (ALA CART) MENU --

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI DAGANG TERENGGANU.png" alt="Nasi Dagang Terengganu" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengganu  </h3>
        <p>Nasi Dagang + Gulai Ikan + Acar</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="11">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png" alt=">Nasi Lemak Rendang Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Rendang Ayam</h3>
        <p>Nasi Lemak + Rendang Ayam</p>
        <div class="menu-item-price">RM12.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="12">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg" alt=">Nasi Minyak Gulai Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam</h3>
        <p>Nasi Minyak + Gulai Ayam + Acar</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="13">Select</button>
      </div>
    </div>
  </div>


  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt=">Nasi Minyak Ayam Merah" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah </h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar</p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="14">Select</button>
      </div>
    </div>
  </div>

   <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang</h3>
        <p>Nasi Lemak + Sambal Udang </p>
        <div class="menu-item-price">RM15.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="15">Select</button>
      </div>
    </div>
  </div>
 

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam " class="menu-item-img" />
   
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam</h3>
        <p>Nasi Minyak + Gulai Ayam + Acar</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="16">Select</button>
      </div>
    </div>
  </div>

<div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg" alt="Nasi Tomato Kuzi Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Tomato Kuzi Ayam</h3>
        <p>Nasi Tomato + Kuzi Ayam </p>
        <div class="menu-item-price">RM13.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="17">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="signature">
    <img src="/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png" alt="Nasi Beriani Ayam Gulai Beriani" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Beriani Ayam Gulai Beriani  </h3>
        <p>Nasi Beriani + Ayam Gulai Beriani</p>
        <div class="menu-item-price">RM13.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="18">Select</button>
      </div>
    </div>
  </div>

  -- SET STANDARD COMBO--

    <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI DAGANG TERENGGANU.png" alt=">Nasi Dagang Terengganu + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengganu + Soft Drink</h3>
        <p>Nasi Dagang + Gulai Ikan + Acar  + Soft Drink</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="19">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png" alt="Nasi Lemak Rendang + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Rendang Ayam + Soft Drink</h3>
        <p>Nasi Lemak + Rendang Ayam + Soft Drink</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="20">Select</button>
      </div>
    </div>
  </div>



  <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg" alt="Nasi Minyak Gulai Ayam+ Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam + Soft Drink</h3>
        <p>Nasi Minyak + Gulai Ayam + Soft Drink</p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="21">Select</button>
      </div>
    </div>
  </div>


 <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt=">Nasi Minyak Ayam Merah + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah + Soft Drink</h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar + Soft Drink</p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="22">Select</button>
      </div>
    </div>
  </div>

<div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI GORENG KAMPUNG.jpg" alt="Nasi Goreng Kampung + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Kampung  + Soft Drink</h3>
        <p>Nasi Goreng Kampung + Soft Drink</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="23">Select</button>
      </div>
    </div>
  </div>


 <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang + Soft Drink</h3>
        <p>Nasi Lemak + Sambal Udang  + Soft Drink</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="24">Select</button>
      </div>
    </div>
  </div>


<div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/BIHUN GORENG SINGAPURA.png" alt="Bihun Goreng Singapura + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Bihun Goreng Singapura  + Soft Drink </h3>
        <p>Bihun Goreng Singapura  + Soft Drink</p>
        <div class="menu-item-price">RM11.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="25">Select</button>
      </div>
    </div>
  </div>


<div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Ayam + Soft Drink</h3>
        <p>Nasi + Ayam + Sup + Sambal + Soft Drink</p>
        <div class="menu-item-price">RM11.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="26">Select</button>
      </div>
    </div>
  </div>


<div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg" alt="Nasi Tomato Kuzi Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Tomato Kuzi Ayam  + Soft Drink</h3>
        <p>Nasi Tomato + Kuzi Ayam  + Soft Drink</p>
        <div class="menu-item-price">RM13.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="27">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-standard">
    <img src="/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png" alt="Nasi Beriani Ayam Gulai Beriani + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Beriani Ayam Gulai Beriani  + Soft Drink </h3>
        <p>Nasi Beriani Ayam Gulai Beriani + Soft Drink</p>
        <div class="menu-item-price">RM14.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="28">Select</button>
      </div>
    </div>
  </div>

 -- SET SIGNATURE COMBO --

    <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI DAGANG TERENGGANU.png" alt="Nasi Dagang Terengganu + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Dagang Terengganu+ Soft Drink</h3>
        <p>Nasi Dagang + Gulai Ikan + Acar + Soft Drink</p>
        <div class="menu-item-price">RM14.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="29">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png" alt="Nasi Lemak Rendang Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Rendang Ayam + Soft Drink</h3>
        <p>Nasi Lemak + Rendang Ayam + Soft Drink</p>
        <div class="menu-item-price">RM15.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="30">Select</button>
      </div>
    </div>
  </div>


  <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg" alt="Nasi Minyak Gulai Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Gulai Ayam + Soft Drink</h3>
        <p>Nasi Minyak + Gulai Ayam + Soft Drink</p>
        <div class="menu-item-price">RM14.00</div>
      </div>
      <div>
         <button class="select-btn" data-id="31">Select</button>
      </div>
    </div>
  </div>


 <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg" alt=">Nasi Minyak Ayam Merah + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Minyak Ayam Merah + Soft Drink </h3>
        <p>Nasi Minyak + Ayam Masak Merah + Acar + Soft Drink</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="32">Select</button>
      </div>
    </div>
  </div>


 <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg" alt="Nasi Lemak Sambal Udang + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Lemak Sambal Udang + Soft Drink</h3>
        <p>Nasi Lemak + Sambal Udang  + Soft Drink</p>
        <div class="menu-item-price">RM18.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="33">Select</button>
      </div>
    </div>
  </div>



<div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI AYAM.png" alt="Nasi Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Ayam + Soft Drink</h3>
        <p>Nasi + Ayam + Sup + Sambal + Soft Drink</p>
        <div class="menu-item-price">RM13.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="34">Select</button>
      </div>
    </div>
  </div>


<div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg" alt="Nasi Tomato Kuzi Ayam + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Tomato Kuzi Ayam  + Soft Drink</h3>
        <p>Nasi Tomato + Kuzi Ayam  + Soft Drink </p>
        <div class="menu-item-price">RM16.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="35">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="set-signature">
    <img src="/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png" alt="Nasi Beriani Ayam Gulai Beriani + Soft Drink" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Beriani Ayam Gulai Beriani  + Soft Drink </h3>
        <p>Nasi Beriani Ayam Gulai Beriani + Soft Drink</p>
        <div class="menu-item-price">RM16.50</div>
      </div>
      <div>
         <button class="select-btn" data-id="36">Select</button>
      </div>
    </div>
  </div>

 MASAKAN PANAS-

   <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI GORENG AYAM.png" alt="Nasi Goreng Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Ayam </h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn"data-id="37">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI GORENG UDANG.png" alt="Nasi Goreng Udang" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Goreng Udang </h3>
        <p></p>
        <div class="menu-item-price">RM10.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="38">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/MEE GORENG MAMAK.png" alt="Mee Goreng Mamak" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Mee Goreng Mamak</h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="39">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/KUEY TIAW GORENG.png" alt="Kuey Tiaw Goreng" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Kuey Tiaw Goreng </h3>
        <p></p>
        <div class="menu-item-price">RM8.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="40">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-ala">
    <img src="/TKCafe/public/images/NASI PUTIH + TOMYAM AYAM + SAMBAL BELACAN.png" alt="Nasi Putih + Tomyam Ayam + Sambal Belacan" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nasi Putih + Tomyam Ayam + Sambal Belacan</h3>
        <p></p>
        <div class="menu-item-price">RM12.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="41">Select</button> 
      </div>
    </div>
  </div>

 SIDE DISH

     <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/TELUR DADAR.png" alt=">Telur Dadar" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Telur Dadar</h3>
        <p></p>
        <div class="menu-item-price">RM2.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="42">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/TELUR MATA.png" alt="Telur Mata" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Telur Mata</h3>
        <p></p>
        <div class="menu-item-price">RM1.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="43">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="masakan-side">
    <img src="/TKCafe/public/images/FRIED CHICKEN.jpg" alt="Fried Chicken" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Fried Chicken</h3>
        <p></p>
        <div class="menu-item-price">RM5.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="44">Select</button>
      </div>
    </div>
  </div>
  
 ALA CART LOKCING

    <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/SOSEJ OTAK OTAK.jpg" alt="Sosej Otak- Otak(6 PCS)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sosej Otak- Otak(6 PCS)<h3>
        <p></p>
        <div class="menu-item-price">RM5.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="45">Select</button>
      </div>
    </div>
  </div>

     <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/SOSEJ PULUT (1 PCS).png" alt="Sosej Pulut(1 PCS)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sosej Pulut(1 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM3.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="46">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/KEK AYAM (1 PCS).png" alt="Kek Ayam" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Kek Ayam (1 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM3.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="47">Select</button>
      </div>
    </div>
  </div>


  <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/SOSEJ CHEESE (1 PCS).png" alt="Sosej Cheese (1 PCS)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sosej Cheese (1 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="48">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="lokcing">
    <img src="/TKCafe/public/images/NUGGET TEMPURA (6 PCS).jpg" alt="Nugget Tempura (6PCS)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Nugget Tempura (6 PCS)</h3>
        <p></p>
        <div class="menu-item-price">RM5.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="49">Select</button>
      </div>
    </div>
  </div>



  ALA CART WESTERN

 <div class="menu-item" data-category="western">
    <img src="/TKCafe/public/images/CHEESY WEDGES.png" alt="Cheesy Wedges" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Cheesy Wedges</h3>
        <p></p>
        <div class="menu-item-price">RM6.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="50">Select</button>
      </div>
    </div>
  </div>


  <div class="menu-item" data-category="western">
    <img src="/TKCafe/public/images/COLESLAW (REGULAR).png" alt="Coleslaw (Regular)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Coleslaw (Regular)</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="51">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="western">
    <img src="/TKCafe/public/images/FRENCH FRIES.png" alt="French Fries" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>French Fries</h3>
        <p></p>
        <div class="menu-item-price">RM5.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="52">Select</button>
      </div>
    </div>
  </div>



  BEVERANGE

  <div class="menu-item" data-category="air-balang">
    <img src="/TKCafe/public/images/ICE LEMON TEA.png" alt="Ice Lemon Tea" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Ice Lemon Tea</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="53">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="air-balang">
    <img src="/TKCafe/public/images/TEA PING.png" alt="Tea Ping" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Tea Ping </h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="54">Select</button>
      </div>
    </div>
  </div>

   CARBONATE DRINK

<div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/COCA COLA.png" alt="Coca Cola" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Coca Cola</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="55">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/Sprite.png" alt="Sprite" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Sprite</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn"data-id="56">Select</button>
      </div>
    </div>
  </div>

   <div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/F&N ORANGE.jpeg" alt="F&N Orange" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3> F&N Orange</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="57">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/F&N ZAPPLE.jpg" alt="F&N Zapple" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>F&N Zapple</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="58">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/F&N STRAWBERRY.jpeg" alt="F&N Strawberry" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>F&N Strawberry</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="59">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="soft-drinks">
    <img src="/TKCafe/public/images/F&N SODA.png" alt="F&N Soda" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>F&N Soda</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="60">Select</button>
      </div>
    </div>
  </div>
  

 HOT DRINKS

<div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/MILO - 3 IN 1.png" alt="Milo - 3 IN 1 " class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Milo - 3 IN 1 </h3>
        <p></p>
        <div class="menu-item-price">RM4.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="61">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/TEA.png" alt="Tea" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3> Tea </h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="62">Select</button>
      </div>
    </div>
  </div>



   <div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/TEA O.png" alt="Tea O" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3> Tea O </h3>
        <p></p>
        <div class="menu-item-price">RM2.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="63">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/COFFEE.png" alt="Coffee" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Coffee</h3>
        <p></p>
        <div class="menu-item-price">RM3.00</div>
      </div>
      <div>
        <button class="select-btn" data-id="64">Select</button>
      </div>
    </div>
  </div>

   <div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/COFFEE O.png" alt="Coffee O" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Coffee O</h3>
        <p></p>
        <div class="menu-item-price">RM2.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="65">Select</button>
      </div>
    </div>
  </div>

  <div class="menu-item" data-category="hot-drinks">
    <img src="/TKCafe/public/images/MINERAL WATER (500ML).png" alt="Mineral Water (500ML)" class="menu-item-img" />
    <div class="menu-item-info">
      <div>
        <h3>Mineral Water (500ML)</h3>
        <p></p>
        <div class="menu-item-price">RM1.50</div>
      </div>
      <div>
        <button class="select-btn" data-id="66">Select</button>
      </div>
    </div>
  </div>

  <-- Add this right before the popup div -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

  <div id="popup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
  background:#fff; padding:20px; border:1px solid #ccc; z-index:1000; max-width:700px;">
</div>  

<?php require 'partials/footer.php'; ?>

<script src="/TKCafe/public/js/menu.js"></script>
<script src="/TKCafe/public/js/cart.js"></script>
<script src="/TKCafe/public/js/category.js"></script>