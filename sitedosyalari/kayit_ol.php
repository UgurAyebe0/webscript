
    <!-- Registration Form -->
    <div id="nav-registration" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kayıt Ol</h4>
                </div>
                <div class="modal-body">
				
                  <form method="post" id="kayit">
                                    <div class="form-group">
                                        <label>Kullanici Adi</label>
                                        <input name="kadi" type="username" class="form-control" placeholder="KullanıcıAdı" size="16" maxlength="16"required >
                                    </div>
                                    <div class="form-group">
                                        <label>Email Adresi</label>
                                        <input name="email" type="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Şifre</label>
                                        <input name="sifre" type="password" class="form-control" placeholder="Şifre" size="18" maxlength="18" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Şifre Tekrar</label>
                                        <input name="sifre2" type="password" class="form-control" placeholder="Şifre Tekrar" size="18" maxlength="18" required>
                                    </div>
									<div class="form-group">
										<img src="dogrulama.php" />
									</div> <div class="form-group">
										<label>Doğrulama Kodu</label>
										<input type="text" name="dk" class="form-control" placeholder="Doğrulama Kodu" required>
									</div>
                                    <div class="checkbox">
                                        <label>
										<input name="onay" type="checkbox" required> Şartları ve politikayı kabul ediyor musun?
									</label>
                                    </div>
                                    <input name="uyekaydi" type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" value="Kayıt Ol"/>
                                    <div class="register-link m-t-15 text-center">
                                        <p>Zaten Hesabın Var Mı? <a href="giris.php"> Giris Yap</a></p>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Registration Form -->