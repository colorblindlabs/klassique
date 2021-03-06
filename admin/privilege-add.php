<?php include("header.php"); ?>

<script>
$(document).ready(function() {
  $("#main-nav li.top-<?php echo $theMenu['url']; ?>").find("a").addClass("active");
  <?php if(isset($theSubMenu)) { ?>
  $(".side-menu li.left-<?php echo $theSubMenu['url']; ?>").find("a").addClass("current");
  <?php }?>

		// Jquery Validate
		$('form#validate').validate({
			rules: {
				name:{
					required: true
				}
			},
			messages: {
				name:{
					required:"* This field can't be empty."
				}
			}
		});

});
</script>

<style>
	.check_wrap { float:left; font-weight:600; margin-right:20px;}
	.check_wrap label { float:right; margin-right:1px; margin-left:2px; margin-top: -7px; width:100px; font-size:11px;}
	input.checkInput { width:10px;}
	.clearp { clear:both; height:10px;}
</style>

<div id="cms-content" class="clearfix">
	<?php show_left_menu($theMenu);?>
	<div class="cms-main-content right">
		<?php check_privileges(); ?>
		<div class="cm-top">
			<h2><a href="<?php echo $baselink?>"><?php echo $title_h2;?></a> &raquo; Add New</h2>
		</div><!-- .cm-top -->
		<div class="cm-mid">
  
			<form action="lib/privilege-add-action.php" method="post" class="general-form" id="validate">
				<table cellspacing="0" cellpadding="0" class="browse-table">
					<tr>
						<td class="td1"><label for="name_member22">Name</label></td>
						<td><input id="name_member22" type="text" name="name" maxlength="200" value="" /></td>
					</tr>

					<tr>
						<td class="td1"><label for="dash_akses">Hak Akses</label></td>
						<td style="line-height:25px;">
							<?php 
              $arr_top_menu = global_select("m3nu_4dm1n", "*", "`top_or_left` = 'top' AND `publish` = 1", "`sortnumber`");
              if($arr_top_menu) { foreach($arr_top_menu AS $menu) { ?>
              	<input type="checkbox" name="menu[]" value="<?php echo $menu['url'];?>" id="<?php echo $menu['url'];?>" class="checkInput" /> <label style="display:inline;" for="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></label> <br />
              	<?php
                $arr_left_menu = global_select("m3nu_4dm1n", "*", "`top_parent_id` = '".$menu['id']."' AND `top_or_left` = 'left' AND `publish` = 1", "`sortnumber`");
                if($arr_left_menu) { foreach($arr_left_menu AS $sub_menu){ ?>
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu[]" value="<?php echo $menu['url'].'+'.$sub_menu['url'];?>" id="<?php echo $sub_menu['url'];?>" class="checkInput" /> <label style="display:inline;" for="<?php echo $sub_menu['url'];?>"><?php echo $sub_menu['name'];?></label> <br />
                <?php
              	}}
              }} 

              $arr_sub_level = global_select("m3nu_4dm1n", "*", "`top_or_left` = 'sub-level' AND `publish` = 1", "`sortnumber`");
              if($arr_sub_level) { ?>
              <hr /><h5>Sub Level Privilege</h5>
              	<?php foreach($arr_sub_level AS $menu) { ?>
              	<input type="checkbox" name="menu[]" value="<?php echo $menu['url'];?>" id="<?php echo $menu['url'];?>" class="checkInput" /> <label style="display:inline;" for="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></label> <br />
              	<?php }?>
              <?php 
            	} ?>
						</td>
					</tr>

					<tr>
						<td class="td1"></td>
						<td>
							<div class="btn-area clearfix">
								<input type="submit" name="submit" value="SAVE" class="submit-btn left" />
								<input type="reset" value="RESET" class="delete-btn left" />
								&nbsp;
								<img src="images/loading.gif" class="imgload" style="display:none;" />
							</div><!-- .btn-area -->
						</td>
					</tr>
				</table>
			</form>
		</div><!-- .cm-mid -->
	</div><!-- .cms-main-content -->
</div><!-- #cms-content -->
	
<?php include("footer.php"); ?>