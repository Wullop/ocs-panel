<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                บัญชี SSH
            </h3>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12 hidden-print">                    
                <?= $user['message']?>
            </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i> สร้างบัญชีสำเร็จ
                </div>
                <div class="panel-body">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>ชื่อผู้ใช้</td><td>:</td><td><?= $user['username']?></td>
                        </tr>
                        <tr>
                            <td>รหัสผ่าน</td><td>:</td><td><?= $user['password']?></td>
                        </tr>
                        <tr>
                            <td>โฮส IP</td><td>:</td><td><?= $user['hostname']?></td>
                        </tr>
                        <tr>
                            <td>ประเทศ</td><td>:</td><td><?= $user['location']?></td>
                        </tr>
                        <tr>
                            <td>Openssh</td><td>:</td><td><?= $user['openssh']?></td>
                        </tr>
                         <tr>
                            <td>Dropbear</td><td>:</td><td><?= $user['dropbear']?></td>
                        </tr>
                         <tr>
                            <td>ราคา</td><td>:</td><td><?= $user['price']?></td>
                        </tr>
                        <tr>
                            <td>วันหมดอายุ</td><td>:</td><td><?= date("Y-m-d H:i:s",strtotime("+".$user['expired']." days", time() ) )?></td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-muted">
					รายละเอียด:<br>
					สำหรับพอร์ต ที่ใช้งานได้ ( 8080)<br>
                   คำเตือน!!! 1 บันชีห้ามใช้งานเกิน 2เครื่องในเวลาเดียวกัน ถ้าฝ่าฝื้นกฎ ระบบจะลบบันชีของคุณโดยอัตโนมัต
                </p>
                <div class="hidden-print">
					   <a href="/web/download.html" class="btn btn-warning"><i class="fa fa-download fa-fw"></i> โหลดไฟล์ openvpn</a>
					<a href="<?= base_url('panel/reseller/'.$_SESSION['username'].'/server') ?>" class="btn btn-default">ย้อนกลับ</a>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
