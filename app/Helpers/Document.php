<?php 


function default_placeholder(){
	return '/images/system/image_holder.png';
}


function format_file_path($file){

	$arr1 = explode('/', $file);
	$arr2 = array_slice($arr1, 1);
	$arr3 = implode('/', $arr2);

	return $arr3;
}

/**
 * Gets the carmake thumbnail.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The carmake thumbnail.
 */
function get_collection_thumbnail($filename){

	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/filters/'.$filename;

		}else{

			$path = 'storage/app/public/filters/'.$filename;

		}
	}
	

	return $path;
}

function get_condition_thumbnail($filename){

	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/filters/'.$filename;

		}else{

			$path = 'storage/app/public/filters/'.$filename;

		}
	}
	

	return $path;
}


/**
 * Gets the category thumbnail.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The category thumbnail.
 */
function get_category_thumbnail($filename){

	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/categories/'.$filename;

		}else{

			$path = 'storage/app/public/categories/'.$filename;

		}
	}

	return $path;
}

/**
 * Gets the product thumbnail.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The product thumbnail.
 */
function get_product_thumbnail($filename){

	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/products-thumbnails/'.$filename;

		}else{

			$path = 'storage/app/public/products-thumbnails/'.$filename;

		}
	}

	return $path;
}


/**
 * Gets the product inspiration image.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The product thumbnail.
 */
function get_product_inspiration($filename){

	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/products-inspiration/'.$filename;

		}else{

			$path = 'storage/app/public/products-inspiration/'.$filename;

		}
	}

	return $path;
}


/**
 * Gets the product images.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The product images.
 */
function get_product_images($filename){
	if (empty($filename)) {
		$path = default_placeholder();
	}else{
		if (App::environment('local')) {

			$path = 'storage/products/'.$filename;

		}else{

			$path = 'storage/app/public/products/'.$filename;

		}
	}

	return $path;
}

/**
 * Gets the attribute thumbnail.
 *
 * @param      <type>  $file_name  The file name
 *
 * @return     string  The attribute thumbnail.
 */
function get_attribute_thumbnail($filename){
	if (empty($filename)) {
		$file_path = default_placeholder();
	}else{
		// local
		if (App::environment('local')) {

			$file_path = 'storage/attributes/'.$filename;

		}else{

		// production
			$file_path = 'storage/app/public/attributes/'.$filename;
		}
	}

	return $file_path;
}



/**
 * Gets the blog thumbnail.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The blog thumbnail.
 */
function get_blog_thumbnail($filename){

	if (App::environment('local')) {
		
		$path = 'storage/blog/'.$filename;

	}else{

		$path = 'storage/app/public/blog/'.$filename;

	}

	return $path;
}


/**
 * Gets the ticket attachment.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The ticket attachment.
 */
function get_ticket_attachment($filename){

	if (App::environment('local')) {
		
		$path = 'storage/tickets/'.$filename;

	}else{

		$path = 'storage/app/public/tickets/'.$filename;

	}

	return $path;
}


/**
 * Gets the comment attachment.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The comment attachment.
 */
function get_comment_attachment($filename){

	if (App::environment('local')) {
		
		$path = 'storage/tickets/comments/'.$filename;

	}else{

		$path = 'storage/app/public/tickets/comments/'.$filename;

	}

	return $path;
}


/**
 * Gets the end user template.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The end user template.
 */
function get_end_user_template(){
	
	if (getenv('APP_ENV') == 'local') {
	// on local
		$image_path = "storage/documents/end-user-template.csv";
	}else{
	// on production
		$image_path = "storage/app/public/documents/end-user-template.csv";

	}


	return $image_path;
}


/**
 * Gets the product template.
 */
function get_product_template() {
	
	if (getenv('APP_ENV') == 'local') {
	// on local
		$image_path = "storage/documents/products.csv";
	}else{
	// on production
		$image_path = "storage/app/public/documents/products.csv";

	}

	return $image_path;
}


/**
 * Gets the pdf file.
 *
 * @param      <type>  $filename  The filename
 *
 * @return     string  The pdf file.
 */
function get_pdf_file($filename){
	
	if (getenv('APP_ENV') == 'local') {
	// on local
		$path = "storage/documents/".$filename;
	}else{
	// on production
		$path = "storage/app/public/documents/".$filename;

	}


	return $path;
}

/**
 * 
 * Get custom jewelry photo
 * 
 * */
function get_custom_jewelry_photo($filename){

	if (App::environment('local')) {

		$path = 'storage/custom-jewelry/'.$filename;

	}else{

		$path = 'storage/app/public/custom-jewelry/'.$filename;

	}

	return $path;
}



/**
 * Generates the video url for iframe
 *
 * @param      <type>  $url    The url
 *
 * @return     string  ( description_of_the_return_value )
 */
function generateVideoEmbedUrl($url){
    //This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
	$finalUrl = '';
	if(strpos($url, 'vimeo.com/') !== false) {
        //it is Vimeo video
		$videoId = explode("vimeo.com/",$url)[1];
		if(strpos($videoId, '&') !== false){
			$videoId = explode("&",$videoId)[0];
		}
		$finalUrl.='https://player.vimeo.com/video/'.$videoId;
	}else if(strpos($url, 'youtube.com/') !== false) {
        //it is Youtube video
		$videoId = explode("v=",$url)[1];
		if(strpos($videoId, '&') !== false){
			$videoId = explode("&",$videoId)[0];
		}
		$finalUrl.='https://www.youtube.com/embed/'.$videoId;
	}else if(strpos($url, 'youtu.be/') !== false){
        //it is Youtube video
		$videoId = explode("youtu.be/",$url)[1];
		if(strpos($videoId, '&') !== false){
			$videoId = explode("&",$videoId)[0];
		}
		$finalUrl.='https://www.youtube.com/embed/'.$videoId;
	}else{
        //Enter valid video URL
	}

	return $finalUrl;

	// if(strpos($url, 'facebook.com/') !== false) {
 //        //it is FB video
	// 	$finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
	// }
}

/**
 * Gets the video thumbnail.
 *
 * @param      <type>  $url    The url
 *
 * @return     string  The video thumbnail.
 */
function get_video_thumbnail($url){

	$videoUrl = '';

	if(strpos($url, 'vimeo.com/') !== false) {

		$data = json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url=' . $url));

		$videoUrl = $data->thumbnail_url;

	}else if(strpos($url, 'youtube.com/') !== false) {
        //it is Youtube video
		$videoId = explode("v=",$url)[1];
		if(strpos($videoId, '&') !== false){
			$videoId = explode("&",$videoId)[0];
		}
		$videoUrl =  'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
	}else if(strpos($url, 'youtu.be/') !== false){
        //it is Youtube video
		$videoId = explode("youtu.be/",$url)[1];
		if(strpos($videoId, '&') !== false){
			$videoId = explode("&",$videoId)[0];
		}
		$videoUrl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
	}

	return $videoUrl;

}