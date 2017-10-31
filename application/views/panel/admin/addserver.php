<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
               เพิ่มเซิฟร์เวอร์
            </h3>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
				<?php if (isset($message)) { echo $message; }?>               
            </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-gear fa-fw"></i> ตั้งค่าเซิฟร์เวอร์
                </div>
                <div class="panel-body">
                    <form action="<?= base_url('panel/administrator/'.$_SESSION['username'].'/'.'addserver') ?>" method="POST">
                        <div class="form-group">
                            <label>ตั้งชื่อ</label>
                            <input class="form-control" placeholder="Server Demo" name="ServerName" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>ที่ตั้งเซิฟร์เวอร์</label>
                            <input class="form-control" placeholder="Location Demo" name="Location" type="text" required>     
                        </div>
                        <div class="form-group">
                            <label>โฮส IP</label>
                            <input class="form-control" placeholder="192.168.1.1 atau www.example-server.com" name="HostName" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>ราคาที่เปิดเช่า</label>
                            <div class="input-group">
                                <span class="input-group-addon">บาท</span>
                                <input class="form-control" placeholder="ใส่จำนวนเต็มสิบ" name="Price" type="number" step="10" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>รหัสผ่านเซิฟร์เวอร์</label>
                            <input class="form-control" placeholder="ใส่รหัสรูทจากเซิฟที่เช่า" name="RootPasswd" type="text">
                        </div>
                        <input type="submit" class="btn btn-primary" value="เพิ่ม">
                        <a href="<?= base_url('panel/administrator/'.$_SESSION['username'].'/'.'server') ?>" class="btn btn-default">กลับ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
