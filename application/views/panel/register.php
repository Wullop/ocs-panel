<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="bs-example">
    <div class="panel-group" id="accordion">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> ใส่รายละเอียดในช่องด้านล่าง ......KGUZA......</a>
                </h4>
            </div>

<div class="container">
	<div class="row">
		<div class="col-lg-10">
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<div class="panel-body">
				<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h3>สมัครเข้าใช้งาน</h3>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">ชื่อผู้ใช้</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Username">
					<p class="help-block">มีตัวอักษรหรือตัวเลขอย่างน้อย 4 ตัว</p>
				</div>
				<div class="form-group">
					<label for="email">อีเมล์</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
					<p class="help-block">ที่อยู่อีเมล์ที่ถูกต้อง</p>
				</div>
				<div class="form-group">
					<label for="password">รหัสผ่าน</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
					<p class="help-block">อย่างน้อย 6 ตัวอักษร</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">ยืนยันรหัสผ่าน</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
					<p class="help-block">ต้องตรงกับรหัสผ่านด้านบน</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="สร้างบัญชี">
				</div>
			</form>
		</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
