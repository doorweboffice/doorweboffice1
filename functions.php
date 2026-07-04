<?php
/**
 * doorweboffice1 — FSE block theme
 * AI/GEO 최적화 레이어 포함
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'DOORWEBOFFICE1_VERSION', '5.1.0' );

/* -------------------------------------------------------------------------
 * 1. 테마 기본 support
 * ---------------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'post-thumbnails' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'doorweboffice1-style', get_stylesheet_uri(), array(), DOORWEBOFFICE1_VERSION );
} );

/* -------------------------------------------------------------------------
 * 2. 블록 패턴 카테고리
 * ---------------------------------------------------------------------- */
add_action( 'init', function () {
	register_block_pattern_category( 'doorweboffice1', array( 'label' => 'Doorweb Office 1' ) );
} );

/* -------------------------------------------------------------------------
 * 3. AI/GEO 레이어 — JSON-LD 스키마
 *    ⚠️ Rank Math / Yoast가 있으면 스키마 중복 출력 방지 위해 자동 비활성.
 *    필터로 강제 on/off 가능: add_filter('doorweboffice1_enable_schema', '__return_false');
 * ---------------------------------------------------------------------- */
function doorweboffice1_seo_plugin_active() {
	return (
		class_exists( 'RankMath' ) ||
		defined( 'WPSEO_VERSION' ) ||          // Yoast
		defined( 'AIOSEO_VERSION' ) ||          // All in One SEO
		class_exists( 'The_SEO_Framework\\Load' )
	);
}

add_action( 'wp_head', function () {
	$enabled = apply_filters( 'doorweboffice1_enable_schema', ! doorweboffice1_seo_plugin_active() );
	if ( ! $enabled ) { return; }

	$graph = array();

	// Organization
	$graph[] = array(
		'@type' => 'Organization',
		'@id'   => home_url( '/#organization' ),
		'name'  => get_bloginfo( 'name' ),
		'url'   => home_url( '/' ),
	);

	// WebSite (+ 검색 액션)
	$graph[] = array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'url'             => home_url( '/' ),
		'name'            => get_bloginfo( 'name' ),
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'inLanguage'      => get_bloginfo( 'language' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	// 현재 문서
	if ( is_singular() ) {
		global $post;
		$graph[] = array(
			'@type'         => 'WebPage',
			'@id'           => get_permalink() . '#webpage',
			'url'           => get_permalink(),
			'name'          => get_the_title(),
			'isPartOf'      => array( '@id' => home_url( '/#website' ) ),
			'inLanguage'    => get_bloginfo( 'language' ),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
		);
	}

	$json = wp_json_encode(
		array( '@context' => 'https://schema.org', '@graph' => $graph ),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);
	echo "\n<script type=\"application/ld+json\">{$json}</script>\n";
}, 20 );

/* -------------------------------------------------------------------------
 * 4. AI/GEO 레이어 — llms.txt 자동 서빙 (/llms.txt)
 *    LLM 크롤러에게 사이트 요약·핵심 링크 제공. (초안, 운영 시 내용 커스텀)
 * ---------------------------------------------------------------------- */
add_action( 'init', function () {
	add_rewrite_rule( '^llms\.txt$', 'index.php?doorweboffice1_llms=1', 'top' );
} );
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'doorweboffice1_llms';
	return $vars;
} );

// 테마 활성화 시 rewrite 자동 flush (구매자가 수동 저장 안 해도 /llms.txt 즉시 작동)
add_action( 'after_switch_theme', function () {
	add_rewrite_rule( '^llms\.txt$', 'index.php?doorweboffice1_llms=1', 'top' );
	flush_rewrite_rules();
} );

// llms.txt 본문 생성 (하루 transient 캐시 — 동적 반영 유지 + 매 요청 연산 제거)
function doorweboffice1_render_llms() {
	$cached = get_transient( 'doorweboffice1_llms_txt' );
	if ( false !== $cached ) { return $cached; }

	$name = get_bloginfo( 'name' );
	$desc = get_bloginfo( 'description' );
	$out  = "# {$name}\n\n";
	if ( $desc ) { $out .= "> {$desc}\n\n"; }
	$out .= "## 주요 링크\n";
	$out .= "- 홈: " . home_url( '/' ) . "\n";
	$out .= "- 사이트맵: " . home_url( '/sitemap.xml' ) . "\n";
	$out .= "\n(이 파일은 doorweboffice1 테마가 생성. 운영 시 회사 소개·핵심 페이지로 커스텀할 것.)\n";

	set_transient( 'doorweboffice1_llms_txt', $out, DAY_IN_SECONDS );
	return $out;
}
// 사이트 정보 바뀌면 캐시 무효화
add_action( 'update_option_blogname', function () { delete_transient( 'doorweboffice1_llms_txt' ); } );
add_action( 'update_option_blogdescription', function () { delete_transient( 'doorweboffice1_llms_txt' ); } );

add_action( 'template_redirect', function () {
	if ( ! get_query_var( 'doorweboffice1_llms' ) ) { return; }
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo doorweboffice1_render_llms();
	exit;
} );
