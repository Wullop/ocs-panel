<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">รายการเซิร์ฟเวอร์</h3>
            <div class="dropdown pull-right">
				<button><a href="<?= base_url('panel/reseller/'.str_replace(' ','-',$_SESSION['username']).'/addsaldo-via-hp') ?>">เติมเครดิต</a></button>
            </div>
            
        </div>
    </div>
    <div class="row">
       <div class="col-xs-6 col-md-5 col-md-4 col-lg-3">
            <div class="well">เครดิต : <B><?= $user -> saldo ?></B></div>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
                <?php if (isset($message)) {echo $message; }?>
            </div>
        <?php foreach($server as $row): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b><?= $row['ServerName']?></b> <?php if ($row['Status']) { echo '';} else {echo "(Locked)";}?>
                    </div>
                    <table class="table">
                        <tr>
                            <td>ประเทศ</td><td><?= $row['Location']?></b></td>
                        </tr>
                        <tr>
                            <td>โฮส</td><td><?= $row['HostName']?></b></td>
                        </tr>
                        <tr>
                            <td>ราคา</td><td><?= $row['Price']?></b></td>
                        </tr>
                    </table>
                    <div class="panel-footer text-center">
                        <a href="/web/download.html" class="btn btn-warning"><i class="fa fa-download fa-fw"></i> Ovpn Download</a>
                        <a href="<?= base_url('panel/seller/'.$_SESSION['username'].'/buy/'.str_replace(' ','-',$row['ServerName']).'/'.$row['Id']) ?>" class="btn btn-primary"><i class="fa fa-shopping-cart fa-fw"></i> เช่า</a>
                        <!-- <a href="http://{{ @server->host }}:81/vpn-config.rar" class="btn btn-default"><i class="fa fa-download fa-fw"></i> VPN Config</a> -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
