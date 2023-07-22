<?php

class DefaultLang {
    public function __construct() {
        $array = array();
        $this->array = &$array;
        $array["index.welcome.main"] = "{server} Sunucusunun Cezalar Sayfasına Hoşgeldiniz.";
        $array["index.welcome.sub"] = "Bu sayfamızda yasaklıları, susturmaları, ve bu tür cezaların sürelerini vesaire öğrenebilir takip edebilirsiniz.";

        $array["title.index"] = 'Anasayfa';
        $array["title.bans"] = 'Yasaklamalar';
        $array["title.mutes"] = 'Susturmalar';
        $array["title.warnings"] = 'Uyarılar';
        $array["title.kicks"] = 'Atılmalar';
        $array["title.player-history"] = "{name} için son cezalar";
        $array["title.staff-history"] = "{name} tarafından son cezalar";


        $array["generic.ban"] = "Yasaklama";
        $array["generic.mute"] = "Susturma";
        $array["generic.warn"] = "Uyarı";
        $array["generic.kick"] = "Atılma";

        $array["generic.banned"] = "Yasaklayan";
        $array["generic.muted"] = "Susturan";
        $array["generic.warned"] = "Uyaran";
        $array["generic.kicked"] = "Atan";

        $array["generic.banned.by"] = $array["generic.banned"] . "";
        $array["generic.muted.by"] = $array["generic.muted"] . "";
        $array["generic.warned.by"] = $array["generic.warned"] . "";
        $array["generic.kicked.by"] = $array["generic.kicked"] . "";

        $array["generic.ipban"] = "IP " . $array["generic.ban"];
        $array["generic.ipmute"] = "IP " . $array["generic.mute"];

        $array["generic.permanent"] = "Kalıcı";
        $array["generic.permanent.ban"] = $array['generic.permanent'] . ' ' . $array["generic.ban"];
        $array["generic.permanent.mute"] = $array['generic.permanent'] . ' ' . $array["generic.mute"];

        $array["generic.type"] = "Tür";
        $array["generic.active"] = "Aktif";
        $array["generic.inactive"] = "Aktif Değil";
        $array["generic.expired"] = "Süresi Bitti";
        $array["generic.player-name"] = "Oyuncu";

        $array["page.expired.ban"] = '(Unbanned)';
        $array["page.expired.ban-by"] = '({name} tarafından Yasaklaması kaldırıldı)';
        $array["page.expired.mute"] = '(Unmuted)';
        $array["page.expired.mute-by"] = '({name} tarafından Susturması kaldırıldı)';
        $array["page.expired.warning"] = '(' . $array["generic.expired"] . ')';

        $array["table.player"] = $array["generic.player-name"];
        $array["table.type"] = $array["generic.type"];
        $array["table.executor"] = "Yetkili";
        $array["table.reason"] = "Sebep";
        $array["table.date"] = "Tarih";
        $array["table.expires"] = "Ceza Bitiş Tarihi";
        $array["table.received-warning"] = "Alınan Uyarı";

        $array["table.server.name"] = "Sunucu";
        $array["table.server.scope"] = "Sunucu Kapsamı";
        $array["table.server.origin"] = "Son Bulunduğu Sunucu";
        $array["table.server.global"] = "Global";
        $array["table.pager.number"] = "Sayfa";

        $array["action.check"] = "ARA";
        $array["action.return"] = "Return to {origin}";

        $array["error.missing-args"] = "Eksik Argüman.";
        $array["error.name.unseen"] = "{name} daha önce girmemiş.";
        $array["error.name.invalid"] = "Geçersiz isim.";
        $array["history.error.uuid.no-result"] = "Hiç bir ceza bulunmadı.";
        $array["info.error.id.no-result"] = "Hata: {type} veritabanında bulunamadı.";
    }
}
