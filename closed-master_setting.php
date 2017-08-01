<?php
/**
 * 关闭博客插件
 * design by Amanda
 */

!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view()
{
include(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php');
include (EMLOG_ROOT . "/content/plugins/closed-master/lang/".Option::get('language').".php");
?>
<div class="heading-bg  card-views">
<ul class="breadcrumbs">
<li><a href="./"><i class="fa fa-home"></i> <?php echo $lang["home"];?></a></li>
<li class="active"><?php echo $lang["blog_set"];?></li>
</ul>
</div>
<?php if(isset($_GET['setting'])):?>
<div class="actived alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $lang["blog_set_ok"];?>
</div>
<?php endif;?>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<div class="panel-body"> 
<?php echo $lang["blog_info"];?>
</div>
<div class=line></div>
<?php
if (CLOSED_YN == "Y") {
        $now = $lang["state_on"];
        if (MCLOSED_YN == "N") {//手机版状态显示
                $mnow = $lang["state_on"];
        } else if (MCLOSED_YN == "Y") {
                $mnow = $lang["state_off"];
        }
} else {
        $now = $lang["state_off"];
        $mnow = $lang["null"];
}
?>
<div class="form-group">
    <label><?php echo $lang["blog_state_"];?></label>
<font color=red><?php echo $now; ?></font>
  </div>
<div class="form-group">
    <label><?php echo $lang["mobile_state_"];?></label>
<font color=red><?php echo $mnow; ?></font>
  </div>  
<form id="form1" name="form1" method="post" action="plugin.php?plugin=closed-master&action=setting">
<div class="form-group">
    <label><?php echo $lang["answer_blog"];?></label>
<select name="yn">
	<option value="Y" <?php echo $ex1; ?>><?php echo $lang["mobile_off"];?></option>
	<option value="N" <?php echo $ex2; ?>><?php echo $lang["mobile_on"];?></option>
</select>
  </div>  
<div class="form-group">
    <label><?php echo $lang["answer_mobile"];?></label>
<select name="myn">
        <option value="Y" <?php echo $ex3; ?>><?php echo $lang["mobile_off"];?></option>
        <option value="N" <?php echo $ex4; ?>><?php echo $lang["mobile_on"];?></option>
</select>
  </div>  
<div class="form-group">
    <label><?php echo $lang["close_reason"];?></label>
    <br/>
<input type="input" name="be" id="post" value="<?php echo CLOSED_BE; ?>" class="form-control"/>
  </div>  
<div class="form-group" style="padding-top:10px">

	<input name="input" class="btn btn-info" type="submit" value="<?php echo $lang["close_btn"];?>" />
</div>

</form>
</div>

<?php
}

function plugin_setting()
{
	//修改配置信息
	$fso = fopen(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php','r'); //获取配置文件内容
	$config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php'));
	fclose($fso);

	$yn=htmlspecialchars($_POST['yn'], ENT_QUOTES);
	$myn=htmlspecialchars($_POST['myn'], ENT_QUOTES);
	$be=htmlspecialchars($_POST['be'], ENT_QUOTES);

	$patt = array(
	"/define\('CLOSED_YN',(.*)\)/",
	"/define\('MCLOSED_YN',(.*)\)/",
	"/define\('CLOSED_BE',(.*)\)/",
	);

	$replace = array(
	"define('CLOSED_YN','".$yn."')",
	"define('MCLOSED_YN','".$myn."')",
	"define('CLOSED_BE','".$be."')",
	);

	$new_config = preg_replace($patt, $replace, $config);
	$fso = fopen(EMLOG_ROOT.'/content/plugins/closed-master/closed-master_config.php','w'); //写入替换后的配置文件
        if(!$fso) {
            emMsg($lang["close_error"]);
        }
	fwrite($fso,$new_config);
	fclose($fso);
}
?>
<script>
setTimeout(hideActived,2600);
$("#menu_mg").addClass('active');
$("#menu_close").addClass('active-page');
</script>
