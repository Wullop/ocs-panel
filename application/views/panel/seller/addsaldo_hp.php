<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="page-wrapper">
	 <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">เติมเครดิต</h3>
            <div class="well">เครดิตที่เหลือ : <B><?php if (isset($user->saldo)) {echo $user->saldo; }?></B></div>
        </div>
    </div>
    <div class="row">
		  <div class="col-sm-6">
			   <p class="text-muted">รายละเอียด : หากมีการชำระเงินโปรดคลิกยืนยันจากนั้นยอดเงินของคุณจะเพิ่มขึ้นโดยอัตโนมัติภายใน1-2ชม. หลังจากได้รับการยืนยันจากผู้ดูแล :: กรุณาโอนเงินก่อนแจ้ง::</p>
			   <h5>มีปัญหาเกียวกับการเติมเครดิต <a href='http://kguza.xyz/Line'><b>สอบถาม</b></a href></h5>
			<h5>โอนเงินเข้าบัญชีวอลเล็ท 0923268286 <a href='http://kguza.xyz/Line'><b>ส่งหลักฐาน</b></a href></h5>
		  </div>
           <div class="col-sm-6">
			  <?php if (validation_errors()) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert"><?= validation_errors() ?></div>
					</div>
					<?php endif; ?>
					<?php if (isset($error)) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert"><?= $error ?></div>
					</div>
					<?php endif;?>
					<?php if (isset($message)) : ?>
					<div class="col-md-12">
						<div class="alert alert-success" role="alert"><?= $message ?></div>
					</div>
					<?php endif;?>
			   <?= form_open() ?>
					<div class="form-group">
						<label for="sender">เลขบัญชีผู้โอน</label>
						<input type="text" name="sender" class="form-control" id="sender" placeholder="xxxxxxxxxx"/>
						<small class="text-muted">สำหรับหลักฐานการจ่ายเงินแล้ว</small>
					</div>
					<div class="form-group">
						<label for="hp">โอนเข้าหมายเลข</label>
						<select name="hp" id="hp" class="form-control">
							<?php foreach ($this->user_model->view_asset() as $row): ?>
							<?php if (!empty($row['nohp'])): ?>
							<option value="<?= $row['nohp']?>"><?= $row['nohp'].' ('.$row['provider'].')'?></option>
							<?php endif;?>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="hp">จำนวนเงินที่โอน:ใส่ตามจริง:</label>
						<input type="number" name="jumlah" class="form-control" id="jumlah" value="xx"/>
						<small class="text-muted">โอนขั้นต่ำ 20 บาท</small>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary form-control" value="ยืนยัน"/>
					</div>
			   </form>
            </div>
    </div>
</div>
