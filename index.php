<?php 

function image_3d_after_single_product_action(){
	echo do_shortcode("[image_3d]");
}
//add_action( 'woocommerce_after_single_product', 'image_3d_after_single_product_action' );
add_action( 'woocommerce_product_thumbnails', 'image_3d_after_single_product_action' );

function image_3d() {
	if( is_product() ){
		global $post;
		$productId = $post->ID;
        $videoId = get_post_meta( $productId, "video_3d", true );
		$videoUrl = wp_get_attachment_url($videoId);
		if( $videoUrl ){
			return "
			<div class='product-3d-wrapper'>
				<div class='product-3d-toggler'>
					<img src='/wp-content/uploads/2022/10/3d-modeling.png' />
					<span>Vista 3D</span>
				</div>
				
				<div class='product-3d-video'>
					<video loop muted='muted'>
						<source src='".$videoUrl."' type='video/mp4'>
						Your browser does not support the video tag.
					</video>
				</div>
				
				<script>
				
				let product3DVideo = null;
				
				document.addEventListener('DOMContentLoaded', function() {
					//checkVideoPLayThrough();
					
					enable3dVideo();
				});
				
				const getProduct3DVideo = () => {
					if( product3DVideo === null ){
						product3DVideo = document.querySelector('.product-3d-video video');
					}
					return product3DVideo;
				}
				
				const enable3dVideo = () => {
					activateProductVideo();
					setTimeout( () => {
						enableVideoToggler();
						
						productVideoWithPlaybackRate();
						productVideoWithHoverEvents();
					}, 500);
				}; 
				
				const activateProductVideo = () => {
					const product3DVideoWrapper = document.querySelector('.product-3d-wrapper');
					const firstProductImage = document.querySelector('.woocommerce-product-gallery__wrapper').children[0];
					firstProductImage.appendChild(product3DVideoWrapper);
				}
				
				const enableVideoToggler = () => {
					const videoToggler = document.querySelector('.product-3d-toggler')
					videoToggler.addEventListener('click', () => {
					
    					const product3DVideoContainer = document.querySelector('.product-3d-video');
						const videoVisible = product3DVideoContainer.style.display === 'flex';
						toggleVideo(product3DVideoContainer, !videoVisible);
					});
				}
				
				const toggleVideo = (container, show) => {
					if(show){
						showVideo(container);
					}
					else{
						hideVideo(container);
					}
				}
				
				const showVideo = (container) => {
					const videoTogglerSpan = document.querySelector('.product-3d-toggler span');
					videoTogglerSpan.innerHTML = 'Volver';
					container.style.display = 'flex';
					getProduct3DVideo().play();
				}
				
				const hideVideo = (container) => {
					const videoTogglerSpan = document.querySelector('.product-3d-toggler span');
					videoTogglerSpan.innerHTML = 'Vista 3D';
					container.style.display = 'none';
					getProduct3DVideo().pause();
					getProduct3DVideo().currentTime = 0;
				}
				
				const productVideoWithPlaybackRate = () => {
					getProduct3DVideo().playbackRate = 0.5;
				}
				
				const productVideoWithHoverEvents = () => {
					getProduct3DVideo().addEventListener('mouseover', function() {
						this.pause();
					});

					getProduct3DVideo().addEventListener('mouseleave', function() {
						this.play();
					});
				}
				
				</script>
				
				<style>
				
				.product-3d-toggler {
					bottom: 10px;
					cursor: pointer;
					position: absolute;
					right: 10px;
					z-index: 101;
					background: white;
					border-radius: 10px;
    				padding: 5px;
					display: flex;
					flex-direction: column;
    				align-items: center;
				}

				.product-3d-toggler img {
					position: relative;
					width: 50px !important;
					height: 50px !important;
					z-index: 101;
				}
				
				.product-3d-wrapper {
					position: absolute;
					top: 0px;
					height: 100%;
					width: 100%;
				}
				
				.product-3d-video {
					width: 100%;
					height: 100%;
					display: none;
					background: white;
					justify-content: center;
					position: relative;
					z-index: 100;
				}
				
				</style>
			</div>
			";
		}
		return "No video";
		
	}
	return "No product";
}
add_shortcode('image_3d', 'image_3d');

?>