jQuery(document).ready(function() {
	jQuery(".single-our-team .post-meta").remove();
		
	var scrollMe = function(){
		var winWidth = jQuery(window).width();
		if(parseInt(winWidth) >= 960){
			
			singlepostImageHeight = jQuery(".et_pb_column.et_pb_column_3_5").height();
			
			profiewidth = jQuery(".et_pb_column.et_pb_column_2_5").width();
			profieHeight = jQuery(".et_pb_column.et_pb_column_2_5").width();
			
			if(singlepostImageHeight > profieHeight){
				jQuery(".et_pb_column.et_pb_column_2_5 .profile_wrap").width(profiewidth);
				jQuery('.single-our-team .et_post_meta_wrapper.et_pb_column.et_pb_column_2_5').height(singlepostImageHeight);
				jQuery(window).scroll(function(){
					if(jQuery(this).scrollTop() >= 50 && ( parseInt(jQuery(this).scrollTop()) + parseInt(jQuery('.single-our-team .profile_wrap').outerHeight())) > (jQuery("#main-footer").offset().top - 77)){
						jQuery('.single-our-team .profile_wrap').removeClass("fixed");
						jQuery('.single-our-team .profile_wrap').addClass("bottom")
					}else if (jQuery(this).scrollTop() > 50) {
						jQuery('.single-our-team .profile_wrap').addClass('fixed');
						jQuery('.single-our-team .profile_wrap').removeClass("bottom")
					}else{
						jQuery('.single-our-team .profile_wrap').removeClass("fixed");
						jQuery('.single-our-team .profile_wrap').removeClass("bottom")
					}
				});
			}
		}else{
			jQuery('.single-our-team .profile_wrap').width("auto"),
			jQuery('.single-our-team .profile_wrap').parent().outerHeight("auto")
			jQuery('.single-our-team .profile_wrap').removeClass("fixed");
			jQuery('.single-our-team .profile_wrap').removeClass("bottom")
		}
	}
	scrollMe();
});