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
            'description' => 'Nasi Minyak + Gulai Ayam',
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
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM.jpg',
            'category' => 'standard'
        ],
        10 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GUALI BERIANI.png',
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
            'description' => 'Nasi Minyak + Gulai Ayam',
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
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM.jpg',
            'category' => 'signature'
        ],
        18 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM13.50',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GUALI BERIANI.png',
            'category' => 'signature'
        ],

         // Standard items (combo)
        19 => [
            'name' => 'Nasi Dagang Terengganu',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'set-standard'
        ],
        20 => [
            'name' => 'Nasi Lemak Rendang Ayam',
            'description' => 'Nasi Lemak + Rendang Ayam',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'set-standard'
        ],
        21 => [
            'name' => 'Nasi Minyak Gulai Ayam',
            'description' => 'Nasi Minyak + Gulai Ayam',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'set-standard'
        ],
        
        22 => [
            'name' => 'Nasi Minyak Ayam Merah',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'set-standard'
        ],
        23 => [
            'name' => 'Nasi Goreng Kampung',
            'description' => 'Nasi Goreng Kampung',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/NASI GORENG KAMPUNG.jpg',
            'category' => 'set-standard'
        ],
        24 => [
            'name' => 'Nasi Lemak Sambal Udang',
            'description' => 'Nasi Lemak + Sambal Udang',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'set-standard'
        ],
        25 => [
            'name' => 'Bihun Goreng Singapura',
            'description' => 'Bihun Goreng Singapura',
            'price' => 'RM11.00',
            'image' => '/TKCafe/public/images/BIHUN GORENG SINGAPURA.png',
            'category' => 'set-standard'
        ],
        26 => [
            'name' => 'Nasi Ayam',
            'description' => 'Nasi + Ayam + Sup + Sambal',
            'price' => 'RM11.50',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'set-standard'
        ],
        27 => [
            'name' => 'Nasi Tomato Kuzi Ayam',
            'description' => 'Nasi Tomato + Kuzi Ayam',
            'price' => 'RM13.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM.jpg',
            'category' => 'set-standard'
        ],
        28 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GUALI BERIANI.png',
            'category' => 'set-standard'
        ],

            // Signature items (combo)
        29 => [
            'name' => 'Nasi Dagang Terengganu',
            'description' => 'Nasi Dagang + Gulai Ikan + Acar',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI DAGANG TERENGGANU.png',
            'category' => 'set-signature'
        ],
        30 => [
            'name' => 'Nasi Lemak Rendang Ayam',
            'description' => 'Nasi Lemak + Rendang Ayam',
            'price' => 'RM15.50',
            'image' => '/TKCafe/public/images/NASI LEMAK RENDANG AYAM.png',
            'category' => 'set-signature'
        ],
        31 => [
            'name' => 'Nasi Minyak Gulai Ayam',
            'description' => 'Nasi Minyak + Gulai Ayam',
            'price' => 'RM14.00',
            'image' => '/TKCafe/public/images/NASI MINYAK GULAI AYAM.jpg',
            'category' => 'set-signature'
        ],
        32 => [
            'name' => 'Nasi Minyak Ayam Merah',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'set-signature'
        ],
        33 => [
            'name' => 'Nasi Lemak Sambal Udang',
            'description' => 'Nasi Lemak + Sambal Udang',
            'price' => 'RM18.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'set-signature'
        ],
        34 => [
            'name' => 'Nasi Ayam',
            'description' => 'Nasi + Ayam + Sup + Sambal',
            'price' => 'RM13.00',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'set-signature'
        ],
        35 => [
            'name' => 'Nasi Tomato Kuzi Ayam',
            'description' => 'Nasi Tomato + Kuzi Ayam',
            'price' => 'RM16.50',
            'image' => '/TKCafe/public/images/NASI TOMATO KUZI AYAM.jpg',
            'category' => 'set-signature'
        ],
        36 => [
            'name' => 'Nasi Beriani Ayam Gulai Beriani',
            'description' => 'Nasi Beriani + Ayam Gulai Beriani',
            'price' => 'RM16.50',
            'image' => '/TKCafe/public/images/NASI BERIANI AYAM GUALI BERIANI.png',
            'category' => 'set-signature'
        ],

             // masakan panas (alacarte)
        37 => [
            'name' => 'Nasi Goreng Ayam',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/NASI GORENG AYAM.png',
            'category' => 'set-signature'
        ],
        38 => [
            'name' => 'Nasi Goreng Udang',
            'description' => '',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI GORENG UDANG.png',
            'category' => 'set-signature'
        ],
        39 => [
            'name' => 'Mee goreng Mamak',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/MEE GORENG MAMAK.png',
            'category' => 'set-signature'
        ],
        40 => [
            'name' => 'Kuey Tiaw Goreng',
            'description' => '',
            'price' => 'RM8.00',
            'image' => '/TKCafe/public/images/KUEY TIAW GORENG.png',
            'category' => 'set-signature'
        ],
        41 => [
            'name' => 'Nasi Putih + Tomyam Ayam + Sambal Belacan',
            'description' => '',
            'price' => 'RM12.00',
            'image' => '/TKCafe/public/images/NASI PUTIH + TOMYAM AYAM + SAMBAL BELACAN.png',
            'category' => 'set-signature'
        ],

              // masakan panas (sidedish)
        42 => [
            'name' => 'Telur Dadar',
            'description' => '',
            'price' => 'RM2.00',
            'image' => '/TKCafe/public/images/TELUR DADAR.png',
            'category' => 'set-signature'
        ],
        43 => [
            'name' => 'Telur Mata',
            'description' => '',
            'price' => 'RM1.50',
            'image' => '/TKCafe/public/images/TELUR MATA.png',
            'category' => 'set-signature'
        ],
        44 => [
            'name' => 'Fried Chicken',
            'description' => '',
            'price' => 'RM5.50',
            'image' => '/TKCafe/public/images/FRIED CHICKEN.jpg',
            'category' => 'set-signature'
        ],

               // lokcing
        45 => [
            'name' => 'Sosej Otak-otakr',
            'description' => '',
            'price' => 'RM2.00',
            'image' => '/TKCafe/public/images/TELUR DADAR.png',
            'category' => 'set-signature'
        ],
        42 => [
            'name' => 'Telur Mata',
            'description' => '',
            'price' => 'RM1.50',
            'image' => '/TKCafe/public/images/TELUR MATA.png',
            'category' => 'set-signature'
        ],
        42 => [
            'name' => 'Fried Chicken',
            'description' => '',
            'price' => 'RM5.50',
            'image' => '/TKCafe/public/images/FRIED CHICKEN.jpg',
            'category' => 'set-signature'
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