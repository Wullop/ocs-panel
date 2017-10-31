<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section id="#login">
    <div class="container">
        <div class="row ver-parent">
            <div class="col-md-4 col-md-offset-4 ver-center">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>
                <?php if (isset($error)) : ?>
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert"><?= $error ?></div>
					</div>
				<?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-sign-in fa-fw"></i> ใส่ข้อมูล เพื่อเข้าใช้งาน</h3>
                    </div>
                    <div class="panel-body">
                        <?= form_open() ?>
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                        <input class="form-control" placeholder="ชื่อผู้ใช้" name="username" type="text" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                        <input class="form-control" placeholder="รหัสผ่าน" name="password" type="password" required>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="เข้าสู่ระบบ"></input>
                            </fieldset>
                        </form>
                    </div>
                 
                </div>
                <p>ยังไม่มีบันชีผู้ใช้คลิก <a href="<?= base_url('panel/register') ?>">สมัคร</a></p>
            </div>
          
        </div>
  
    </div>
     
</section>
