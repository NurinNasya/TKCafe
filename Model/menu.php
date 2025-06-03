<?php
class Menu {
    private $menuItems = [
 // Standard items (ala carte)
        1 => [
            'name' => 'Nasi Dagang Terengganu',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'standard'
        ],
        2 => [
            'name' => 'Nasi Lemak Rendang Ayam',
            'description' => 'Nasi Lemak + Rendang Ayam',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'standard'
        ],
        3 => [
            'name' => 'Nasi Minyak Gulai Ayam',
            'description' => 'Nasi Minyak + Gulai Ayam + Acar',
            'price' => 'RM9.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'standard'
        ],
        
        4 => [
            'name' => 'Nasi Minyak Ayam Merah',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar',
            'price' => 'RM9.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'standard'
        ],
        5 => [
            'name' => 'Nasi Goreng Kampung',
            'description' => 'Nasi Goreng Kampung',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/NASI GORENG KAMPUNG.jpg',
            'category' => 'standard'
        ],
        6 => [
            'name' => 'Nasi Lemak Sambal Udang',
            'description' => 'Nasi Lemak + Sambal Udang',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'standard'
        ],
        7 => [
            'name' => 'Bihun Goreng Singapura',
            'description' => 'Bihun Goreng Singapura',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/BIHUN GORENG SINGAPURA.png',
            'category' => 'standard'
        ],
        8 => [
            'name' => 'Nasi Ayam',
            'description' => 'Nasi + Ayam + Sup + Sambal',
            'price' => 'RM8.50',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'standard'
        ],
        9 => [
            'name' => 'Nasi Tomato Kuzi Ayam',
            'description' => 'Nasi Tomato + Kuzi Ayam',
            'price' => 'RM10.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg',
            'category' => 'standard'
        ],
        10 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png',
            'category' => 'standard'
        ],

        // Signature items (ala carte)
        11 => [
            'name' => 'Nasi Dagang Terengganu',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'signature'
        ],
        12 => [
            'name' => 'Nasi Lemak Rendang Ayam',
            'description' => 'Nasi Lemak + Rendang Ayam',
            'price' => 'RM12.50',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'signature'
        ],
        13 => [
            'name' => 'Nasi Minyak Gulai Ayam',
            'description' => 'Nasi Minyak + Gulai Ayam + Acar ',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'signature'
        ],
        14 => [
            'name' => 'Nasi Minyak Ayam Merah',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'signature'
        ],
        15 => [
            'name' => 'Nasi Lemak Sambal Udang',
            'description' => 'Nasi Lemak + Sambal Udang',
            'price' => 'RM15.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'signature'
        ],
        16 => [
            'name' => 'Nasi Ayam',
            'description' => 'Nasi + Ayam + Sup + Sambal',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'signature'
        ],
        17 => [
            'name' => 'Nasi Tomato Kuzi Ayam',
            'description' => 'Nasi Tomato + Kuzi Ayam',
            'price' => 'RM13.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg',
            'category' => 'signature'
        ],
        18 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM13.50',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png',
            'category' => 'signature'
        ],

         // Standard items (combo)

        19 => [
            'name' => 'Nasi Dagang Terengganu + Soft Drink',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar + Soft Drink',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'set-standard'
        ],
        20 => [
            'name' => 'Nasi Lemak Rendang Ayam + Soft Drink',
            'description' => 'Nasi Lemak + Rendang Ayam + Soft Drink',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'set-standard'
        ],
        21 => [
            'name' => 'Nasi Minyak Gulai Ayam + Soft Drink',
            'description' => 'Nasi Minyak + Gulai Ayam + Soft Drink',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'set-standard'
        ],
        
        22 => [
            'name' => 'Nasi Minyak Ayam Merah + Soft Drink',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar + Soft Drink',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'set-standard'
        ],
        23 => [
            'name' => 'Nasi Goreng Kampung + Soft Drink',
            'description' => 'Nasi Goreng Kampung + Soft Drink',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI GORENG KAMPUNG.jpg',
            'category' => 'set-standard'
        ],
        24 => [
            'name' => 'Nasi Lemak Sambal Udang + Soft Drink',
            'description' => 'Nasi Lemak + Sambal Udang + Soft Drink',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'set-standard'
        ],
        25 => [
            'name' => 'Bihun Goreng Singapura + Soft Drink',
            'description' => 'Bihun Goreng Singapura + Soft Drink',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/BIHUN GORENG SINGAPURA.png',
            'category' => 'set-standard'
        ],
        26 => [
            'name' => 'Nasi Ayam + Soft Drink',
            'description' => 'Nasi + Ayam + Sup + Sambal + Soft Drink',
            'price' => 'RM11.50',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'set-standard'
        ],
        27 => [
            'name' => 'Nasi Tomato Kuzi Ayam + Soft Drink',
            'description' => 'Nasi Tomato + Kuzi Ayam + Soft Drink',
            'price' => 'RM13.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg',
            'category' => 'set-standard'
        ],
        28 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani + Soft Drink ',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani + Soft Drink',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png',
            'category' => 'set-standard'
        ],

            // Signature items (combo)
        29 => [
            'name' => 'Nasi Dagang Terengganu + Soft Drink',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar + Soft Drink',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'set-signature'
        ],
        30 => [
            'name' => 'Nasi Lemak Rendang Ayam + Soft Drink',
            'description' => 'Nasi Lemak + Rendang Ayam + Soft Drink',
            'price' => 'RM15.50',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'set-signature'
        ],
        31 => [
            'name' => 'Nasi Minyak Gulai Ayam + Soft Drink',
            'description' => 'Nasi Minyak + Gulai Ayam + Soft Drink',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'set-signature'
        ],
        32 => [
            'name' => 'Nasi Minyak Ayam Merah + Soft Drink',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar + Soft Drink',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'set-signature'
        ],
        33 => [
            'name' => 'Nasi Lemak Sambal Udang + Soft Drink',
            'description' => 'Nasi Lemak + Sambal Udang + Soft Drink',
            'price' => 'RM18.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'set-signature'
        ],
        34 => [
            'name' => 'Nasi Ayam + Soft Drink',
            'description' => 'Nasi + Ayam + Sup + Sambal + Soft Drink',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'set-signature'
        ],
        35 => [
            'name' => 'Nasi Tomato Kuzi Ayam + Soft Drink',
            'description' => 'Nasi Tomato + Kuzi Ayam + Soft Drink',
            'price' => 'RM16.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM (1).jpg',
            'category' => 'set-signature'
        ],
        36 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani + Soft Drink',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani + Soft Drink',
            'price' => 'RM16.50',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GULAI BERIANI.png',
            'category' => 'set-signature'
        ],

             // masakan panas (alacarte)
        37 => [
            'name' => 'Nasi Goreng Ayam',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/NASI GORENG AYAM.png',
            'category' => 'masakan-ala'
        ],
        38 => [
            'name' => 'Nasi Goreng Udang',
            'description' => '',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI GORENG UDANG.png',
            'category' => 'masakan-ala'
        ],
        39 => [
            'name' => 'Mee goreng Mamak',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/MEE GORENG MAMAK.png',
            'category' => 'masakan-ala'
        ],
        40 => [
            'name' => 'Kuey Tiaw Goreng',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/KUEY TIAW GORENG.png',
            'category' => 'masakan-ala'
        ],
        41 => [
            'name' => 'Nasi Putih + Tomyam Ayam + Sambal Belacan',
            'description' => '',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI PUTIH + TOMYAM AYAM + SAMBAL BELACAN.png',
            'category' => 'masakan-ala'
        ],

              // masakan panas (sidedish)
        42 => [
            'name' => 'Telur Dadar',
            'description' => '',
            'price' => 'RM2.00',
            'image' => '/TKCafe/public/images/TELUR DADAR.png',
            'category' => 'masakan-side'
        ],
        43 => [
            'name' => 'Telur Mata',
            'description' => '',
            'price' => 'RM1.50',
            'image' => '/TKCafe/public/images/TELUR MATA.png',
            'category' => 'masakan-side'
        ],
        44 => [
            'name' => 'Fried Chicken',
            'description' => '',
            'price' => 'RM5.50',
            'image' => '/TKCafe/public/images/FRIED CHICKEN.jpg',
            'category' => 'masakan-side'
        ],

        
        // lokcing

        45 => [
            'name' => 'Sosej Otak- Otak(6 PCS)',
            'description' => '',
            'price' => 'RM5.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'lokcing'
        ],
        46 => [
            'name' => 'Sosej Pulut(1 PCS)',
            'description' => '',
            'price' => 'RM3.50',
            'image' => '/TKCafe/public/images/SOSEJ PULUT (1 PCS).png',
            'category' => 'lokcing'
        ],
        47 => [
            'name' => 'Kek Ayam (1 PCS)',
            'description' => '',
            'price' => 'RM3.50',
            'image' => '/TKCafe/public/images/KEK AYAM (1 PCS).png',
            'category' => 'lokcing'
      ],
        48 => [
            'name' => 'Sosej Cheese (1 PCS)',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/SOSEJ CHEESE (1 PCS).png',
            'category' => 'lokcing'

            
        49 => [
            'name' => 'Nugget Tempura (6 PCS)',
            'description' => '',
            'price' => 'RM5.00',
            'image' => '/TKCafe/public/images/NUGGET TEMPURA (6 PCS).jpg',
            'category' => 'lokcing'


           //ALA CART WESTERN

        50 => [
            'name' => 'Cheesy Wedges',
            'description' => '',
            'price' => 'RM6.00',
            'image' => '/TKCafe/public/images/CHEESY WEDGES.png',
            'category' => 'western'


        51 => [
            'name' => 'Coleslaw (Regular)',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/COLESLAW (REGULAR).png',
            'category' => 'western'

        52 => [
            'name' => 'French Fries',
            'description' => '',
            'price' => 'RM5.00',
            'image' => '/TKCafe/public/images/FRENCH FRIES.png',
            'category' => 'western'   


          //BEVERANGE

        53 => [
            'name' => 'Ice Lemon Tea',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/ICE LEMON TEA.png',
            'category' => 'air-balang'   

        54 => [
            'name' => 'Tea Ping',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/TEA PING.png',
            'category' => 'air-balang'       


           //CARBONATE DRINK

        55 => [
            'name' => 'Coca Cola',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/COCA COLA.png',
            'category' => 'soft-drinks'    

        56 => [
            'name' => 'Sprite',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'soft-drinks'

        57 => [
            'name' => 'F&N Orange',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'soft-drinks' 

        58 => [
            'name' => 'F&N Zapple',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'soft-drinks' 
        
        59 => [
            'name' => 'F&N Strawberry',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'soft-drinks'

        60 => [
            'name' => 'F&N Soda',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/F&N SODA.png',
            'category' => 'soft-drinks'


          // HOT DRINKS
       
        61 => [
            'name' => 'Milo - 3 IN 1',
            'description' => '',
            'price' => 'RM4.00',
            'image' => '/TKCafe/public/images/MILO - 3 IN 1.png',
            'category' => 'hot-drinks'

        62 => [
            'name' => 'Tea ',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/TEA.png',
            'category' => 'hot-drinks'

        63 => [
            'name' => ' Tea O ',
            'description' => '',
            'price' => 'RM2.00',
            'image' => '/TKCafe/public/images/TEA O.png',
            'category' => 'hot-drinks'


        64 => [
            'name' => 'Coffee',
            'description' => '',
            'price' => 'RM3.00',
            'image' => '/TKCafe/public/images/COFFEE.png',
            'category' => 'hot-drinks'

        65 => [
            'name' => 'Coffee O',
            'description' => '',
            'price' => 'RM2.50',
            'image' => '/TKCafe/public/images/COFFEE O.png',
            'category' => 'hot-drinks'

        66 => [
            'name' => 'Mineral Water (500ML)',
            'description' => '',
            'price' => 'RM1.50',
            'image' => '/TKCafe/public/images/MINERAL WATER (500ML).png',
            'category' => 'hot-drinks'


        // BEST SELLER
        
        67 => [
            'name' => 'Laksa Penang',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/LAKSA PENANG.jpg',
            'category' => 'best-seller'

        68 => [
            'name' => 'Laksa Asia',
            'description' => '',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'best-seller'
        
        69 => [
            'name' => 'Keropok Tumis',
            'description' => '',
            'price' => 'RM5.00',
            'image' => '/TKCafe/public/images/',
            'category' => 'best-seller'


        ],
    ];

    // Get all menu items
    public function getAllItems() {
        return $this->menuItems;
    }

    // Get single item by ID
    public function getItemById($id) {
        if (isset($this->menuItems[$id])) {
            return $this->menuItems[$id];
        }
        return null;
    }

    // Get items by category (standard or signature)
    public function getItemsByCategory($category) {
        return array_filter($this->menuItems, function($item) use ($category) {
            return $item['category'] === $category;
        });
    }
}