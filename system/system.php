<?php
// Yapılan diğer işlemler

class core {
    // Özellikler

    public function __construct() {
        // Yapılandırmalar ve oturum başlatma
        // error_reporting ve diğer işlemler
    }

    public function __destruct() {
        // unset($this) işlemi kaldırıldı, normalde kullanılmaz
    }

    private function create() {
        // config, sanitize, tool, seo ve bootstrap nesneleri oluşturuldu
    }
}

// core sınıfı örneği oluşturuldu
$core = new core();

// Diğer fonksiyonlar

// Veritabanı bağlantıları yapıldı
$db = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_candy_db;charset=utf8;", "candycra_site", "pw9ND4pZXY4o@!");
$kpanel = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_kpanel;charset=utf8;", "candycra_site", "pw9ND4pZXY4o@!");
$faction = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Faction;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$istatistikler = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Istatikler;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$lobi = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Lobi;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$oyunlar = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Oyunlar;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$puan = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Puan;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$skyblock = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_SkyBlock;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$skypvp = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_SkyPvP;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$yetkiler = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_Yetkiler;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");
$bungeecord = new PDO("mysql:host=87.248.157.101;port=3306;dbname=candycra_BungeeCord;charset=utf8;", "candycra_server", "GhzeR8aqX8yu#!");

$domain = 'https://www.candycraft.net/';
$domain2 = 'https://www.candycraft.net/';
?>
