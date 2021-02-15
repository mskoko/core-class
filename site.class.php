<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *   file                 :  site.class.php
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *   author               :  Muhamed Skoko - info@mskoko.me
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Site {

	public function SiteConfig($id=1) {
		global $DataBase;

		$DataBase->Query("SELECT * FROM `site_settings` WHERE `id`=:ID");
		$DataBase->Bind(':ID', $id);
		$DataBase->Execute();

		return $DataBase->Single();
	}

	/* Create folder */
	public function createFolder($Path) {
		global $Site;

	    if (is_dir($Path)) return true;
	    $prev_path = substr($Path, 0, strrpos($Path, '/', -2) + 1);
	    $return = $Site->createFolder($prev_path);
	    return ($return && is_writable($prev_path)) ? mkdir($Path) : false;
	}

	// return true if already folder | Ako folder postoji vrati true;
	public function isFolder($fName) {
		if (is_dir($fName)) {
			return true;
		} else {
			return false;
		}
	}

	// Initialize head tag
	public function initHead($t, $postID='') {
		global $Site;

		$siteInfo 	= @$Site->SiteConfig();
		$head 		= '';

		// Global
		$fbID 			= '';
		$siteName 		= $siteInfo['site_name'];
		$Region 		= 'ME';
		$twitterUser 	= '@mskokome';
		$verByGoogle 	= '';
		// Initialize..
		if($t == 'home') { // HOME
			$siteImage 		= $siteInfo['site_image'];
			$Title 			= $siteInfo['site_name'];
			$Description 	= $siteInfo['site_desc'];

		} else if($t == 'post') { // POST
			if(!empty($postID)) {
				// Post info
				$postInfo 		= @[];
				// set ..
				$siteImage 		= (empty($postInfo['post_image']) 		? $siteInfo['site_image'] 	: $postInfo['post_image']);
				$Title 			= (empty($postInfo['post_title']) 		? $siteInfo['site_name'] 	: $postInfo['post_title']);
				$Description 	= (empty($postInfo['post_description']) ? $siteInfo['site_desc'] 	: $postInfo['post_description']);
			} else {
				$siteImage 		= $siteInfo['site_image'];
				$Title 			= $siteInfo['site_name'];
				$Description 	= $siteInfo['site_desc'];
			}
		}

		// HEAD TEMPLATE
		$head .= '<meta charset="UTF-8">';
		$head .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
		$head .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
		$head .= '<meta name="revisit-after" content="1 days">';


		// General meta tags
		$head .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>';
		$head .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>';
		$head .= '<meta name="theme-color" content="#240041"/>';
		$head .= '<title>'.$Title.'</title>';


		// Regular meta tags
		$head .= '<meta name="description" content="'.$Description.'"/>';
		$head .= '<meta name="rating" content="general"/>';
		$head .= '<meta http-equiv="content-language" content="en-US"/>';
		$head .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
		$head .= '<meta name="format-detection" content="telephone=no">';
		$head .= '<meta name="geo.region" content="'.$Region.'"/>';


		// Facebook
		$head .= '<meta property="fb:app_id" content="'.$fbID.'"/>';
		// Open graph
		$head .= '<meta property="og:site_name" content="'.$siteName.'"/>';
		$head .= '<meta property="og:image" content="'.$siteImage.'"/>';
		$head .= '<meta property="og:title" content="'.$Title.'">';
		$head .= '<meta property="og:description" content="'.$Description.'"/>';
		$head .= '<meta property="og:url" content=""/>';
		$head .= '<meta property="og:type" content="website"/>';


		// Dublin Core
		$head .= '<meta name="DC.title" content="'.$Title.'">';


		// Tweeter cards
		$head .= '<meta name="twitter:card" content="summary"/>';
		$head .= '<meta name="twitter:site" content="'.$twitterUser.'"/>';
		$head .= '<meta name="twitter:image" content="'.$siteImage.'"/>';
		$head .= '<meta name="twitter:title" content="'.$Title.'">';
		$head .= '<meta name="twitter:description" content="'.$Description.'"/>';


		// Google meta
		$head .= '<meta itemprop="image" content="'.$siteImage.'"/>';
		$head .= '<meta itemprop="title" content="'.$Title.'">';
		$head .= '<meta itemprop="description" content="'.$Description.'"/>';


		// Open Directory
		$head .= '<meta name="googlebot" content="noodp"/>';
		$head .= '<meta name="slurp" content="noydir"/>';
		$head .= '<meta name="msnbot" content="noodp"/>';

		$head .= '<meta name="google-site-verification" content="'.$verByGoogle.'"/>';


		// FAVICONS
		$head .='<link rel="icon" type="image/x-icon" href="/assets/static/icon/favicon.ico">';
		$head .='<link rel="icon" type="image/x-icon" href="/assets/static/icon/favicon-edge.ico">';
		$head .='<link rel="icon" type="image/png" sizes="16x16" href="/assets/static/icon/favicon-16x16.png">';
		$head .='<link rel="icon" type="image/png" sizes="32x32" href="/assets/static/icon/favicon-32x32.png">';
		$head .='<link rel="icon" type="image/png" sizes="144x144" href="/assets/static/icon/android-icon-144x144.png">';
		$head .='<link rel="icon" type="image/png" sizes="150x150" href="/assets/static/icon/ms-icon-150x150.png">';

		// ANDROID
		$head .='<link rel="icon" type="image/png" sizes="48x48" href="/assets/static/icon/android-icon-48x48.png">';
		$head .= '<link rel="icon" type="image/png" sizes="96x96" href="/assets/static/icon/android-icon-96x96.png">';
		$head .= '<link rel="icon" type="image/png" sizes="144x144" href="/assets/static/icon/android-icon-144x144.png">';
		$head .= '<link rel="icon" type="image/png" sizes="192x192" href="/assets/static/icon/android-icon-192x192.png">';

		// IOS
		$head .= '<link rel="apple-touch-icon" sizes="57x57" href="/assets/static/icon/apple-icon-57x57.png">';
		$head .= '<link rel="apple-touch-icon" sizes="60x60" href="/assets/static/icon/apple-icon-60x60.png">';
		$head .= '<link rel="apple-touch-icon" sizes="72x72" href="/assets/static/icon/apple-icon-72x72.png">';
		$head .= '<link rel="apple-touch-icon" sizes="76x76" href="/assets/static/icon/apple-icon-76x76.png">';
		$head .= '<link rel="apple-touch-icon" sizes="114x114" href="/assets/static/icon/apple-icon-114x114.png">';
		$head .= '<link rel="apple-touch-icon" sizes="120x120" href="/assets/static/icon/apple-icon-120x120.png">';
		$head .= '<link rel="apple-touch-icon" sizes="152x152" href="/assets/static/icon/apple-icon-152x152.png">';
		$head .= '<link rel="apple-touch-icon" sizes="180x180" href="/assets/static/icon/apple-icon-180x180.png">';


		// ..
		$head .= '<link rel="canonical" 					href="https://'.$_SERVER['HTTP_HOST'].'" />';

		// Author
		$head .= '<meta name="author" 					content="Muhamed Skoko | mskoko.me@gmail.com" />';

		return $head;
	}



}