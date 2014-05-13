<?php 
include(APPPATH.'/views/templates/header.php');
?>
  <div class="wrap">

   
<script>
var site_url = '<?php echo base_url();?>';
</script>

  <?php if(isset($user_details)){ print_r($user_details); }?>
  <label>Comment: </label><textarea name="feed_text" id="feed_text" ></textarea>
  <input type="button" id="submit_feed" value="Post" />

<div class="upload_photo">
 
	<div class="upload_img_div" id="show_cover"> 
		<img src="http://www.collageheadz.com/images/upload_frame.png" />
	</div>
	<div class="upload_img_div drag_drop_image" style="display:none">
		<div class="drag_box" style="background-image:none;">
			<div>
				<span class="btn btn-success fileinput-button" style="background: url('http://www.collageheadz.com/img/drag.png') no-repeat scroll center center transparent; height: 250px; width: 250px;">
					<!-- The file input field used as target for the file upload widget -->
					<input id="fileupload" type="file" name="files[]" multiple style="width: 100%; height: 100%;" />
				</span>
			</div> 
		</div>              
	</div>
	<a onclick="upload_img()" href="Javascript:void(0)" class="upload_buton">UPLOAD</a>
</div>



    <div class="main-container">
      <div class="container-lt">
       
       <?php foreach ($feeds as $feed){
			echo $feed;
		}
		?>
       
      </div>
      <!--container-lt closed-->
      <div class="container-rt">
        <div class="container-inner">
          <div class="progress_wrap">
            <h5>Filter heavenly or sinful confessions</h5>
            <div class="progress_w">
              <div class="icon_hev_left"></div>
              <div class="icon_hev_right"></div>
              <input type="text" data-slider="true" data-slider-theme="volume">
            </div>
            <script>
  $("[data-slider]")
    .each(function () {
      var input = $(this);
      $("<span>")
        .addClass("output")
        .insertAfter($(this));
    })
    .bind("slider:ready slider:changed", function (event, data) {
      $(this)
        .nextAll(".output:first")
          .html(data.value.toFixed(3));
    });
  </script>
          </div>
        </div>
        <div class="container-inner">
          <div class="list">
            <ul>
              <li><a href="#"><span><img src="<?php echo base_url();?>theme/images/all.png" alt="" /></span>Everyone</a></li>
              <li><a href="#"><span><img src="<?php echo base_url();?>theme/images/following.png" alt="" /></span>Following</a></li>
              <li class="bdr-btm0"><a href="#"><span><img src="<?php echo base_url();?>theme/images/followers.png" alt="" /></span>Followers</a></li>
            </ul>
          </div>
        </div>
        <!--container-inner closed-->
      </div>
      <!--container-rt closed-->
    </div>
    <!--main-container closed-->
  </div>
</div>
<?php 
	include(APPPATH.'/views/templates/footer.php');
?>
