<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">รายชื่อเซิร์ฟเวอร์
				<?php if (isset($_SESSION['is_admin'])): ?>
                <a href="<?= base_url('panel/administrator/'.str_replace(' ','-',$_SESSION['username']).'/addserver') ?>" class="btn btn-default pull-right"><i class="fa fa-plus fa-fw"></i> เพิ่ม</a>
                <?php endif; ?>
            </h1>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
                <?php if (isset($message)) { echo $message;} ?>
            </div>
        <?php foreach($server as $row): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="panel panel-default">
					 
                    <div class="panel-heading">
                       
							<div class="panel-title"><b><?= $row['ServerName']?></b></div>
							<span clas="pull-right">
							<?php if ($row['Status']): ?>
								<a class="btn btn-default btn-sm pull-right" href="<?= base_url('panel/administrator/edit/'.str_replace(' ','-',$row['ServerName']).'/'.$row['Id'].'/lock' ) ?>"><i class="fa fa-unlock"></i> ล็อก</a>
								<?php else: ?>
								<a class="btn btn-default btn-sm pull-right" href="<?= base_url('panel/administrator/edit/'.str_replace(' ','-',$row['ServerName']).'/'.$row['Id'].'/unlock' ) ?>"><i class="fa fa-lock"></i>  ปลดล็อก</a>
								<?php endif; ?>
							</span>
                    </div>
                    <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <td>ประเทศ</td><td><?= $row['Location']?></td>
                        </tr>
                        <tr>
                            <td>โฮส</td><td><?= $row['HostName']?></td>
                        </tr>
                        <tr>
                            <td>ราคา</td><td><?= $row['Price']?></td>
                        </tr>
                    </table>  
                    </div>
						
                    <div class="panel-footer text-center">
                        <a href="<?= base_url('panel/administrator/edit/'.str_replace(' ','-',$row['ServerName']).'/'.$row['Id'])?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i> แก้ไข</a>
                        <a href="<?= base_url('admin/cekuser/'.$row['Id']) ?>" class="btn btn-default btn-sm"><i class="fa fa-group fa-fw"></i> ตรวจสอบผู้ใช้</a>
                        <a href="<?= base_url('panel/administrator/edit/'.str_replace(' ','-',$row['ServerName']).'/'.$row['Id'].'/del' ) ?>" class="btn btn-danger btn-sm hapus pull-right"> ลบ</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
