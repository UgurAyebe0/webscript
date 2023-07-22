<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">Admin</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;Türkiye
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Menü</span> <i class="icon-menu" title="Main pages"></i></li>
								<li class="<?php echo $anasayfam; ?>"><a href="/webpanel"><i class="icon-home4"></i> <span>Anasayfa</span></a></li>
								
								<?php 
								if($_SESSION['grup'] == 'Admin'){
								?>
								
								<li class="<?php echo $kullanicilarm; ?>">
									<a href="#"><i class="icon-pencil5"></i> <span>Kullanıcılar</span></a>
									<ul> 

										<li class="<?php echo $kullanicilarm; ?>"><a href="/webpanel/kullanicilar.php">Kullanıcı Listesi</a></li>
										<li class="" style="padding-left:15px;padding-right:15px;min-height:50px;">
										<div class="col-md-12">
										<form method="GET" action="kullanicisonuc.php">
										<input type="text" class="form-control" placeholder="Kullanıcı Arama" name="sonuc">
										<button onclick = "this.form.submit();" class="btn btn-primary" style="position:absolute;right:10px;top:0px;"><i class="fa fa-search"></i></button>
										</form>
										</div>
										</li>
									</ul>
								</li>
								<?php } ?>
								<li class="<?php echo $bannerm; ?>">									
								<a href="/webpanel/banner.php"><i class="fa fa-id-card-o"></i> <span>Anasayfa Banner</span></a>
								</li>
								<li class="<?php echo $sayfalarm; ?>">
									<a href="#"><i class="icon-quill4"></i> <span>Sayfalar</span></a>
									<ul>
										<li class="<?php echo $yenisayfam; ?>"><a href="/webpanel/yenisayfa.php">Yeni Sayfa</a></li>
										<li class="<?php echo $sayfalarm; ?>"><a href="/webpanel/sayfalar.php">Sayfalar</a></li>
									</ul>
								</li>
								
								<li class="<?php echo $anketlerm; ?>">
									<a href="/webpanel/anketler.php"><i class=" icon-quill4"></i> <span>Anket İşlemleri</span></a>
								</li>
								<li class="<?php echo $ssslerm; ?>">
									<a href="/webpanel/sssler.php"><i class=" icon-quill4"></i> <span>S.S.S. Sayfası</span></a>
								</li>
								<li class="<?php echo $kurallarm; ?>">
									<a href="/webpanel/kurallar.php"><i class=" icon-quill4"></i> <span>Kurallar Sayfası</span></a>
								</li>
								
								<li class="<?php echo $kurumsalm; ?>">
									<a href="#"><i class="icon-megaphone"></i> <span>Kurumsal</span></a>
									<ul>
										<li class="<?php echo $kurumsalm; ?>"><a href="/webpanel/kurumsal.php">Kurumsal Sayfası</a></li>
										<li class="<?php echo $yenigorevlim; ?>"><a href="/webpanel/yenigorevli.php">Yeni Görevli</a></li>
										<li class="<?php echo $gorevlilerm; ?>"><a href="/webpanel/gorevliler.php">Görevliler</a></li>
									</ul>
								</li>
								
								
								
								<li class="<?php echo $kurumsalmm; ?>">
									<a href="/webpanel/macerayakatil.php"><i class=" icon-quill4"></i> <span>Maceraya Katıl</span></a>
								</li>
								<li class="<?php echo $urunduzenlem; ?>">
									<a href="#"><i class="icon-megaphone"></i> <span>Ürün Yönetimi</span></a>
									<ul>
										<li class="<?php echo $yeniurunm; ?>"><a href="/webpanel/yeniurun.php">Yeni Ürün Ekle</a></li>
										<li class="<?php echo $urunlerm; ?>"><a href="/webpanel/urunler.php">Tüm Ürünler</a></li>
										<li class="<?php echo $yeniurunkategorim; ?>"><a href="/webpanel/yeniurunkategori.php">Yeni Kategori Ekle</a></li>
										<li class="<?php echo $urunkategorilerm; ?>"><a href="/webpanel/urunkategoriler.php">Ürün Kategorisi</a></li>
									</ul>
								</li>
								<li class="<?php echo $satislarm.' '.$krediyuklemem; ?>">
									<a href="#"><i class="icon-megaphone"></i> <span>Satışlar</span></a>
									<ul>
										<li class="<?php echo $satislarm; ?>"><a href="/webpanel/satislar.php">Ürün Satışı</a></li>
										<li class="<?php echo $krediyuklemem; ?>"><a href="/webpanel/yuklemeler.php">Kredi Yüklemesi</a></li>
									</ul>
								</li>
								<li>
									<a href="#"><i class="fa fa-youtube"></i> <span>Video Yönetimi</span></a>
									<ul>
										<li class="<?php echo $yenivideom; ?>"><a href="/webpanel/yenivideo.php">Video Ekle</a></li>
										<li class="<?php echo $videolarm; ?>"><a href="/webpanel/videolar.php">Video Listesi</a></li>
									</ul>
								</li>
								<li class="<?php echo $destekmermezim; ?>">
									<a href="#"><i class="icon-megaphone"></i> <span>Destek Merkezi</span></a>
									<ul>
										<li class="<?php echo $destekmermezim; ?>"><a href="/webpanel/destekmerkezi.php">Destek Talep Listesi</a></li>
										<li class="<?php echo $departmanlarym; ?>"><a href="/webpanel/yenidepartman.php">Yeni Kategori Ekle</a></li>
										<li class="<?php echo $departmanlarm; ?>"><a href="/webpanel/departmanlar.php">Destek Kategorileri</a></li>
									</ul>
								</li>
								
								<li class="<?php echo $forumkategorilerm; ?>">
									<a href="#"><i class="icon-megaphone"></i> <span>Forum Yönetimi</span></a>
									<ul>
										<li class="<?php echo $forummesajlarm; ?>"><a href="/webpanel/forummesajlar.php">Mesajlar</a></li>
										<li class="<?php echo $forumkonularm; ?>"><a href="/webpanel/forumkonular.php">Tüm Konular</a></li>
										<li class="<?php echo $forumkategorilerm; ?>"><a href="/webpanel/forumkategoriler.php">Tüm Kategoriler</a></li>
									</ul>
								</li>
								
								<li>
									<a href="#"><i class="icon-film"></i> <span>Slider Yönetimi</span></a>
									<ul>
										<li class="<?php echo $yenislidem; ?>"><a href="/webpanel/yenislide.php">Slider Ekle</a></li>
										<li class="<?php echo $sliderlarm; ?>"><a href="/webpanel/sliderlar.php">Slider Listesi</a></li>
									</ul>
								</li>
								<li class="<?php echo $mesajlarm; ?>">
									<a href="/webpanel/mesajlar.php"><i class="icon-envelop2"></i> <span>Mesajlar</span></a>
								</li>																
								<li class="<?php echo $iletisimm; ?>">									
								<a href="/webpanel/iletisim.php"><i class="fa fa-id-card-o"></i> <span>İletişim</span></a>
								</li>

								<!--<li class="<?php echo $yorumduzenlem; ?>">
									<a href="#"><i class="icon-pencil5"></i> <span>Oyuncu Yorumları</span></a>
									<ul>
										<li class="<?php echo $yorumeklem; ?>"><a href="/webpanel/musteriyorumuekle.php">Yeni Yorum Ekle</a></li>
										<li class="<?php echo $yorumlarm; ?>"><a href="/webpanel/musteriyorumlari.php">Yorum Listesi</a></li>
									</ul>
								</li>-->
								
								<li class="<?php echo $oyunlarm; ?>">
									<a href="#"><i class="icon-pencil5"></i> <span>Oyunlar</span></a>
									<ul>
										<li class="<?php echo $yenioyunm; ?>"><a href="/webpanel/yenioyun.php">Yeni Oyun Ekle</a></li>
										<li class="<?php echo $oyunlarm; ?>"><a href="/webpanel/oyunlar.php">Oyun Listesi</a></li>
										<li class="<?php echo $oyunlarmm; ?>"><a href="/webpanel/oyunyorum.php">Yorumlar</a></li>
									</ul>
								</li>
								
								<li class="<?php echo $makalem; ?>">
									<a href="#"><i class="icon-pencil5"></i> <span>Haberler & Duyurular</span></a>
									<ul>
										<li class="<?php echo $yenimakalem; ?>"><a href="/webpanel/yenimakale.php">Yeni Haber Ekle</a></li>
										<li class="<?php echo $makalelerm; ?>"><a href="/webpanel/makaleler.php">Haber Listesi</a></li>
										<li class="<?php echo $makalelermm; ?>"><a href="/webpanel/haberyorum.php">Yorumlar</a></li>
									</ul>
								</li>
								
	
								
								<li class="<?php echo $kategoriduzenlem; ?>">
									<a href="#"><i class="icon-stack2"></i> <span>Haber Kategorisi</span></a>
									<ul>
										<li class="<?php echo $yenikategorim; ?>"><a href="/webpanel/yenikategori.php">Kategori Ekle</a></li>
										<li class="<?php echo $kategorilerm; ?>"><a href="/webpanel/kategoriler.php">Kategori Listesi</a></li>
									</ul>
								</li>
								
								<!--<li class="<?php echo $gorsellerm; ?>"><a href="/webpanel/gorseller.php"><i class="icon-home4"></i> <span>Header Görselleri</span></a></li>-->
								<?php 
								if($_SESSION['grup'] == 'Admin'){
								?>
								<li>
								
									<a href="#"><i class="icon-stack"></i> <span>Site Yönetimi</span></a>
									<ul>
										<li class="<?php echo $logom; ?>"><a href="/webpanel/logo.php">Logo Değiştir</a></li>
										<li class="<?php echo $yeniyoneticim; ?>"><a href="/webpanel/yeniyonetici.php">Yeni Yönetici Ekle</a></li>
										<li class="<?php echo $yoneticilerm; ?>"><a href="/webpanel/yoneticiler.php">Yönetici Listesi</a></li>
									</ul>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->