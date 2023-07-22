<?php
	class bootstrap extends core{
		public $config;
		public $dispatcher;
		public $security;
		public $db;
		public $puan;
		public $seo;
		public $calc;
		public $user;
		public $islem;
		public $breadcrumbs;
		public $tool;
		public function __construct(){
			$this->breadcrumbs = array();
		}
		public function __destruct(){
			unset($this->dispatcher);
			unset($this->security);
			unset($this->db);
			unset($this->puan);
			unset($this->seo);
			unset($this->calc);
			unset($this->user);
			unset($this->islem);
			unset($this->breadcrumbs);
		}
		public function location($url){
			if(!empty($url)){
				header('Location: '.$url);
			};
		}
		public function locationJS($url){
			return "<script> window.location = '".$url."'; </script>";
		}
		public function alertReport(){
			
		}
		public function alertJS($param){
			return "<script> window.alert('".$param."'); </script>";
		}
		public function alertBS($param, $status, $margin = 15, $close = true){
			if(empty($param)) return null;
			$alert = array(
				'info'		=> array('color' => 'alert-info',		'icon' => 'fa fa-info-circle bounceIn'			),
				'success'	=> array('color' => 'alert-success',	'icon' => 'fa fa-check-circle bounceIn'			),
				'warning'	=> array('color' => 'alert-warning',	'icon' => 'fa fa-exclamation-circle bounceIn'	),
				'default'	=> array('color' => 'alert-warning',	'icon' => ''	),
				'danger'	=> array('color' => 'alert-danger',		'icon' => 'fa fa-times-circle bounceIn'			)
			);
			if(!empty($this->user) && !empty($this->islem)){
				$bind = array(
					'id'	=> $this->db->max('rep_gecmis'),
					'user'	=> $this->user,
					'islem'	=> $this->islem,
					'mesaj'	=> $param,
					'stamp'	=> time(),
					'durum'	=> $status
					);
				$this->db->query("insert into rep_gecmis (id, user, islem, mesaj, stamp, durum) values (:id, :user, :islem, :mesaj, :stamp, :durum);", $bind);
			};
			$buffer = '<div class="alert '.$alert[$status]['color'].' alert-table" style="margin-bottom:'.$margin.'px;">';
				$buffer .= '<div class="alert-row">';
					$buffer .= '<div class="alert-cell alert-icon">';
						$buffer .= '<i class="'.$alert[$status]['icon'].'"></i>';
					$buffer .= '</div>';
					$buffer .= '<div class="alert-cell alert-content">';
						$buffer .= $param;
					$buffer .= '</div>';
					if($close == true){
						$buffer .= '<div class="alert-cell alert-close">';
							$buffer .= '<button type="button" class="close" data-dismiss="alert">';
								$buffer .= '<span aria-hidden="true">';
									$buffer .='<i class="fa fa-times"></i>';
								$buffer .= '</span>';
							$buffer .= '</button>';
						$buffer .= '</div>';
					};
				$buffer .= '</div>';
			$buffer .= '</div>';
			return $buffer;
		}
		public function consoleInfoJS($param){
			return "<script> console.info('".$param."'); </script>";
		}
		public function consoleLogJS($param){
			return "<script> console.log('".$param."'); </script>";
		}
		public function tableBS($thead, $tbody, $proc = null){
			$view   = $this->security->get($this->dispatcher->get('resp')."/view");
			$update = $this->security->get($this->dispatcher->get('resp')."/update");
			$delete = $this->security->get($this->dispatcher->get('resp')."/delete");
			if(is_array($thead) || is_array($tbody)){
				$buffer = '<table class="table table-condensed table-hover table-striped">';
					if(is_array($thead)){
						$buffer .= '<thead>';
							$buffer .= '<tr>';
								#if($view == true) $buffer .= '<th><input type="checkbox" id="tableItemSelectAll" name="" value="1" /></th>';
								#if($view == true) $buffer .= '<th>Sıra</th>';
								foreach($thead as $node){
									$buffer .= '<th>'.$node.'</th>';
								};
								if($view == true){
									$buffer .= '<th></th>';
									/*
									$buffer .= '<td width="1">';
										$buffer .= '<a href="#" class="btn btn-xs btn-info" onclick="_view('.$id.', $(this), \''.$proc.'\');" '.$title.'>';
											$buffer .= '<i class="fa fa-eye"></i>';
										$buffer .= '</a>';
									$buffer .= '</td>';
									*/
								};
								if($update == true){
									$buffer .= '<th></th>';
									/*
									$buffer .= '<td width="1">';
										$buffer .= '<a href="#" class="btn btn-xs btn-warning" onclick="_update('.$id.', \''.$proc.'\');" data-toggle="modal" data-target="#modalForm'.$proc.'" title="Düzenle">';
											$buffer .= '<i class="fa fa-pencil"></i>';
										$buffer .= '</a>';
									$buffer .= '</td>';
									*/
								};
								if($delete == true){
									$buffer .= '<th></th>';
									/*
									$buffer .= '<th width="1">';
										$buffer .= '<a href="#" class="btn btn-xs btn-danger" onclick="_delete('.$id.', \''.$proc.'\');" data-toggle="modal" data-target="#modalDelete" title="Seçilenleri Sil">';
											$buffer .= '<i class="fa fa-remove"></i>';
										$buffer .= '</a>';
									$buffer .= '</th>';
									*/
								};
							$buffer .= '</tr>';
						$buffer .= '</thead>';
					};
					if(is_array($tbody)){
						$buffer .= '<tbody>';
							foreach($tbody as $id => $hash){
								$buffer .= '<tr>';
									if($hash['yayin'] == 1){
										$title = 'title="Yayına Kapat"';
										$icon  = 'fa-eye-slash';
										$class = 'class="success"';
									} else {
										$title = 'title="Yayına Aç"';
										$icon  = 'fa-eye';
										$class = '';
									};
									/*
									if($view == true){
										$buffer .= '<td '.$class.' width="1">';
											$buffer .= '<input type="checkbox" id="tableItemSelect" name="" value="1" />';
										$buffer .= '</td>';
									};
									*/
									/*
									if($view == true){
										$buffer .= '<td '.$class.' class="text-center" width="1">';
											$buffer .= '<a href="#" onclick="_sira($(this));" data-indis="'.$id.'" id="tableSort" style="width:50px;">1</a>';
											$buffer .= '<input type="text" data-indis="'.$id.'" id="tableSort" class="form-control input-xs" name="" value="1" style="width:50px; display:none;" />';
										$buffer .= '</td>';
									};
									*/
									foreach($hash['data'] as $node){
										$buffer .= '<td '.$class.'>'.$node.'</td>';
									};
									if($view == true){
										$buffer .= '<td '.$class.' width="1">';
											$buffer .= '<a href="#" class="btn btn-xs btn-info" onclick="_view('.$id.', $(this), \''.$proc.'\');" '.$title.'>';
												$buffer .= '<i class="fa fa-fw '.$icon.'"></i>';
											$buffer .= '</a>';
										$buffer .= '</td>';
									};
									if($update == true){
										$buffer .= '<td '.$class.' width="1">';
											$buffer .= '<a href="#" class="btn btn-xs btn-warning" onclick="_update('.$id.', \''.$proc.'\');" data-toggle="modal" data-target="#modalForm'.$proc.'" title="Düzenle">';
												$buffer .= '<i class="fa fa-fw fa-pencil"></i>';
											$buffer .= '</a>';
										$buffer .= '</td>';
									};
									if($delete == true){
										$buffer .= '<td '.$class.' width="1">';
											$buffer .= '<a href="#" class="btn btn-xs btn-danger" onclick="_delete('.$id.', \''.$proc.'\');" data-toggle="modal" data-target="#modalDelete" title="Sil">';
												$buffer .= '<i class="fa fa-fw fa-remove"></i>';
											$buffer .= '</a>';
										$buffer .= '</td>';
									};
								$buffer .= '</tr>';
							};
						$buffer .= '</tbody>';
					};
				$buffer .= '</table>';
				return $buffer;
			} else {
				return false;
			};
		}

		public function selectBS($option, $class = null, $name = null, $multiple = false, $height = false, $width = false){
			if($multiple == false){
				unset($multiple);
			} elseif($multiple == 'multiple'){
				$multiple = 'multiple="multiple"';
			};
			if($height == false){
				unset($height);
			} else {
				$height = 'height:'.$height.';';
			};
			if($width == false){
				unset($width);
			} else {
				$width = 'width:'.$width.';';
			};
			if(($height == false) && ($width == false)){
				unset($style);
			} else {
				$style = 'style="'.$width.' '.$height.'"';
			};
			if(is_array($option)){
				$buffer = '<select class="form-control '.$class.'" name="'.$name.'" '.$multiple.' '.$style.'>';
					foreach($option as $value => $param){
						$buffer .= '<option value="'.$value.'">'.$param.'</option>';
					};
				$buffer .= '</select>';
				return $buffer;
			} else {
				return false;
			};
		}

		public function textareaBS($param, $class = null, $name = null, $rows = false, $height = false, $width = false){
			if($rows == false){
				unset($rows);
			} else {
				$rows = 'rows="'.$rows.'"';
			};
			if($height == false){
				unset($height);
			} else {
				$height = 'height:'.$height.';';
			};
			if($width == false){
				unset($width);
			} else {
				$width = 'width:'.$width.';';
			};
			if(($height == false) && ($width == false)){
				$style = 'style="resize:vertical;"';
			} else {
				$style = 'style="'.$width.' '.$height.' resize:vertical;"';
			};
			if(!empty($param)){
				return '<textarea class="form-control '.$class.'" name="'.$name.'" '.$rows.' '.$style.'>'.$param.'</textarea>';
			} else {
				return false;
			};
		}

		public function paginationBS($table, $footer = true){	
			$max = 25;
			$lim = $_SESSION['pulse']['lim'];
			$num = $_SESSION['pulse']['num'];
			$cnt = $this->db->single("select count(id) as _count from ".$table.";");
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$_SESSION['pulse']['lim'] = '0';
			$_SESSION['pulse']['num'] = '10';
			}
			if($cnt > $num){
				$artan = $cnt % $num;
				if($artan > 0){
					$indis = (($cnt - $artan) / $num) + 1;
				} else {
					$indis = ($cnt / $num);
				}; 
				if($footer == true) $buffer .= '<div class="panel-footer text-center panel-pagination">';
					$buffer .= '<ul class="pagination pagination-sm">';

						if($_SESSION['pulse']['lim'] != 0){
							$buffer .= '<li>';
								$buffer .= '<a href="#" onclick="_filter(\'limit\', 0);">';
									$buffer .= '<i class="fa fa-fast-backward"></i>';
								$buffer .= '</a>';
							$buffer .= '</li>';
						};

						#$buffer .= '<li>';
							#$buffer .= '<a href="#" onclick="_filter(\'limit\', 0);">';
								#$buffer .= '<i class="fa fa-backward"></i>';
							#$buffer .= '</a>';
						#$buffer .= '</li>';

						for($x = 0; $x < $indis; $x++){
							if($lim == ($x * $num)){
								$active   = 'class="active"';
								$selected = 'selected="selected"';
							} else {
								unset($active, $selected);
							};
							if($x < $max){
								$buffer .= '<li '.$active.'>';
									$buffer .= '<a href="#" onclick="_filter(\'limit\', '.($x * $num).');">';
										$buffer .= ($x + 1);
									$buffer .= '</a>';
								$buffer .= '</li>';
							} else {
								$item .= '<option value="'.($x * $num).'" '.$selected.'>'.($x + 1).'</option>';
							};
						};
						if($indis > $max){
							$buffer .= '<li class="active">';
								$buffer .= '<select onchange="_filter(\'limit\', $(this).val());">';
									$buffer .= $item;
								$buffer .= '</select>';
							$buffer .= '</li>';
						};

						#$buffer .= '<li>';
							#$buffer .= '<input type="text" value="" onkeyup="_filter(\'limit\', $(this).val());" />';
						#$buffer .= '</li>';

						#$buffer .= '<li>';
							#$buffer .= '<a href="#" onclick="_filter(\'limit\', '.(($indis - 1) * $num).');">';
								#$buffer .= '<i class="fa fa-forward"></i>';
							#$buffer .= '</a>';
						#$buffer .= '</li>';

						if($_SESSION['pulse']['lim'] != (($indis - 1) * $num)){
							$buffer .= '<li>';
								$buffer .= '<a href="#" onclick="_filter(\'limit\', '.(($indis - 1) * $num).');">';
									$buffer .= '<i class="fa fa-fast-forward"></i>';
								$buffer .= '</a>';
							$buffer .= '</li>';
						};

					$buffer .= '</ul>';
				if($footer == true) $buffer .= '</div>';
			};
			return $buffer;
		}

		public function breadcrumb_items_category($id, $module){
			foreach($this->db->query("select * from cat_kategoriler where (id = :id) order by alt_id asc;", array("id" => $id)) as $kategori){
				if(!empty($kategori['id'])){
					$this->breadcrumb_items_category($kategori['alt_id'], $module);
					if(!empty($module)){
						$_SESSION['items'] = $_SESSION['items']."#".$module."/".$kategori['kategorikodu']."|".$kategori['kategori_TR'];
					} else {
						$_SESSION['items'] = $_SESSION['items']."#".$kategori['kategorikodu']."|".$kategori['kategori_TR'];
					};
				};
			};
		}

		public function breadcrumb_items($crumbs, $module){
			if(!empty($_REQUEST['p'])){
				$id = $this->db->single("select id from cat_kategoriler where (kategorikodu = :kategorikodu);", array("kategorikodu" => $_REQUEST['p']));
			} else {
				$id = 0;
			};
			unset($_SESSION['items']);
			$this->breadcrumb_items_category($id, $module);
			foreach(explode("#", $_SESSION['items']) as $item){
				if(!empty($item)){
					array_push($crumbs, $item);
				};
			};
			return $crumbs;
		}

		public function breadcrumb($crumbs){
			echo "<ol class='breadcrumb-glass hidden-xs hidden-sm'>";
				echo "<li>";
					echo "<a href='".$this->config['global']['domain']."'>";
						echo "<i class='fa fa-home'></i>";
					echo "</a>";
				echo "</li>";
				foreach($crumbs as $crumb){
					$crumb = explode("|", $crumb);
					echo "<li>";
						echo "<a href='".$this->config['global']['domain'].$crumb[0]."'>";
							echo $crumb[1];
						echo "</a>";
					echo "</li>";
				};
			echo "</ol>";
		}

		public function title_items_category($id){
			$kategoriler = $this->db->query("select * from cat_kategoriler where id = :id order by alt_id asc;", array("id" => $id));
			foreach($kategoriler as $kategori){
				if(!empty($kategori['id'])){
					$this->title_items_category($kategori['alt_id']);
					$_SESSION['items'] = $_SESSION['items']."#".$kategori['kategori_TR'];
				};
			};
		}

		public function title_items($items){
			if(!empty($_REQUEST['p'])){
				$id = $this->db->single("select id from cat_kategoriler where kategorikodu = :kategorikodu;", array("kategorikodu" => $_REQUEST['p']));
			} else {
				$id = 0;
			};
			unset($_SESSION['items']);
			$this->title_items_category($id);
			foreach(explode("#", $_SESSION['items']) as $item){
				if(!empty($item)){
					array_push($items, $item);
				};
			};
			return $items;
		}

		public function title($items){
			echo "<title>";
				foreach($items as $item){
					echo $item;
				};
			echo "</title>";
		}

		public function ribbon($eskifiyat, $yenifiyat){
			$eskifiyat = $this->calc->fiyattan_kurus($eskifiyat);
			$yenifiyat = $this->calc->fiyattan_kurus($yenifiyat);
			if($eskifiyat != '' and $eskifiyat != '0'){
				$kazanc    = round(($eskifiyat - $yenifiyat) / ($eskifiyat / 100));
			if($kazanc > 0){
				$buffer .= '<div class="ribbon">';
					$buffer .= '<div class="ribbon-body">';
						$buffer .= '<div class="ribbon-top"></div>';
						$buffer .= '%'.$kazanc;
						$buffer .= '<div class="ribbon-bottom"></div>';
					$buffer .= '</div>';
				$buffer .= '</div>';
				return $buffer;
			};
			}	
		}
		public function product($urunler, $type, $frst = false, $mode = 'echo', $rbn = true){
			if($type == "list"){
				$buffer = "<table class='table table-list'>";
					$buffer .= "<tbody>";
						foreach($urunler as $urun){
							$kategori = $this->db->row("select * from cat_kategoriler where (id = :id);", array("id" => $urun['kategori']));
							$gorsel   = json_decode($urun['gorsel']);
							$gorsel   = $gorsel[0];
							$buffer .= "<tr>";
								$buffer .= "<td width='40' style='padding-left:15px;'>";
									$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
										if(!file_get_contents($this->config['global']['CDN'].'files/product_81/'.$gorsel)){
											$buffer .= "<div style='width:100%; height:40px; text-align:center;'>";
												$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:40px; font-size:40px;'></i>";
											$buffer .= "</div>";
										} else {
											$buffer .= "<div style='width:40px; height:40px; overflow:hidden !important;'>";
												if($gorsel != ''){
													$buffer .= "<img src='".$this->config['global']['CDN']."files/product_81/".$gorsel."' width='40' height='40' title='' alt='' />";
												}else{
													$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:40px; font-size:30px;'></i>";
												}
												
											$buffer .= "</div>";
										};
									$buffer .= "</a>";
								$buffer .= "</td>";
								$buffer .= "<td>";
									$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
										
										
										$buffer .= "<strong class='text-muted'>".mb_substr($urun['urun_TR'], 0, 152, "UTF-8")."</strong>";
										$buffer .= "<br />";
										$buffer .= "<small class='text-muted'>".$this->db->single("select marka_TR from cat_markalar where (id = :id);", array('id' => $urun['marka']))."</small>";
										$magazaadi = $this->db->row("select * from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
										if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted'><b>Satıcı:</b> ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted'><b>Mağaza:</b> ".$magazaadi['magazaadi']."</small>";
										}
										
									$buffer .= "</a>";
								$buffer .= "</td>";
								/*$buffer .= "<td style='vertical-align:middle;'>";
									if($this->tool->getCargoPeriods($urun) == 1){ # hızlı teslim
										$buffer .= "<div class='btn btn-xs btn-default btn-ht' disabled='disabled'>";
											$buffer .= "<i class='fa fa-fw fa-clock-o'></i>";
										$buffer .= "</div> ";
									};
									if($urun['kb'] != 0){ # kargo bedava
										$buffer .= "<div class='btn btn-xs btn-default btn-kb' disabled='disabled'>";
											$buffer .= "<i class='fa fa-fw fa-gift'></i>";
										$buffer .= "</div> ";
									};
									if($urun['ss'] != 0){ # sınırlı stok
										$buffer .= "<div class='btn btn-xs btn-default btn-ss' disabled='disabled'>";
											$buffer .= "<i class='fa fa-fw fa-archive'></i>";
										$buffer .= "</div> ";
									};
								$buffer .= "</td>";*/
								$buffer .= "<td style='vertical-align:middle;'>";
									$buffer .= "<strong class='text-success' style='font-size:16px;'>";
										$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
									$buffer .= "</strong>";
									#$buffer .= "<br />";
									#$buffer .= "<small class='text-muted' style='font-size:10px;'>KDV Dahil</small>";
								$buffer .= "</td>";
								$firsat = $this->db->row("select sal_firsatlar.* from sal_firsatlar where (sal_firsatlar.stokkodu = :stokkodu) && (sal_firsatlar.stamp_end > ".time().")", array('stokkodu' => $urun['stokkodu']));
								if(!empty($firsat['stamp_end']) && ($frst == true)){
									$buffer .= "<td style='padding:0px; vertical-align:middle;'>";
										$buffer .= "<div class='timer' data-end='".$firsat['stamp_end']."'></div>";
									$buffer .= "</td>";
								};
							$buffer .= "</tr>";
						};
					$buffer .= "</tbody>";
				$buffer .= "</table>";
			} elseif($type == "row"){
				unset($buffer);
				foreach($urunler as $urun){
					$kategori = $this->db->single("select kategorikodu from cat_kategoriler where id = :id;", array("id"=>$urun['kategori']));
					$gorsel   = json_decode($urun['gorsel']);
					$gorsel   = $gorsel[0];
					$buffer .= "<div class='row comment'>";
						$buffer .= "<div class='col-xs-3'>";
							if(!file_get_contents($this->config['global']['CDN'].'files/product_81/'.$gorsel)){
								$buffer .= "<div style='width:100%; height:62px; text-align:center;'>";
									$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:62px; font-size:40px;'></i>";
								$buffer .= "</div>";
							} else {
								$buffer .= "<div style='width:62px; height:62px; overflow:hidden !important;'>";
									$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
										$buffer .= "<img src='".$this->config['global']['CDN']."files/product_81/".$gorsel."' width='100%' title='' alt='' />";
									$buffer .= "</a>";
								$buffer .= "</div>";
							};
						$buffer .= "</div>";
						$buffer .= "<div class='col-xs-9'>";
							$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$buffer .= "<small>".mb_substr($urun['urun_TR'], 0, 19, "UTF-8")."...</small>";
								
								$magazaadi = $this->db->row("select * from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
										
								if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted'><b>Satıcı:</b> ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted'><b>Mağaza:</b> ".$magazaadi['magazaadi']."</small>";
										}
								
							$buffer .= "</a>";
							$buffer .= "<br />";
							if($urun['eskifiyat'] > 0){
								$buffer .= "<small class='text-muted'>";
									$buffer .= "<s>".$this->calc->tutar_format($urun['eskifiyat'])."</s> <i class='fa fa-try'></i>";
								$buffer .= "</small> ";
							};
							$buffer .= "<strong class='text-success'>";
								$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
							$buffer .= "</strong>";
						$buffer .= "</div>";
					$buffer .= "</div>";
				};
			} elseif($type == "mobile-box"){
				
				foreach($urunler as $urun){
					$gorsel = json_decode($urun['gorsel']);
					$gorsel = $gorsel[0];
					$kategori = $this->db->single("select kategorikodu from cat_kategoriler where (id = :id);", array("id" => $urun['kategori']));
					$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
						$buffer .= "<div class='panel panel-default panel-urun'>";
							$firsat = $this->db->row("select sal_firsatlar.* from sal_firsatlar where (sal_firsatlar.stokkodu = :stokkodu) && (sal_firsatlar.stamp_end > ".time().")", array('stokkodu' => $urun['stokkodu']));
							if(!empty($firsat['stamp_end']) && ($frst == true)){
								$buffer .= "<div class='panel-heading' style='padding:4px 0px;'>";
									$buffer .= "<div class='timer' data-end='".$firsat['stamp_end']."'></div>";
								$buffer .= "</div>";
							};
							$buffer .= "<div id='productImageContainer' class='panel-body text-center' style='position:relative; padding:10px; overflow:hidden;'>";
								if($rbn == true) $buffer .= $this->ribbon($urun['eskifiyat'], $urun['satisfiyatikd']);
								if(!file_get_contents($this->config['global']['CDN'].'files/product/'.$gorsel)){
									$buffer .= "<div style='width:100%; height:140px; text-align:center;'>";
										$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:193px; font-size:100px;'></i>";
									$buffer .= "</div>";
								} else {
									$buffer .= "<div style='width:100%; height:140px; overflow:hidden;'>";
										$buffer .= "<img src='".$this->config['global']['CDN']."files/product_575/".$gorsel."' width='100%' title='' alt='' />";
									$buffer .= "</div>";
								};
								$buffer .= "<br />";
								$buffer .= "<p class='text-muted' style='margin-bottom:0px; font-size:13px; height:55px;'>";
									$buffer .= mb_substr($urun['urun_TR'], 0, 19, "UTF-8").'...';
									$magazaadi = $this->db->row("select * from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
										
								if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted'><b>Satıcı:</b> ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted'><b>Mağaza:</b> ".$magazaadi['magazaadi']."</small>";
										}	
								$buffer .= "</p>";
							$buffer .= "</div>";
							$buffer .= "<div class='panel-footer text-center' style='background:#FFF; height:56px; padding:5px 15px;'>";
								if($urun['stoksayisi'] > 0){
									if($urun['eskifiyat'] > $urun['satisfiyatikd']){
										$buffer .= "<small class='text-muted' style='font-size:12px;'>";
											$buffer .= "<s>".$this->calc->tutar_format($urun['eskifiyat'])." <i class='fa fa-try'></i></s>";
										$buffer .= "</small> ";
										$buffer .= "<br />";
										$buffer .= "<strong style='font-size:18px; color:red;'>";
											$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
										$buffer .= "</strong> ";
									} else {
										$buffer .= "<strong class='text-success' style='line-height:46px; font-size:18px;'>";
											$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
										$buffer .= "</strong> ";
									};
								} else {
									$buffer .= "<small class='text-warning'>Bu ürün geçici olarak temin edilememektedir.</small>";
								};
							$buffer .= "</div>";
						$buffer .= "</div>";
					$buffer .= "</a>";
				};

			} elseif($type == "epin"){
				$buffer = "<div id='panelUrun' class='row' style='margin:0px !important;'>";
					foreach($urunler as $urun){
						$gorsel = json_decode($urun['gorsel']);
						$gorsel = $gorsel[0];
						$buffer .= "<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3'>";
							$kategori = $this->db->single("select kategorikodu from cat_kategoriler where (id = :id);", array("id" => $urun['kategori']));
							$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$buffer .= "<div class='panel panel-default panel-urun' style='margin:0px 5px 10px 0px !important;'>";
									
									$buffer .= "<div class='panel-body text-center' style='padding:10px;'>";
										
										
										if(!file_get_contents($this->config['global']['CDN'].'files/product_193/'.$gorsel)){
											$buffer .= "<div style='width:100%; height:191px; text-align:center;'>";
												$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:191px; font-size:100px;'></i>";
											$buffer .= "</div>";
										} else {
											$buffer .= "<div style='width:100%; height:191px;  text-align:center; overflow:hidden;'>";
												$buffer .= "<div style='width:100%; max-width:187px; height:100%; margin:0 auto;overflow:hidden'>";
												$buffer .= "<img src='".$this->config['global']['CDN']."files/product_193/".$gorsel."' height='100%' width='100%'   title='' alt='' />";
												$buffer .= "</div>";
											$buffer .= "</div>";
										};
										
										
										$buffer .= "<p class='text-muted urunadi' style='margin-bottom:0px;'>";
											$buffer .= mb_substr($urun['urun_TR'], 0, 19, "UTF-8").'...';
											$magazaadi = $this->db->row("select * from cat_magazalar where (magazakodu = :magazakodu);", array("magazakodu" => $urun['magaza']));
										
										if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted hidden-xs hidden-sm'>Mağaza: ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted hidden-xs hidden-sm'>Mağaza: ".$magazaadi['magazaadi']."</small>";
										}
										
								
										$buffer .= "</p>";
									$buffer .= "</div>";
									
									$buffer .= "<div class='panel-footer text-center' style='background:#FFF; height:56px; padding:5px 15px;'>";
										
												$buffer .= "<strong class='text-success' style='line-height:46px; font-size:18px;'>";
													$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
												$buffer .= "</strong> ";
										
											
										
									$buffer .= "</div>";
								$buffer .= "</div>";
							$buffer .= "</a>";
						$buffer .= "</div>";
					};
				$buffer .= "</div>";
			}
			
			elseif($type == "row"){
				unset($buffer);
				foreach($urunler as $urun){
					$kategori = $this->db->single("select kategorikodu from cat_kategoriler where id = :id;", array("id"=>$urun['kategori']));
					$gorsel   = json_decode($urun['gorsel']);
					$gorsel   = $gorsel[0];
					$buffer .= "<div class='row comment'>";
						$buffer .= "<div class='col-xs-3'>";
							if(!file_get_contents($this->config['global']['CDN'].'files/product_81/'.$gorsel)){
								$buffer .= "<div style='width:100%; height:62px; text-align:center;'>";
									$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:62px; font-size:40px;'></i>";
								$buffer .= "</div>";
							} else {
								$buffer .= "<div style='width:62px; height:62px; overflow:hidden !important;'>";
									$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
									if($_REQUEST['r'] == 'content/magaza'){
									$buffer .= "<img  class='lazy' data-original='".$this->config['global']['CDN']."files/product_81/".$gorsel."' width='100%' title='' alt='' />";
									}else{
									
										$buffer .= "<img  src='".$this->config['global']['CDN']."files/product_81/".$gorsel."' width='100%' title='' alt='' />";
									}
									$buffer .= "</a>";
								$buffer .= "</div>";
							};
						$buffer .= "</div>";
						$buffer .= "<div class='col-xs-9'>";
							$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$buffer .= "<small>".mb_substr($urun['urun_TR'], 0, 19, "UTF-8")."...</small>";
								
								$magazaadi = $this->db->row("select * from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
										
								if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted'><b>Satıcı:</b> ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted'><b>Mağaza:</b> ".$magazaadi['magazaadi']."</small>";
										}
								
							$buffer .= "</a>";
							$buffer .= "<br />";
							if($urun['eskifiyat'] > 0){
								$buffer .= "<small class='text-muted'>";
									$buffer .= "<s>".$this->calc->tutar_format($urun['eskifiyat'])."</s> <i class='fa fa-try'></i>";
								$buffer .= "</small> ";
							};
							$buffer .= "<strong class='text-success'>";
								$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
							$buffer .= "</strong>";
						$buffer .= "</div>";
					$buffer .= "</div>";
				};
			}

			else {
				$buffer = "<div id='panelUrun' class='row' style='margin:0px !important;'>";
					foreach($urunler as $urun){
						$gorsel = json_decode($urun['gorsel']);
						$gorsel = $gorsel[0];
						$buffer .= "<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3'>";
							$kategori = $this->db->single("select kategorikodu from cat_kategoriler where (id = :id);", array("id" => $urun['kategori']));
							$buffer .= "<a href='".$this->config['global']['domain'].$urun['urlkodu']."'>";
								$buffer .= "<div class='panel panel-default panel-urun' style='margin:0px 5px 10px 0px !important;'>";
									$firsat = $this->db->row("select sal_firsatlar.* from sal_firsatlar where (sal_firsatlar.stokkodu = :stokkodu) && (sal_firsatlar.stamp_end > ".time().")", array('stokkodu' => $urun['stokkodu']));
									if(!empty($firsat['stamp_end']) && ($frst == true)){
										$buffer .= "<div class='panel-heading' style='padding:4px 0px;'>";
											$buffer .= "<div class='timer' data-end='".$firsat['stamp_end']."'></div>";
										$buffer .= "</div>";
									};
									$buffer .= "<div class='panel-body text-center' style='padding:10px;'>";
										$buffer .= "<span class='urun-durum'>";
											if($this->tool->getCargoPeriods($urun) == 1){ # hızlı teslim
												#$buffer .= "<div class='btn btn-xs btn-default btn-ht' disabled='disabled'>";
													#$buffer .= "<i class='fa fa-fw fa-clock-o'></i>";
													#$buffer .= "<span> 24 Saatte Kargo</span>";
												#$buffer .= "</div> ";
											};
											if($urun['kb'] != 0 and $urun['ozellik'] != 'epin'){ # kargo bedava
												$buffer .= "<div class='btn btn-xs btn-default btn-kb' disabled='disabled'>";
													$buffer .= "<i class='fa fa-fw fa-gift'></i>";
													$buffer .= "<span> Kargo Bedava</span>";
												$buffer .= "</div> ";
											};
											if($urun['ss'] != 0){ # sınırlı stok
												$buffer .= "<div class='btn btn-xs btn-default btn-ss' disabled='disabled'>";
													$buffer .= "<i class='fa fa-fw fa-archive'></i>";
													$buffer .= "<span> Sınırlı Stok</span>";
												$buffer .= "</div> ";
											};
										$buffer .= "</span>";
										if($rbn == true){
											$buffer .= $this->ribbon($urun['eskifiyat'], $urun['satisfiyatikd']);
										};
										if(!file_get_contents($this->config['global']['CDN'].'files/product_193/'.$gorsel)){
											$buffer .= "<div style='width:100%; height:191px; text-align:center;'>";
												$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:191px; font-size:100px;'></i>";
											$buffer .= "</div>";
										} else {
											$buffer .= "<div style='width:100%; height:191px;  text-align:center; overflow:hidden;'>";
												$buffer .= "<div style='width:100%; max-width:187px; height:100%; margin:0 auto;overflow:hidden'>";
											if($_REQUEST['r'] == 'content/magaza'){
												$buffer .= "<img  class='lazy' data-original='".$this->config['global']['CDN']."files/product_193/".$gorsel."' height='100%' width='100%'   title='' alt='' />";
											}else{
												if($gorsel != ''){
													$buffer .= "<img  src='".$this->config['global']['CDN']."files/product_193/".$gorsel."' height='100%' width='100%'   title='' alt='' />";
												}else{
													$buffer .= "<i class='fa fa-photo' style='color:#DDD; line-height:191px; font-size:100px;'></i>";
												}
												
											}												
												$buffer .= "</div>";
											$buffer .= "</div>";
										};
										$marka = $this->db->single("select marka_TR from cat_markalar where (id = :id);", array("id" => $urun['marka']));
										
										$buffer .= "<p class='text-muted urunadi' style='margin-bottom:0px;'>";
											$buffer .= mb_substr($urun['urun_TR'], 0, 19, "UTF-8").'...';
											$buffer .= "<br><small class='hidden-xs hidden-sm'>".$marka."</small>";
											$magazaadi = $this->db->row("select * from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));										
										if($magazaadi['yayin'] == '0'){
											$magazakul = $this->db->single("select magazakodu from cat_magazalar where (id = :id);", array("id" => $urun['magaza']));
											$kullaniciadi = $this->db->single("select kullaniciadi from cus_uyeler where (kullaniciadi = :kullaniciadi);",array('kullaniciadi' => $magazakul));
											$buffer .= "</br><small class='text-muted hidden-xs hidden-sm'><b>Satıcı:</b> ".$kullaniciadi."</small>";
										}else{
											$buffer .= "</br><small class='text-muted hidden-xs hidden-sm'><b>Mağaza:</b> ".$magazaadi['magazaadi']."</small>";
										}

										$buffer .= "</p>";
									$buffer .= "</div>";
									#$magaza = $this->db->row("select * from cat_magazalar where (id = :magazakodu);", array("magazakodu" => $urun['magaza']));
									#$count  = $this->db->single("select count(id) as _count from cat_urunler where (magaza = :magaza);", array("magaza" => $urun['magaza']));
									#$buffer .= "<small class='text-muted' style='display:inline-block; border-top:solid 1px #DDD; width:100%; padding:3px 10px; font-size:10px;'>";
										#$buffer .= "<i class='fa fa-university'></i> ".$magaza['magazaadi']." (".$count.")";
									#$buffer .= "</small>";
									$buffer .= "<div class='panel-footer text-center' style='background:#FFF; height:56px; padding:5px 15px;'>";
										if($urun['stoksayisi'] > 0){
											$sayi1 = str_replace(",", ".", $urun['eskifiyat']);
											$sayi2 = str_replace(",", ".", $urun['satisfiyatikd']);
											if($sayi1 > $sayi2){
												$buffer .= "<small class='text-muted' style='font-size:12px;'>";
													$buffer .= "<s>".$this->calc->tutar_format($urun['eskifiyat'])." <i class='fa fa-try'></i></s>";
												$buffer .= "</small> ";
												$buffer .= "<br />";
												$buffer .= "<strong style='font-size:18px; color:red;'>";
													$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
												$buffer .= "</strong> ";
											} else {
												$buffer .= "<strong class='text-success' style='line-height:46px; font-size:18px;'>";
													$buffer .= $this->calc->tutar_format($urun['satisfiyatikd'])." <i class='fa fa-try'></i>";
												$buffer .= "</strong> ";
											};
											#$buffer .= "<small class='text-muted' style='font-size:9px;'>KDV Dahil</small>";
										} else {
											$buffer .= "<small class='text-warning'>Bu ürün mağaza tarafından satışa kapatılmıştır.</small>";
										};
									$buffer .= "</div>";
								$buffer .= "</div>";
							$buffer .= "</a>";
						$buffer .= "</div>";
					};
				$buffer .= "</div>";
			};
			if($mode == 'echo'){
				echo $buffer;
			} elseif($mode == 'buffer'){
				return $buffer;
			};
		}
	};
?>