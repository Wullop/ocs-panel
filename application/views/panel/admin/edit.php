<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div id="page-wrapper">
			<div class="row"><div class="col-lg-12"><h3 class="page-header">แก้ไข เซิฟร์เวอร์</h3></div></div>
				<div class="row"><div class="col-lg-12">
					
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<?php if (isset($message)) : ?>
									<?= $message ?>
							<?php endif; ?>
							<form action="<?= base_url('panel/administrator/edit/'.str_replace(' ','-',$server -> ServerName).'/'.$server->Id ) ?>" method="POST">
								<div class="form-group">
									<label for="ServerName">ชื่อ</label>
									<input type="text" class="form-control" id="ServerName" name="ServerName" value="<?= $server -> ServerName ?>">
										<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="ServerName">ที่ตั้ง เซิฟร์เวอร์</label>
									<input class="form-control" placeholder="Location Demo" name="Location" type="text" required> 
										<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="email">ราคา</label>
									<input type="number" class="form-control" id="email" name="Price" value="<?= $server->Price ?>">
									<p class="help-block">ตั้งค่าเป็น 0 เซิร์ฟเวอร์จะปรากฏบนสถานะฟรี</p>
								</div>
								<div class="form-group">
									<label for="email">โฮส IP</label>
									<input type="text" class="form-control" id="email" name="HostName" value="<?= $server->HostName ?>"
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="password_confirm">รหัสผ่านเซิฟร์เวอร์</label>
									<input type="text" class="form-control" id="password_confirm" name="RootPasswd" value="<?= $server->RootPasswd ?>">
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="password_confirm">ขีดจำกัดบัญชี</label>
										<input type="number" class="form-control" id="password_confirm" name="MaxUser" value="<?= $server->MaxUser ?>">
									</div>
								</div>			
								<div class="col-xs-6">
									<div class="form-group">
										<label for="password_confirm">จำนวนวันใช้งาน</label>
										<input type="number" class="form-control" id="password_confirm" name="Expired" value="<?= $server->Expired ?>">
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="password_confirm">Openssh</label>
										<input type="text" class="form-control" id="password_confirm" name="OpenSSH" value="<?= $server->OpenSSH ?>">
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="password_confirm">Dropbear</label>
										<input type="text" class="form-control" id="password_confirm" name="Dropbear" value="<?= $server->Dropbear?>">
									</div>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="บันทึก">									
									<a href="<?= base_url('panel/administrator/'.$_SESSION['username'].'/'.'server') ?>" class="btn btn-default">กลับ</a>
								</div>
							</form>
						</div>
					</div>
				</div></div><!-- .row -->
		</div>

