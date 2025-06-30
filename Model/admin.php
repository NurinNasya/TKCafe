<?php
class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Get admin by username
    /*public function getAdminByUsername($username) {
        $query = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Verify admin login
    public function verifyAdmin($username, $password) {
        $admin = $this->getAdminByUsername($username);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }*/
}
?>