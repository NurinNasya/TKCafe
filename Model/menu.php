<?php
class Menu {
    private $menuItems = [
 // Standard items
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

        // Signature items (your dummy data)
        4 => [
            'name' => 'Nasi Lemak Sambal Udang',
            'description' => 'Nasi Lemak + Sambal Udang',
            'price' => 'RM15.00',
            'image' => '/TKCafe/public/images/NASI LEMAK SAMBAL UDANG.jpg',
            'category' => 'signature'
        ],
        5 => [
            'name' => 'Nasi Minyak Ayam Merah',
            'description' => 'Nasi Minyak + Ayam Masak Merah + Acar',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI MINYAK AYAM MERAH.jpg',
            'category' => 'signature'
        ],
        6 => [
            'name' => 'Nasi Ayam',
            'description' => 'Nasi + Ayam + Sup + Sambal',
            'price' => 'RM10.00',
            'image' => '/TKCafe/public/images/NASI AYAM.png',
            'category' => 'signature'
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